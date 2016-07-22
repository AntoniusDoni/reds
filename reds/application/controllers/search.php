<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author user
 */
class search extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();
        $this->load->model("modelwishlist");
        $this->load->model('modelcategory');
        $this->load->model("modelproduct");

        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index() {
        $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
        $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | Search Product';
        $data['metaDescription'] = "| Search Product | ";
        $data['metaKeyword'] = " Search Product | ";
        $data['load'] = $load;
        $data['path'] = base_url() . 'themes/shop/' . $load;
        if (!empty($_GET['serachproduct'])) {
            $serachproduct = $_GET['serachproduct'];
        } else {
            $serachproduct = '';
        }
        $data['serachproduct']=$serachproduct;
        $this->load->view($load . 'header', $data);
        $this->load->view($load . 'search', $data);
        $this->load->view($load . 'footer');
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
        $serachproduct = $_POST['serachproduct'];
        $contentPagin = '<ul class="pagination">';
        if (!empty($serachproduct)) {
            $condition = "WHERE title like '%" . $serachproduct . "%' ";
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

}

?>
