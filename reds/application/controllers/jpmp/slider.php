<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of slider
 *
 * @author user
 */
class slider extends CI_Controller {

    //put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelslider');
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $idslider = $_GET['id'];
            } else {
                $idslider = 0;
            }
            $data['idslider'] = $idslider;
            $data['tablecontent'] = $this->tablecontent();
            $data['typeLink'] = $this->getTypeMenu();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/slider', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function getTypeMenu() {

        $typepost = array();
        $typepost[0] = '- No Link -';
        $typepost[1] = 'Post';
        $typepost[2] = 'Category';
        $typepost[3] = 'Product';
        return $typepost;
    }

    function tablecontent() {
//        $this->load->model('modelpost');
        $this->load->model('modelslider');
        $content = '';
        $querytable = $this->modelslider->getListSlider(' order by id_slider DESC');
        $no = 1;
        foreach ($querytable->result() as $rowtable) {
            if (!empty($rowtable->images)) {
                $image = '<img src="' . urldecode($rowtable->images) . '" style="max-width: 50px;"/>';
            } else {
                $image = '';
            }
            $content.='<tr>
                                        <td class="text-center">' . $no++ . '</td>
                                        <td class="text-center" style="width: 18%">' . $rowtable->description . '</td>
                                        <td class="text-center">' . $image . '</td>
                                        <td class="text-center">
                                        <a href="' . base_url() . 'jpmp/slider?id=' . $rowtable->id_slider . '"><i class="fa fa-edit" title="view & edit" style="cursor:pointer;"  ></i></a> / '
                    . '                 <a href="' . base_url() . 'jpmp/slider/delete?id=' . $rowtable->id_slider . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a>
                                        </td>
                                    </tr>';
        }
        return $content;
    }

    function getpostautocomplite() {
        $this->load->model('modelpost');
        $data = '';
        $title = $_POST['links'];
        $query = $this->modelpost->getListDataPost(" WHERE title LIKE '%" . $title . "%' order by id_post DESC");
        foreach ($query->result()as $row) {

            $data.=base_url() . 'detailpost/' . url_title($row->url, '-') . ',';
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }

    function getcategoryautocomplite() {
        $this->load->model('modelcategory');
        $data = '';
        $title = $_POST['links'];
        $query = $this->modelcategory->getListcategorybystatement(" WHERE category_name LIKE '%" . $title . "%' order by category_id DESC");
        foreach ($query->result()as $row) {

            $data.=base_url() . 'detailcategory/' . url_title($row->category_url, '-') . ',';
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }

    function getproductAutocomplite() {
     $this->load->model('modelproduct');
        $data = '';
        $title = $_POST['links'];
        $query = $this->modelproduct->getListProduct(" WHERE title LIKE '%" . $title . "%' order by id_product DESC");
        foreach ($query->result()as $row) {

            $data.=base_url() . 'detailproduct/' . url_title($row->url, '-') . ',';
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);   
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelslider');
            $id_slider = $_POST['id_slider'];
            $description = $_POST['description'];
            $images = $_POST['images'];
            $links_type = $_POST['links_type'];
            if ($links_type == 0) {
                $links = "#";
            } else {
                $links = $_POST['links'];
            }
            if ($id_slider == 0) {
                $this->modelslider->insertSlider($description, $images, $links, $links_type);
                echo '<script type="text/javascript">'
                . 'alert("Data Saved");'
                . 'document.location.href="' . base_url() . 'jpmp/slider"'
                . '</script>';
            } else {
                $this->modelslider->updateSlider($id_slider, $description, $images, $links, $links_type);
                echo '<script type="text/javascript">'
                . 'alert("Data Saved");'
                . 'document.location.href="' . base_url() . 'jpmp/slider"'
                . '</script>';
            }
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function delete() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelslider');
            $idslider = $_GET['id'];
            $this->modelslider->deleteSlider($idslider);
            echo '<script type="text/javascript">'
            . 'alert("Data Delete");'
            . 'document.location.href="' . base_url() . 'jpmp/slider"'
            . '</script>';
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

}

?>
