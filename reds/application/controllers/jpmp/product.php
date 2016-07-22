<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product
 *
 * @author user
 */
class product extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            if (!empty($_GET['id'])) {
                $id_product = $_GET['id'];
            } else {
                $id_product = 0;
            }
            $this->load->model('modelproduct');
            $this->load->model('modelcategory');
            $this->load->helper('form');
            $data['id_product'] = $id_product;
            $data['tablecontent'] = $this->tablecontent();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/product', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function tablecontent() {
        $this->load->model('modelproduct');
        $content = '';
        $querytable = $this->modelproduct->getListProduct(' order by id_product DESC');
        $no = 1;
        foreach ($querytable->result() as $rowtable) {
            if (!empty($rowtable->main_images)) {
                $image = '<img src="' . urldecode($rowtable->main_images) . '" style="max-width: 50px;"/>';
            } else {
                $image = '';
            }
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->title . '</td>
                                        <td class="text-center">' . $image . '</td>
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/product?id=' . $rowtable->id_product . '"><i class="fa fa-edit" title="view & edit" style="cursor:pointer;"  ></i></a> / '
                    . '                 <a href="' . base_url() . 'jpmp/product/delete?id=' . $rowtable->id_product . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a>
                                        </td>
                                    </tr>';
        }
        return $content;
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelproduct');
            $id_product = $_POST['id_product'];
            $title = $_POST['title'];
            $id_category = $_POST['id_category'];
            $description = $_POST['description'];
            $images = $_POST['images'];
            $diskon = $_POST['diskon'];
            $allsize = $_POST['allsize'];
            $metaTag = $_POST['metatag'];
            $images1=$_POST['images1'];
            $images2=$_POST['images2'];
            $images3=$_POST['images3'];
            $metaDescription = $_POST['matadescription'];
            $product_random = $this->modelproduct->getrandom();
            if ($id_product == 0) {
                if ($allsize == 1) {
                    $prices = $_POST['price'];
                    $stok = $_POST['stock'];
                    $checkurl = @$this->modelproduct->getRowDataProduct("WHERE title='$title' order by id_product ASC")->url;

                    $this->modelproduct->insertProduct($title, $description, $id_category, $images, $metaTag, $metaDescription, $product_random,$images1,$images2,$images3);
                    $id_product = $this->modelproduct->getRowDataProduct("WHERE product_random='$product_random'")->id_product;
                    if (!empty($checkurl)) {
                        $url = url_title($title . '-' . $id_product);
                    } else {
                        $url = url_title($title, '-');
                    }
                    $this->modelproduct->updateProductUrl($id_product,$url);
                    $this->modelproduct->insertProduct_detail('allsize', $prices, $stok, $id_product, $diskon);
                    echo '<script type="text/javascript">'
                    . 'alert("Data Saved");'
                    . 'document.location.href="' . base_url() . 'jpmp/product"'
                    . '</script>';
                } else {
                    $checkurl = @$this->modelproduct->getRowDataProduct("WHERE title='$title' order by id_product ASC")->url;
                    $this->modelproduct->insertProduct($title, $description, $id_category, $images, $metaTag, $metaDescription, $product_random,$images1,$images2,$images3);
                    $id_product = $this->modelproduct->getRowDataProduct("WHERE product_random='$product_random'")->id_product;
                    if (!empty($checkurl)) {
                        $url = url_title($title . '-' . $id_product);
                    } else {
                        $url = url_title($title, '-');
                    }
                     $this->modelproduct->updateProductUrl($id_product,$url);
                    for ($i = 0; $i <= 6; $i++) {
                        if (!empty($_POST['size_' . $i]) && !empty($_POST['price_' . $i]) && !empty($_POST['stock_' . $i])) {
                            $prices = $_POST['price_' . $i];
                            $stok = $_POST['stock_' . $i];
                            $size = $_POST['size_' . $i];
                            $this->modelproduct->insertProduct_detail($size, $prices, $stok, $id_product, $diskon);
                        }
                    }
                    echo '<script type="text/javascript">'
                    . 'alert("Data Saved");'
                    . 'document.location.href="' . base_url() . 'jpmp/product"'
                    . '</script>';
                }
            } else {
                if ($allsize == 1) {
                    $prices = $_POST['price'];
                    $stok = $_POST['stock'];
                    $checkurl = @$this->modelproduct->getRowDataProduct("WHERE title='$title' order by id_product ASC")->url;
                    $checkidproduct=@$this->modelproduct->getRowDataProduct("WHERE title='$title' order by id_product ASC")->id_product;
                    $this->modelproduct->updateProduct($id_product, $title, $description, $id_category, $images, $metaTag, $metaDescription,$images1,$images2,$images3);
                    if (!empty($checkurl)&&$checkidproduct!=$id_product) {
                        $url = url_title($title . '-' . $id_product);
                    } else {
                        $url = url_title($title, '-');
                    }
                    $this->modelproduct->updateProductUrl($id_product,$url);
                    $this->modelproduct->deleteProduct_detail($id_product);
                    $this->modelproduct->insertProduct_detail('allsize', $prices, $stok, $id_product, $diskon);
                    echo '<script type="text/javascript">'
                    . 'alert("Data Update");'
                    . 'document.location.href="' . base_url() . 'jpmp/product"'
                    . '</script>';
                } else {
                    $checkurl = @$this->modelproduct->getRowDataProduct("WHERE title='$title' order by id_product ASC")->url;
                    $checkidproduct=@$this->modelproduct->getRowDataProduct("WHERE title='$title' order by id_product ASC")->id_product;
                    $this->modelproduct->updateProduct($id_product, $title, $description, $id_category, $images, $metaTag, $metaDescription,$images1,$images2,$images3);
                    if (!empty($checkurl)&&$checkidproduct!=$id_product) {
                        $url = url_title($title . '-' . $id_product);
                    } else {
                        $url = url_title($title, '-');
                    }
                    $this->modelproduct->updateProductUrl($id_product,$url);
                    $this->modelproduct->deleteProduct_detail($id_product);
                    for ($i = 0; $i <= 6; $i++) {
                        if (!empty($_POST['size_' . $i]) && !empty($_POST['price_' . $i]) && !empty($_POST['stock_' . $i])) {
                            $prices = $_POST['price_' . $i];
                            $stok = $_POST['stock_' . $i];
                            $size = $_POST['size_' . $i];
                            $this->modelproduct->insertProduct_detail($size, $prices, $stok, $id_product, $diskon);
                        }
                    }
                    echo '<script type="text/javascript">'
                    . 'alert("Data Update");'
                    . 'document.location.href="' . base_url() . 'jpmp/product"'
                    . '</script>';
                }
            }
        } else {
            $this->load->view('jpmp/login');
        }
    }

    function delete() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelproduct');
            $id_product = $_GET['id'];
            $this->modelproduct->deleteProduct($id_product);
            $this->modelproduct->deleteProduct_detail($id_product);
            echo '<script type="text/javascript">'
            . 'alert("Data Delete");'
            . 'document.location.href="' . base_url() . 'jpmp/product"'
            . '</script>';
        } else {
            $this->load->view('jpmp/login');
        }
    }

}

?>
