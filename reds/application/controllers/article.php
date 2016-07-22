<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of artikel
 *
 * @author user
 */
class article extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();
//        $this->load->model("modelwishlist");
        $this->load->model('modelcategory');
//        $this->load->model("modelproduct");
        $this->load->model("modelpost");
        $this->load->library('session');
//        $this->load->library('cart');
    }

    public function index($title) {
        $idcategory = @$this->modelcategory->getdetailcategorybycategory_url($title)->category_id;
        if (!empty($idcategory)) {
            $data['idcategory'] = $idcategory;

            
            $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | Contact Us';
            $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->title . "| Contact Us | ";
            $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->title . "| Contact Us | ";
            $data['load'] = $load;
            $iscommer = @$this->modelsetting->getdetailsetting(1)->isecommer;
            if ($iscommer == '1') {
                $themes = 'themes/shop/';
            } else {
                $themes = 'themes/profile/';
            }

            $data['path'] = base_url() . '' . $themes . '' . $load;
            
            $data['url']=$title;
            $this->load->view($load . 'header', $data);
            $this->load->view($load . 'article', $data);
            $this->load->view($load . 'footer');
        } 
//        else {
//            redirect(base_url());
//        }
    }

}

?>
