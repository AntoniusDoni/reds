<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detailMemberOrder
 *
 * @author user
 */
class detailMemberOrder extends CI_Controller{
    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {

            if (!empty($_GET['id'])) {
                $this->load->model('modelmember');
                $this->load->helper('form');
                $idmember = $_GET['id'];
                $data['tablecontent']=  $this->tablecontent($idmember);
                $data['idmember'] = $idmember;
                
                $this->load->view('jpmp/header');
                $this->load->view('jpmp/detailMemberOrder', $data);
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
    function tablecontent($idmember) {
        $this->load->model('modelorder');
        $content = '';
        $querytable = $this->modelorder->getListOrder(" 
            INNER JOIN order_detail AS detail ON detail.id_order=orders.id_order
            INNER JOIN product_detail ON product_detail.id_product_detail=detail.id_detail_product
            INNER JOIN product ON product_detail.id_product=product.id_product
            INNER JOIN member ON member.id_member=orders.id_member 
            WHERE member.id_member='$idmember' order by dates_order DESC");
        $no = 1;

        foreach ($querytable->result() as $rowtable) {
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->dates_order . '</td>    
                                        <td class="text-center" style="width: 18%">' . $rowtable->name . '</td>
                                        <td class="text-center">' . $rowtable->title . '</td>
                                        <td class="text-center">' . $rowtable->quantity . '</td>    
                                        <td class="text-center">Rp. ' . number_format($rowtable->total_price) . '</td>
                                        <td class="text-center" style="color:red;font-weight:bold;">' . $rowtable->status_order . '</td>    
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/detail_order?id=' . $rowtable->id_order . '"><i class="fa fa-search" title="Detail" style="cursor:pointer;"  ></i></a> 
                                        </td>
                                    </tr>';
        }
        return $content;
    }
}

?>
