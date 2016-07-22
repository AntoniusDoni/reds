<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detailMember
 *
 * @author user
 */
class detailMember extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {

            if (!empty($_GET['id'])) {
                $this->load->model('modelmember');
                $this->load->helper('form');
                $idmember = $_GET['id'];
                if (!empty($_GET['act'])) {
                    if ($_GET['act'] == 'view') {
                        $title = "Detail";
                    } else {
                        $title = "Edit";
                    }
                } else {
                    $title = "Detail";
                }
                $data['idmember'] = $idmember;
                $data['title'] = $title;
                $data['act']=$_GET['act'];
                $this->load->view('jpmp/header');
                $this->load->view('jpmp/detailMember', $data);
                $this->load->view('jpmp/footer');
            } else {
                $this->load->helper('url');
                $uri = base_url() . 'jpmp/beadmin';
                redirect($uri);
            }
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

}

?>
