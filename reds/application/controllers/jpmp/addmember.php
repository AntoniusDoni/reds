<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of addmember
 *
 * @author user
 */
class addmember extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {

            if (!empty($_GET['id'])) {
                $idmember = $_GET['id'];
            } else {
                $idmember = 0;
            }
            $this->load->model('modelmember');
            $this->load->helper('form');

            $data['idmember'] = $idmember;


            $this->load->view('jpmp/header');
            $this->load->view('jpmp/addMember', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelmember');
            $name = $_POST['name'];
            $emails = $_POST['emails'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $password = $_POST['password'];
            $checkmember = @$this->modelmember->getRowDataMember("WHERE emails='$emails'")->emails;
            if ($checkmember != $emails) {
                $this->modelmember->insertMember($name, $emails, $phone, $address, $password);
                echo '<script type="text/javascript">'
                . 'alert("Data Save");'
                . 'document.location.href="' . base_url() . 'jpmp/addmember"'
                . '</script>';
            }else{
               echo '<script type="text/javascript">'
                . 'alert("Data is Available");'
                . 'document.location.href="' . base_url() . 'jpmp/addmember"'
                . '</script>'; 
            }
        } else {
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

}

?>
