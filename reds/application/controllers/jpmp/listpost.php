<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listpost
 *
 * @author user
 */
class listpost extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelpost');
            $this->load->model('modelcategory');
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $idpost = $_GET['id'];
            } else {
                $idpost = 0;
            }
            $data['idpost'] = $idpost;
            $data['tablecontent'] = $this->tablecontent();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/listpost', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function tablecontent() {
        $this->load->model('modelpost');
        $this->load->model('modelcategory');

        $content = '';
        $querytable = $this->modelpost->getListDataPost(" order by id_post DESC");
        $no = 1;
        foreach ($querytable->result()as $rowtable) {
            if ($rowtable->id_category == 0) {
                $category = 'uncategorized';
            } else {
                $category = @$this->modelcategory->getdetailcategory(@$rowtable->id_category)->category_name;
            }
            if (!empty($rowtable->images)) {
                $image = '<img src="' . urldecode($rowtable->images) . '" style="max-width: 50px;"/>';
            } else {
                $image = '';
            }
            $content.= '<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->title . '</td>
                                        <td class="text-center" style="width: 40%">' . $category . '</td>
                                        <td class="text-center">' . $image . '</td>
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/inputpost?id=' . $rowtable->id_post . '"><i class="fa fa-edit" title="view & edit" style="cursor:pointer;"  ></i></a> / '
                    . '                 <a href="' . base_url() . 'jpmp/inputpost/delete?id=' . $rowtable->id_post . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a>
                                        </td>
                                    </tr>';
        }
        return $content;
    }

}

?>
