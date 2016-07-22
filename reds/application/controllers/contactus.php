<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contactus
 *
 * @author user
 */
class contactus extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();

        $this->load->model('modelcategory');
        $this->load->model("modelproduct");
        $this->load->model("modelpost");
        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index() {

        //        load themes from database
        $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
//        load and set title and meta data from database
        $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | Contact Us';
        $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->metaDescription . ' | Contact Us';
        $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->metaKeyword . ' | Contact Us';
        $data['load'] = $load;
//        init location folder themes
        $themes = 'themes/';
//        set path directory themes
        $data['path'] = base_url() . '' . $themes . '' . $load;
        $data['path'] = base_url() . '' . $themes . '' . $load;
        $this->load->view($load . 'header', $data);
        $this->load->view($load . 'contactus', $data);
        $this->load->view($load . 'footer');
    }

//    send mail from contact us to admin mail
    function sendcontact() {
        $name = $_POST['name'];
        $emails = $_POST['emails'];
        $msg = $_POST['msg'];
        $this->load->model('modelsetting');

        $row = $this->modelsetting->getdetailsetting(1);

        $this->load->library('email');
        $this->email->from($emails, $name);
        $this->email->to(@$row->emails);
        $this->email->subject("Email From Contact Us admin " . $row->title);
        $this->email->message($msg);
        $this->email->send();
//        after send redirect to contact us
        echo '<script type="text/javascript">'
        . 'alert("Your Mail Has been Send");'
        . 'document.location.href="' . base_url() . 'contactus"'
        . '</script>';
    }

}

?>
