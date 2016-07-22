<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detailproduct
 *
 * @author user
 */
class detailproduct extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();

        $this->load->model('modelcategory');
        $this->load->model("modelproduct");
        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index($title) {
//        load model product
        $this->load->model("modelproduct");
//        get id by title
        $idproduct = @$this->modelproduct->getRowDataProduct("WHERE url='$title'")->id_product;
//        if id not empty load detail product else redirect to home
        if (!empty($idproduct)) {
            $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | ' . $title;
            $data['metaDescription'] = @$this->modelproduct->getRowDataProduct("WHERE url='$title'")->metaDescription . " | " . $this->modelsetting->getdetailsetting(1)->metaDescription;
            $data['metaKeyword'] = @$this->modelproduct->getRowDataProduct("WHERE url='$title'")->metaTag . " | " . $this->modelsetting->getdetailsetting(1)->metaKeyword;
            //        init location folder themes
            $themes = 'themes/';
//        set path directory themes
            $data['path'] = base_url() . '' . $themes . '' . $load;
            $data['idproduct'] = $idproduct;
            $idcategory = @$this->modelproduct->getRowDataProduct(" INNER JOIN category  on category.category_id=product.id_category WHERE id_product='$idproduct' ")->category_id;
            if (!empty($idcategory)) {
                $data['idcategory'] = $idcategory;
            } else {
                $data['idcategory'] = 0;
            }
//            load helper form
            $this->load->helper('form');
//            set dropdown with data from product
            $data['selectsize'] = form_dropdown('size', $this->modelproduct->getArrayProductSize($idproduct), '', 'id="size" class="form-control" onchange="checkstok(' . $idproduct . ');"');
            $this->load->view($load . 'header', $data);
            $this->load->view($load . 'detailproduct');
            $this->load->view($load . 'footer');
        } else {
            redirect(base_url());
        }
    }

}

?>
