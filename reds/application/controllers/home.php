<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author user
 */
class home extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('modelcategory');
        $this->load->model('modelpost');
        $this->load->model('modelproduct');
        $this->load->model('modelmenu');
        $this->load->model('modelslider');
        $this->load->library('cart');
        $this->load->library('unit_test');
    }

    public function index() {
//        load themes from database
        $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
//        load and set title and meta data from database
        $data['title'] = $this->modelsetting->getdetailsetting(1)->title . '| Home ';
        $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->metaDescription;
        $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->metaKeyword;
        $data['load'] = $load;
//        init location folder themes
        $themes = 'themes/';
//        set path directory themes
        $data['path'] = base_url() . '' . $themes . '' . $load;
        $this->load->view($load . 'header', $data);
        $this->load->view($load . 'home');
        $this->load->view($load . 'footer');
    }

    function checkstok() {
//        $this->load->helper('json');
        $this->load->model("modelproduct");
        $idproduct = $_POST['idproduct'];
        $size = $_POST['size'];


        if (!empty($this->modelproduct->getRowDataProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product WHERE product.id_product='" . $idproduct . "' and size ='" . $size . "'")->stok)) {
            $data = @$this->modelproduct->getRowDataProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product WHERE product.id_product='" . $idproduct . "' and size ='" . $size . "'")->stok;
            $data1 = number_format(@$this->modelproduct->getRowDataProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product WHERE product.id_product='" . $idproduct . "' and size ='" . $size . "'")->prices);
            $data2 = @$this->modelproduct->getRowDataProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product WHERE product.id_product='" . $idproduct . "' and size ='" . $size . "'")->id_product_detail;
        } else {
            $data = 'Please Choose Size to see Stok';
            $data1 = "-";
            $data2 = 0;
        }
        $this->json_data['data'] = $data;
        $this->json_data['data1'] = $data1;
        $this->json_data['data2'] = $data2;
        echo json_encode($this->json_data);
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(base_url(), '');
    }

    function addtowish() {
        $idmember = $_POST['idmember'];
        $idproduct = $_POST['idproduct'];
        $this->load->model('modelwishlist');
        $this->load->helper('json');
        $chek = @$this->modelwishlist->getwhislistprod($idmember, $idproduct)->idwishlist;
        if (empty($chek)) {
            date_default_timezone_set('Asia/Jakarta');
            $timenow = date('r');
            $tgl_input = date('Y-m-d H:i:s', strtotime($timenow));
            $this->modelwishlist->insertwishlist('', $idmember, $idproduct, $tgl_input, '');
            $alert = 'Add to Whishlist';
        } else {
            $alert = "Data Products has been in Your List";
        }
        $content = "";
        $row = $this->modelwishlist->getSumwisthlist($idmember)->jumlah;
        $this->json_data['data'] = $row;
        $this->json_data['notif'] = $alert;

        echo json_encode($this->json_data);
    }

    function sendTomailmember($message, $emails, $subject) {
        $this->load->model('modelsetting');

        $row = $this->modelsetting->getDetailSetting(1);

        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from(@$row->emails, @$row->title);
        $this->email->to($emails);
        $this->email->subject('Your List Order ' . @$row->title);
        $this->email->message($message);
        $this->email->send();
    }

    function sendTomailadmin($message, $emails, $name) {
        $this->load->model('modelsetting');

        $row = $this->modelsetting->getDetailSetting(1);

        $this->load->library('email');
        $this->email->from($emails, $name);
        $this->email->to(@$row->emails);
        $this->email->subject('Request Order Customer ' . @$row->title);
        $this->email->message($message);
        $this->email->send();
    }

    function checkout() {
        $this->load->library('cart');
        $idmember = $this->session->userdata('idmember');
    }

    function getselectqty() {
        $options = array();
        for ($i = 1; $i < 9; $i++) {
            $options[$i] = $i;
        }
        return $options;
    }

    function addcartsdetailproduct() {
        $this->load->library('cart');
//        $this->load->helper('json');
        $this->load->model("modelproduct");

        $content = '';
        $idproduct = $_POST['idproduct'];
        $quantity = $_POST['quantity'];
        $size = $_POST['size'];
        $id_product_detail = $_POST['id_product_detail'];
        $rowproduct = $this->modelproduct->getRowDataProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product WHERE product.id_product='" . $idproduct . "' and size ='" . $size . "'");
//        $detailproduct = @$this->modeldetailproduct->getstok($idproduct, $size);
        if ($rowproduct->stok > 0) {
            if (!empty($rowproduct->diskon)) {
                $diskon = str_replace(',', '', $rowproduct->prices) * $rowproduct->diskon / 100;
                $prices = str_replace(',', '', $rowproduct->prices) - $diskon;
            } else {
                $prices = $rowproduct->prices;
            }
            $data = array(
                'id' => $id_product_detail,
                'qty' => $quantity,
                'price' => $prices,
                'name' => $rowproduct->title,
                'options' => array('Size' => $rowproduct->size, 'idproduct' => $idproduct)
            );
            $this->cart->insert($data);

            $this->json_data['content'] = $data;
            $this->json_data['data'] = '<a href="' . base_url() . 'checkout"><span class="glyphicon glyphicon-shopping-cart"></span> My Bag:  ' . $this->cart->total_items() . '  item(s)</a>';
        } else {
            $this->json_data['content'] = $content;
            $this->json_data['data'] = '<a href=' . base_url() . 'checkout"><span class="glyphicon glyphicon-shopping-cart"></span> My Bag:  ' . $this->cart->total_items() . '  item(s)</a>';
        }

        echo json_encode($this->json_data);
    }

    function getLoadCategoryProduct() {
        $this->load->model('modelproduct');
        $pages = $_POST['pages'];
        $sortby = $_POST['sortby'];
        $showno = $_POST['showno'];
        if (!empty($_POST['rangeprice'])) {
            $rangeprice = $_POST['rangeprice'];
            $dataprice = explode(',', $rangeprice);
            $statemetPrice = "AND prices BETWEEN '$dataprice[0]000' AND '$dataprice[1]000'";
        } else {
            $statemetPrice = "";
        }
        $idcategory = $_POST['idcategory'];
        $contentPagin = '<ul class="pagination">';
        if ($idcategory != 0) {
            $condition = "WHERE id_category='$idcategory'  ";
        } else {
            $condition = "";
        }
        if ($sortby == 'default') {
            $sort_by = 'product.id_product DESC';
        } else if ($sortby == 'title') {
            $sort_by = 'title ASC';
        } else {
            $sort_by = "prices " . $sortby;
        }
        $queryCoutPage = $this->modelproduct->getRowDataProductCustome($condition, "COUNT(id_product)as count_product")->count_product;
        $count_page = ceil($queryCoutPage / $showno);
        for ($i = 1; $i <= $count_page; $i++) {
            if (($i - 1) == $pages) {
                $class = 'class="active"';
            } else {
                $class = "";
            }
            $contentPagin.='<li ' . $class . '><a href="#category-products" onclick="getLoadCategoryProduct(' . ($i - 1) . ');">' . $i . '</a></li>';
        }
        $contentPagin.='<li>
            <a href="#category-products" onclick="getLoadCategoryProduct(' . $count_page . ');">
                <i class="glyphicon glyphicon-chevron-right"></i>
                </a>
                </li>
            </ul>';
        $contentProduct = '';

        if ($pages != 0) {
            $pages_data = $showno;
            $showno_data = $pages * $showno;
        } else {
            $pages_data = $pages;
            $showno_data = $showno;
        }


        $queryCategoryProduct = $this->modelproduct->getListProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product  $condition $statemetPrice GROUP  BY title order by $sort_by  LIMIT $pages_data,$showno_data");
        foreach ($queryCategoryProduct->result()as $rowCategoryProduct) {
            $contentProduct.='<article class="category-article category-grid col-sm-4">

                            <figure>
                                <img src="' . $rowCategoryProduct->main_images . '" alt="' . $rowCategoryProduct->title . '" />
                                <div class="figure-overlay">

                                    <a style="top:45%;" href="' . base_url() . 'detailproduct/' . $rowCategoryProduct->url . '"><button class="btn btn-default custom-button" >Add to Bag</button></a>

                                </div>
                            </figure>
                            <div class="text">
                                <h2><a href="' . base_url() . 'detailproduct/' . $rowCategoryProduct->url . '">' . $rowCategoryProduct->title . '</a></h2>
                                <div class="price">
                                    
                                    <span class="new-price">Rp. ' . number_format($rowCategoryProduct->prices) . '</span>
                                </div>
                            </div>
                        </article>';
        }
        $this->json_data['contentProduct'] = $contentProduct;
        $this->json_data['contentPagin'] = $contentPagin;
        echo json_encode($this->json_data);
    }

    function sendComment() {
        $this->load->model('modelpost');
        $subject = $_POST['subjects'];
        $id_parent_comment = $_POST['id_parent_comment'];
        $comments = str_replace("'", '&#39;', $_POST['comments']);
        ;
        $emails = $_POST['emails'];
        $usernamesComment = $_POST['usernamesComment'];
        $idpost = $_POST['idpost'];
        $this->modelpost->inserPostComment('', $subject, $comments, $usernamesComment, $emails, $idpost, $id_parent_comment);
    }

}

?>
