<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of return
 *
 * @author user
 */
class returns extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {


            $this->load->model('modelorder');
            $this->load->helper('form');

            $data['tablecontent'] = $this->getReturnOrder();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/returns', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function getReturnOrder() {
        $this->load->model('modelorder');
        $this->load->helper('form');
        $content = '';

        $arrayStatus['Approve'] = 'Approve';
        $arrayStatus['Reject'] = 'Reject';
        $arrayStatus['Progress'] = 'Progress';

        $querytable = @$this->modelorder->getDataReturn("Order by date_return DESC ", " * ");
        $no = 1;
        foreach ($querytable->result()as $rowtable) {
            $content.='<tr>
                                <th>' . $no . '</th>
                                <th>' . $rowtable->code_orders . '</th>
                                <th>' . $rowtable->note . '</th>
                                <th><img src="' . base_url() . 'return_order/' . $rowtable->images_return . '" style="max-width:100px;max-height:100px;"></th>
                                <th>
                                ' . form_dropdown('status_return_' . $no, $arrayStatus, $rowtable->status, 'id="status_return_' . $no . '" onchange="geStatusReturn(' . $no . ',' . $rowtable->returns_id . ');" ') . '
                                
                                </th>
                            </tr>';
            $no++;
        }
        return $content;
    }

    function updateStatus() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelorder');
            $idR = $_POST['idR'];
            $status_return = $_POST['status_return'];
            $check = $this->modelorder->getDetailDataReturn("WHERE returns_id='$idR'", "status")->status;
            if ($check == 'Progress' ) {
                $this->modelorder->updateReturn($idR, $status_return);
                echo 'sucsess'; 
            }else {
                    echo 'forbiden ';
                }
            } else {
                $this->load->helper('url');
                $uri = base_url() . 'jpmp/returns';
                redirect($uri);
            }
        }
    }

?>
