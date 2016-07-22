<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of member
 *
 * @author user
 */
class member extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelmember');
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $idmember = $_GET['id'];
            } else {
                $idmember = 0;
            }
            $data['idmember'] = $idmember;
            $data['tablecontent'] = $this->tablecontent();

            $this->load->view('jpmp/header');
            $this->load->view('jpmp/member', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function tablecontent() {
        $this->load->model('modelmember');
        $content = '';
        $querytable = $this->modelmember->getListMember(' order by id_member DESC');
        $no = 1;
        foreach ($querytable->result() as $rowtable) {
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->name . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->phone . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->emails . '</td>
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/detailMember?id=' . $rowtable->id_member . '&act=view"><i class="fa fa-user" title="view detail" style="cursor:pointer;"  ></i></a> 
                                        
                                        </td>
                                    </tr>';
//           / <a href="' . base_url() . 'jpmp/detailMember?id=' . $rowtable->id_member . '&act=edt"><i class="fa fa-edit" title=" edit" style="cursor:pointer;"  ></i></a> / '
//                    . '                 <a href="' . base_url() . 'jpmp/detailMember/delete?id=' . $rowtable->id_member . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a>
        }
        return $content;
    }

}

?>
