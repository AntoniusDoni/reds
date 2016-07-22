<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detail_order
 *
 * @author user
 */
class detail_order extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {

            if (!empty($_GET['id'])) {
                $this->load->model('modelorder');
                $this->load->helper('form');
                $idorder = $_GET['id'];
                $data['idorder'] = $idorder;
                $data['getStatusOrder'] = $this->getStatusOrder();
                $this->load->view('jpmp/header');
                $this->load->view('jpmp/detail_order', $data);
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

    function getStatusOrder() {
        $data['Pending'] = 'Pending';
        $data['Pay'] = 'Pay';
        $data['Shiping'] = 'Shiping';
        $data['Done'] = 'Done';
        return $data;
    }

    function updatestatus() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelorder');
            $idorder = $_POST['idorder'];
            $status = $_POST['status'];
            $checkStatus = $this->modelorder->getRowDataOrder(" WHERE id_order='$idorder'")->status_order;
            $statusOrder = 'Your Input Not Allowed';
            if ($checkStatus == 'Pending' && $status == 'Pay') {
                $this->modelorder->updateOrder($idorder, $status);
                $statusOrder="Data Update";
            } 
            if ($checkStatus == 'Pay' && $status == 'Shiping') {
                $this->modelorder->updateOrder($idorder, $status);
                $statusOrder="Data Update";
            } 
            if ($checkStatus == 'Shiping' && $status == 'Done') {
                $this->modelorder->updateOrder($idorder, $status);
                $statusOrder="Data Update";
            } 
            $this->json_data['data'] = $statusOrder;
            echo json_encode($this->json_data);
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

}

?>
