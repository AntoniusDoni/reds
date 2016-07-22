<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detailpost
 *
 * @author user
 */
class detailpost extends CI_Controller {

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
        $idpost = @$this->modelpost->getRowDataPost("WHERE url='$title'")->id_post;
        $this->load->model("modelmember");
        if (!empty($idpost)) {
            $data['idpost'] = $idpost;

            $idmember = $this->session->userdata('idmember');

            $creat_id = @$this->modelpost->getRowDataPost("WHERE id_post='$idpost'")->creat_id;
            if($creat_id== $this->modelsetting->getdetailsetting(1)->emails){
                $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            }else{
                
                $load = $this->modelmember->getRowDataMember("WHERE emails='$creat_id'")->member_themes . '/';
            }
            

            $data['title'] =$this->modelsetting->getdetailsetting(1)->title . ' | ' . $title;
            $data['metaDescription'] = @$this->modelpost->getRowDataPost("WHERE url='$title'")->metadescription . '|' . $title . "| Blog | " . $this->modelsetting->getdetailsetting(1)->metaDescription;
            $data['metaKeyword'] = @$this->modelpost->getRowDataPost("WHERE url='$title'")->metaTag . '|' . $title . "| Blog | " . $this->modelsetting->getdetailsetting(1)->metaKeyword;
            $data['load'] = $load;
            $data['url'] = $title;
             //        init location folder themes
            $themes = 'themes/';
//        set path directory themes
            $data['path'] = base_url() . '' . $themes . '' . $load;

            $this->load->view($load . 'header', $data);
            $this->load->view($load . 'detailpost', $data);
            $this->load->view($load . 'footer');
        } else {
            redirect(base_url());
        }
    }

}

?>
