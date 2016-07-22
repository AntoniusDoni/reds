<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author Doni
 */
class menu extends CI_Controller {

//put your code here
    public function index() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $idmenu = $_GET['id'];
            } else {
                $idmenu = '0';
            }
            $data['idmenu'] = $idmenu;
            $data['typepost'] = $this->getListtypepost();
            $this->load->model('modelmenu');
            $data['treemenu'] = $this->modelmenu->getmenu('', '');
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/menu', $data);
            $this->load->view('jpmp/footer');
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function getListtypepost() {
        $typepost = array();
        $typepost[0] = 'Home';
        $typepost[1] = 'Post';
        $typepost[2] = 'Category';
        $typepost[3] = 'All Post';
        $typepost[4] = 'All Category';
        $typepost[5] = 'Link URL';
        $iscom = @$this->modelsetting->getDetailSetting($this->session->userdata('useracces'))->isecommer;
        if ($iscom == 1) {
         $typepost[6] = 'Product';
         $typepost[7] = 'All Product';
        }
        return $typepost;
    }

    function save() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelmenu');
            $idmenu = $_POST['idmenu'];
            $title = $_POST['title'];
            $typepost = $_POST['typepost'];
            $parent = $_POST['parent'];
            $url = $_POST['url'];
            if ($idmenu == 0) {
                $this->modelmenu->insertmenu($idmenu, $title, $typepost, $parent, $url);
                $this->createsitemap();
                echo '<script type="text/javascript">'
                . 'alert("Data Saved");'
                . 'document.location.href="' . base_url() . 'jpmp/menu"'
                . '</script>';
            } else {
                $this->modelmenu->updatemenu($idmenu, $title, $typepost, $parent, $url);
                $this->createsitemap();
                echo '<script type="text/javascript">'
                . 'alert("Data Update");'
                . 'document.location.href="' . base_url() . 'jpmp/menu"'
                . '</script>';
            }
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function delete() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $idmenu = $_GET['id'];
            $this->load->model('modelmenu');
            $this->modelmenu->deletemenu($idmenu);
            $this->createsitemap();
            echo '<script type="text/javascript">'
            . 'alert("Data Delete");'
            . 'document.location.href="' . base_url() . 'jpmp/menu"'
            . '</script>';
        }
    }

    public function update() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $data = ( ($_POST['list']) );
            $root = $_GET['root'];

            $this->load->model('modelmenu');
            $this->modelmenu->massUpdate($data, $root);
            $this->createsitemap();
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

    function getpostautocomplite() {
        $this->load->model('modelpost');
        $this->load->helper('json');
        $url = $_POST['url'];
        //$typepost = $_POST['typepost'];
        $data = '';
    
        $query = $this->modelpost->getList_post_byStatement(" WHERE post_name='" . $url . "' order by post_id DESC");
        foreach ($query->result()as $row) {

            $data.=base_url() . '/'. url_title($row->post_url, '_') . ',';
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }
    function getautocomplitecategory(){
        $this->load->model('modelcategory');
        $this->load->helper('json');
        $url = $_POST['url'];
        
        $data = '';
        
        $query = $this->modelcategory->getListcategorybyidcategory(0, 1000, 'DESC', $url);
        foreach ($query->result()as $row) {

            $data.=base_url() . 'category/'. url_title($row->url, '_') . ',';
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }
    
    function createsitemap() {
        $this->load->model('modelmenu');
        $string = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $string.='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $string.='<url>
        <loc>' . base_url() . '</loc>
        <priority>1.0</priority>
        </url>'."\n";
        $string.=$this->menusitemap('','');
        $string.="</urlset>";

//            $filename = $folder . 'input' . $table;
        $handle = fopen('sitemap.xml', 'w+');

        fwrite($handle, $string);

        fclose($handle);
    }

    function menusitemap($idparent,$level) {
        $this->load->model('modelmenu');
        if(empty($idparent)){
            $idparent=0;
        }
        if(empty($level)){
          $level=1;  
        }
        $string = '';
        $querymenu = $this->modelmenu->getListmenubyparent('ASC',$idparent);;
        foreach ($querymenu->result()as $parent) {
            if($parent->parent==0){
                $priority='1.0';
            }else{
                $priority='0.5';
            }
        $string.='<url>'."\n".'
        <loc>' . $parent->url . '</loc>'."\n".'
        <priority>'.$priority.'</priority>'."\n".'
        </url>'."\n";
            if ($parent->idmenu >= 1) {
                $string .= $this->menusitemap($parent->idmenu, $level + 1);
            }
        }
         return $string;
    }

}
