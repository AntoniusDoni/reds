<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inputpost
 *
 * @author user
 */
class inputpost extends CI_Controller {

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
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/inputpost', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelpost');
            date_default_timezone_set('Asia/Jakarta');
            $timenow = date('r');
            $post_date = date('Y-m-d H:i:s', strtotime($timenow));
            $images = $_POST['images'];
            $title = $_POST['title'];
            $description_ind = $_POST['description_ind'];
            $description_en = $_POST['description_eng'];
            $metDescription = $_POST['matadescription'];
            $metaTag = $_POST['metatag'];
            $idpost = $_POST['idpost'];
            $id_category = $_POST['id_category'];
            $creat_id=$this->modelsetting->getdetailsetting(1)->emails;
            if ($idpost == 0) {
                $post_randcode = $this->modelpost->getrandom();
                $checkurl = @$this->modelpost->getRowDataPost("WHERE title='$title' order by id_post ASC")->url;

                $this->modelpost->insertPost($id_category, $title, $images, $metaTag, $metDescription, $post_randcode,$post_date,$creat_id);
                if (!empty($checkurl)) {
                    $url = url_title($title . '-' . $this->modelpost->getRowDataPost("WHERE post_randcode='" . $post_randcode . "'")->id_post);
                } else {
                    $url = url_title($title,'-');
                }
                $id_post = $this->modelpost->getRowDataPost("WHERE post_randcode='" . $post_randcode . "'")->id_post;
                $this->modelpost->updateUrlpost($id_post,$url);
                

                $this->modelpost->insertPost_Description('', $description_ind, 'ID', $id_post);
                $this->modelpost->insertPost_Description('', $description_en, 'EN', $id_post);
                echo '<script type="text/javascript">'
                . 'alert("Data Save");'
                . 'document.location.href="' . base_url() . 'jpmp/inputpost"'
                . '</script>';
            } else {
                $this->modelpost->updatePost($id_category, $idpost, $title, $images, $metaTag, $metDescription,$post_date);
                $checkurl = @$this->modelpost->getRowDataPost("WHERE title='$title' order by id_post ASC")->url;
                $checkidproduct= @$this->modelpost->getRowDataPost("WHERE title='$title' order by id_post ASC")->id_post;
                if (!empty($checkurl)&&$checkidproduct!=$idpost) {
                    $url = url_title($title . '-' . $this->modelpost->getRowDataPost("WHERE post_randcode='" . $post_randcode . "'")->id_post);
                } else {
                    $url = url_title($title,'-');
                }
                $this->modelpost->updateUrlpost($idpost,$url);
                
                $this->modelpost->updatePost_Description($description_ind, 'ID', $idpost);
                $this->modelpost->updatePost_Description($description_en, 'EN', $idpost);
                echo '<script type="text/javascript">'
                . 'alert("Data Update");'
                . 'document.location.href="' . base_url() . 'jpmp/listpost"'
                . '</script>';
            }
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function delete() {
        $idpost = $_GET['id'];
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelpost');
            $this->modelpost->deletePost($idpost);
            $this->modelpost->deletePost_Description($idpost);
            echo '<script type="text/javascript">'
            . 'alert("Data Delete");'
            . 'document.location.href="' . base_url() . 'jpmp/listpost"'
            . '</script>';
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

}

?>
