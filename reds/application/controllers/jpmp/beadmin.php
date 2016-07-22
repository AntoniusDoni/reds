<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of beadmin
 *
 * @author user
 */
class beadmin extends CI_Controller{
    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
//            $data['tablecontent'] = $this->tablecontent();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/homesadmin');
            $this->load->view('jpmp/footer');
        } else {
            $this->load->view('jpmp/login');
        }
    }
    function  loginadmin(){
//        $this->load->model('');
        $emails=$_POST['email'];
        $password=$_POST['password'];
        $row = $this->modelsetting->getdatalogin($emails, $password);
        if (!empty($row->idgm)) {
            $this->session->set_userdata('useracces', $row->idgm);
            $this->session->set_userdata('title', $row->title);
//            
            redirect(base_url() . 'jpmp/beadmin');
        } else {
            echo '<script type="text/javascript">'
            . 'alert("Email or Password invalid");'
            . 'document.location.href="' . base_url() . 'jpmp/beadmin"'
            . '</script>';
        }
    }
    function logoutaccount() {
        $this->session->unset_userdata('useracces');
        $this->session->unset_userdata('name');
        $this->session->sess_destroy();
        redirect(base_url() . 'jpmp/beadmin');
    }
}

?>
