<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of accountBank
 *
 * @author user
 */
class accountBank extends CI_Controller{
    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelsetting');
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $bank_account_id = $_GET['id'];
            } else {
                $bank_account_id = 0;
            }
            $data['bank_account_id'] = $bank_account_id;
            $data['tablecontent'] = $this->tablecontent();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/accountBank', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function tablecontent() {
        $content = '';
        $this->load->model('modelsetting');
        $querytable = $this->modelsetting->getListBank('order by bank_name DESC');
        $no = 1;
        foreach ($querytable->result() as $rowtable) {
            
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->bank_name . '</td>
                                        <td class="text-center">' . $rowtable->bank_account . '</td>
                                        <td class="text-center">' . $rowtable->bank_owner . '</td>
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/accountBank?id=' . $rowtable->bank_account_id . '"><i class="fa fa-edit" title="view & edit" style="cursor:pointer;"  ></i></a> / '
                    . '                 <a href="' . base_url() . 'jpmp/accountBank/delete?id=' . $rowtable->bank_account_id . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a>
                                        </td>
                                    </tr>';
        }
        return $content;
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelsetting');
            $bank_account_id = $_POST['bank_account_id'];
            $bank_name=$_POST['bank_name'];
            $bank_account=$_POST['bank_account'];
            $bank_owner=$_POST['bank_owner'];

           

            if ($bank_account_id == 0) {
                $this->modelsetting->insertbank_account($bank_account_id, $bank_name, $bank_account, $bank_owner);
                
                echo '<script type="text/javascript">'
                . 'alert("Data Save");'
                . 'document.location.href="' . base_url() . 'jpmp/accountBank"'
                . '</script>';
            } else {

                $this->modelsetting->updatebank_account($bank_account_id, $bank_name, $bank_account, $bank_owner);
                echo '<script type="text/javascript">'
                . 'alert("Data Update");'
                . 'document.location.href="' . base_url() . 'jpmp/accountBank"'
                . '</script>';
            }
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function delete() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelsetting');
            $bank_account_id = $_GET['id'];
            $this->modelsetting->deletebank_account($bank_account_id);
            echo '<script type="text/javascript">'
            . 'alert("Data Delete");'
            . 'document.location.href="' . base_url() . 'jpmp/accountBank"'
            . '</script>';
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }
}

?>
