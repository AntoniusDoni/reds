<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of postall
 *
 * @author user
 */
class postall extends CI_Controller{
    //put your code here
    function __construct() {

        parent::__construct();
        $this->load->model("modelwishlist");
        $this->load->model('modelcategory');
        $this->load->model("modelproduct");
        $this->load->model("modelpost");
        $this->load->library('session');
        $this->load->library('cart');
    }
     public function index($title) {
        $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
        $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | All Post' . $title;
        $data['metaDescription'] = $title . "| All Post | " . $title;
        $data['metaKeyword'] = $title . "| All Post | " . $title;
        $data['load'] = $load;
        $data['path'] = base_url() . 'themes/shop/' . $load;
        $this->load->view($load . 'header', $data);
        $this->load->view($load . 'post', $data);
        $this->load->view($load . 'footer');
    }
}

?>
