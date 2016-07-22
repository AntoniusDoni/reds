<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author user
 */
class category extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelcategory');
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $idcaegory = $_GET['id'];
            } else {
                $idcaegory = 0;
            }
            $data['idcategory'] = $idcaegory;
            $data['tablecontent'] = $this->tablecontent();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/category', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function tablecontent() {
        $content = '';
        $this->load->model('modelcategory');
        $querytable = $this->modelcategory->getListcategory('DESC');
        $no = 1;
        foreach ($querytable->result() as $rowtable) {
            if (!empty($rowtable->category_images)) {
                $image = '<img src="' . urldecode($rowtable->category_images) . '" style="max-width: 50px;"/>';
            } else {
                $image = '';
            }
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->category_name . '</td>
                                        <td class="text-center">' . $image . '</td>
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/category?id=' . $rowtable->category_id . '"><i class="fa fa-edit" title="view & edit" style="cursor:pointer;"  ></i></a> / '
                    . '                 <a href="' . base_url() . 'jpmp/category/delete?id=' . $rowtable->category_id . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a>
                                        </td>
                                    </tr>';
        }
        return $content;
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelcategory');
            $category_id = $_POST['idcategory'];
            $title = $_POST['title'];

            $image = $_POST['image'];

            $parent = $_POST['parent'];

            if ($category_id == 0) {
                $this->modelcategory->insertcategory($category_id, $title, $parent, $image, url_title($title));
                $chektitle = @$this->modelcategory->getdetailcategorybycategory_name($title, 'ASC')->category_id;
                if (!empty($chektitle)) {
                    $this->modelcategory->updatecategorycategory_url($chektitle, url_title($title) . '-' . $chektitle);
                }
                echo '<script type="text/javascript">'
                . 'alert("Data Save");'
                . 'document.location.href="' . base_url() . 'jpmp/category"'
                . '</script>';
            } else {

                $chektitle = @$this->modelcategory->getdetailcategorybycategory_name($title, 'ASC')->category_id;
                if (!empty($chektitle)) {
                    $this->modelcategory->updatecategorycategory_url($category_id, url_title($title) . '-' . $category_id);
                } else {
                    $this->modelcategory->updatecategorycategory_url($category_id, url_title($title));
                }
                $this->modelcategory->updatecategory($category_id, $title, $parent, $image);
                echo '<script type="text/javascript">'
                . 'alert("Data Update");'
                . 'document.location.href="' . base_url() . 'jpmp/category"'
                . '</script>';
            }
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function delete() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelcategory');
            $category_id = $_GET['id'];
            $this->modelcategory->deletecategory($category_id);
            echo '<script type="text/javascript">'
            . 'alert("Data Delete");'
            . 'document.location.href="' . base_url() . 'jpmp/category"'
            . '</script>';
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

}

?>
