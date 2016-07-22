<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product_all
 *
 * @author user
 */
class product_all extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();

        $this->load->model('modelcategory');
        $this->load->model("modelproduct");

        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index($title) {
//         load themes from database
        $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
//        load and set title and meta data from database
        $data['title'] = $this->modelsetting->getdetailsetting(1)->title . '| All Product ';
        $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->metaDescription;
        $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->metaKeyword;
        $data['load'] = $load;
//        init location folder themes
        $themes = 'themes/';
//        set path directory themes
        $data['path'] = base_url() . '' . $themes . '' . $load;
        $this->load->view($load . 'header', $data);
        $this->load->view($load . 'product', $data);
        $this->load->view($load . 'footer');
    }

}

?>
