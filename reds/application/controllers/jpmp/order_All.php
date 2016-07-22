<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of order_All
 *
 * @author user
 */
class order_All extends CI_Controller{
    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelorder');

            $data['tablecontent'] = $this->tablecontent();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/order', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function tablecontent() {
        $this->load->model('modelorder');
        $content = '';
        $querytable = $this->modelorder->getListOrder(" 
            INNER JOIN order_detail AS detail ON detail.id_order=orders.id_order
            INNER JOIN product_detail ON product_detail.id_product_detail=detail.id_detail_product
            INNER JOIN product ON product_detail.id_product=product.id_product
            INNER JOIN member ON member.id_member=orders.id_member GROUP BY code_order
            order by dates_order DESC");
        $no = 1;

        foreach ($querytable->result() as $rowtable) {
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->dates_order . '</td>    
                                        <td class="text-center" style="width: 18%">' . $rowtable->name . '</td>
                                        <td class="text-center">' . $rowtable->title . '</td>
                                        <td class="text-center">' . $rowtable->quantity . '</td>    
                                        <td class="text-center">Rp. ' . number_format($rowtable->total_price) . '</td>
                                        <td class="text-center" style="color:Green;font-weight:bold;">' . $rowtable->status_order . '</td>    
                                        <td class="text-center">
                                        
                                        <a href="' . base_url() . 'jpmp/detail_order?id=' . $rowtable->id_order . '"><i class="fa fa-search" title="Detail" style="cursor:pointer;"  ></i></a> 
                                        </td>
                                    </tr>';
        }
        return $content;
    }
}

?>
