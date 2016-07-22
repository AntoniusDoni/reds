<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detailcategory
 *
 * @author user
 */
class detailcategory extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();
        
        $this->load->model('modelcategory');
        $this->load->model("modelproduct");
        $this->load->model("modelpost");
        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index($title) {
        $idcategory = @$this->modelcategory->getdetailcategorybycategory_url($title)->category_id;
        if (!empty($idcategory)) {
            $data['idcategory'] = $idcategory;

            $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | ' . $title;
            $data['metaDescription'] = $title . "| Category | " . $this->modelsetting->getdetailsetting(1)->metaDescription;
            $data['metaKeyword'] = $title . "| Category | " . $this->modelsetting->getdetailsetting(1)->metaKeyword;
            $data['load'] = $load;
            $themes = 'themes/';
            $data['path'] = base_url() . '' . $themes . '' . $load;
            
            $this->load->view($load . 'header', $data);
            $this->load->view($load . 'detailcategory', $data);
            $this->load->view($load . 'footer');
        } else {
            redirect(base_url());
        }
    }

    

}

?>
