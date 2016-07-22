<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of member_account
 *
 * @author user
 */
class member_account extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();
     
        $this->load->model('modelcategory');
        $this->load->model("modelproduct");

        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index() {
        $idmember = $this->session->userdata('idmember');
        if (!empty($idmember)) {
            $this->load->model("modelmember");
            $this->load->model("modelorder");
            $this->load->helper('form');
            $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | My Account';
            $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->title . "| My Account";
            $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->title . "| My Account";
            $data['load'] = $load;
            $data['idmember'] = $idmember;
           //        init location folder themes
            $themes = 'themes/';
//        set path directory themes
            $data['path'] = base_url() . '' . $themes . '' . $load;
            $this->load->view($load . 'header', $data);
            $this->load->view($load . 'member_account', $data);
            $this->load->view($load . 'footer');
        } else {
            redirect(base_url() . 'sign');
        }
    }

    function editacount() {
        $this->load->model('modelmember');
        $id_member = $_POST['id_member'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $emails = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['streetnames'] . "|" . $_POST['city'] . "|" . $_POST['province'] . "|" . $_POST['country'];
        $this->modelmember->updateMember($id_member, $name, $emails, $phone, $address, $password);
        $data['data'] = "DATA UPDATE";
        echo json_encode($data);
    }

    function confirmation_pay() {
        $this->load->model('modelorder');
        $order_code = $_POST['order_code'];
        $member_bank = $_POST['member_bank'];
        $member_account_bank = $_POST['member_account_bank'];
        $id_bank = $_POST['id_bank'];
        $total_price = $_POST['total_price'];
        $transfer_date = $_POST['transfer_date'];
        $note = $_POST['note'];
        $confirmStatus = "invalid";
        if ($order_code <> '' && $member_bank <> '' && $member_account_bank <> '' && $id_bank <> '' && $total_price <> '' && $transfer_date <> '' && !empty($_FILES['images_bank'])) {
            $images_bank = $_FILES['images_bank'];
            $filename = basename(html_entity_decode($_FILES['images_bank']['name'], ENT_QUOTES, 'UTF-8'));
            $allowed = array(
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png',
                'image/gif'
            );
            $folder = 'conf_payment';
            if (!is_dir($folder))
                mkdir($folder, 0755, true);
            chmod($folder, 0755);
            if (!in_array($images_bank['type'], $allowed)) {
                echo 'Warning: Incorrect file type!';
            }
            $newnamefile = $_FILES['images_bank']['name'];
            while (file_exists($folder . '/' . $newnamefile)) {
                $stringrand = md5(microtime());
                $random = substr($stringrand, 0, 16);
                $newnamefile = 'confirmation_' . $random . '.png';
            }
            $checkNom = @$this->modelorder->getRowDataOrder(" WHERE code_order='$order_code'")->total_price;
            if (!empty($checkNom) && $checkNom == $total_price) {
                if (@move_uploaded_file($_FILES['images_bank']['tmp_name'], $folder . '/' . $newnamefile)) {

                    $this->modelorder->updateOrderCustome(" code_order='$order_code'", " member_bank='$member_bank',member_account_bank='$member_account_bank',transfer_date='$transfer_date',images_bank='$newnamefile',transfer_amount='$total_price',status_order='Pay',note_payment='$note' ");
                    $statusPay = "Confirmation Sucsess";
                    $confirmStatus = "valid";
                } else {

                    $statusPay = "Upload Failed";
                }
            } else {

                $statusPay = "Your Order Code or Your Total Payment not valid";
            }
        } else {
            $statusPay = "Your Input Not Valid";
        }
        $data['data'] = $statusPay;
        $data['confirmStatus'] = $confirmStatus;
        echo json_encode($data);
    }

    function sendReturn() {
        $this->load->model('modelorder');
        $order_code_return = $_POST['order_code_return'];
        $note_return = $_POST['note_return'];
        $confirmStatus = "invalid";
        if ($order_code_return <> '' && $note_return <> '' && !empty($_FILES['images_bank_return'])) {
            $images_bank = $_FILES['images_bank_return'];
            $filename = basename(html_entity_decode($_FILES['images_bank_return']['name'], ENT_QUOTES, 'UTF-8'));
            $allowed = array(
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/x-png',
                'image/gif'
            );
            $folder = 'return_order';
            if (!is_dir($folder))
                mkdir($folder, 0755, true);
            chmod($folder, 0755);
            if (!in_array($images_bank['type'], $allowed)) {
                echo 'Warning: Incorrect file type!';
            }
            $newnamefile = $_FILES['images_bank_return']['name'];
            while (file_exists($folder . '/' . $newnamefile)) {
                $stringrand = md5(microtime());
                $random = substr($stringrand, 0, 16);
                $newnamefile = 'Return_' . $random . '.png';
            }
            if (@move_uploaded_file($_FILES['images_bank_return']['tmp_name'], $folder . '/' . $newnamefile)) {
                $this->modelorder->insertReturn($order_code_return, $note_return, $newnamefile);
                $statusPay = "Confirmation Sucsess";
                $confirmStatus = "valid";
            } else {
                $statusPay = "Upload Failed";
            }
        } else {
            $statusPay = "Your Input Not Valid";
        }
        $data['data'] = $statusPay;
        $data['confirmStatus'] = $confirmStatus;
        echo json_encode($data);
    }

}

?>
