<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelmenu
 *
 * @author Doni
 */
class modelmenu extends CI_Model {

    //put your code here
    function getArraymenu() {
        $xstr = "Select idmenu,title,typepost,parent,url From menu ";
        $query = $this->db->query($xstr);
        $xBufResult[0] = "-Select Menu-";
        foreach ($query->result() as $row) {
            $xBufResult[$row->idmenu] = $row->title;
        }
        return $xBufResult;
    }

    function getListmenu($parent = '') {
        if (empty($parent)) {
            $parent = 0;
        }
        $xstr = "SELECT * FROM menu WHERE parent='" . $parent . "' order by positionmenu ASC";
        $query = $this->db->query($xstr);


        return $query;
    }
    function getcheckmenuparent($parent = '') {
        if (empty($parent)) {
            $xParent = '0';
        }
        $xstr = "SELECT * FROM menu WHERE parent='" . $parent . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getdetailmenu($idmenu) {
        $xstr = "SELECT idmenu,title,typepost,parent,url FROM menu WHERE idmenu='" . $idmenu . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getdetailmenubyparent($idmenu) {
        $xstr = "SELECT idmenu,title,typepost,parent,url FROM menu WHERE parent='" . $idmenu . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListmenubytitle($start, $end, $mode, $title = "") {
        if (!empty($title)) {
            $title = " WHERE title Like '%" . $title . "%'";
        }
        $xstr = "SELECT idmenu,title,typepost,parent,url FROM menu $title order by idmenu $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getListmenubyparent($mode, $title = "") {

        $xstr = "SELECT idmenu,title,typepost,parent,url FROM menu WHERE parent='" . $title . "' order by positionmenu $mode ";
        $query = $this->db->query($xstr);
        return $query;
    }

    function checkchild($idmenu) {
        $xstr = "SELECT count(idmenu) as ischild FROM menu WHERE parent='" . $idmenu . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getmenu($idparent, $level) {
        if (empty($idparent)) {
            $idparent = 0;
        }
        if (empty($level)) {
            $level = 1;
        }
        $t = $level == 1 ? " sortable" : "";
        $parent = $this->getListmenubyparent('ASC', $idparent);
        $output = '';
        $output.='<ol class="level' . $level . $t . ' ">' . "\n";
        foreach ($parent->result()as $parent) {
            $output .='<li id="list_' . $parent->idmenu . '">' . "\n" . '
				<div><span class="disclose"><span></span></span>' . ($parent->title ? $parent->title : "") . ' (ID:' . $parent->idmenu . ') <a rel="id_' . $parent->idmenu . '" href="' . base_url() . 'jpmp/menu?id=' . $parent->idmenu . '"><i class="fa fa-edit" title="view & edit" style="cursor:pointer;"  ></i></a><a  rel="id_' . $parent->idmenu . '"  href="' . base_url() . 'jpmp/menu/delete?id=' . $parent->idmenu . '"><i class="fa fa-remove"  title="remove" style="cursor:pointer;"></i></a></div>';
            if ($parent->idmenu >= 1) {
                $output .= $this->getmenu($parent->idmenu, $level + 1);
            }
            $output .= '</li>' . "\n";
        }
        $output.='</ol>' . "\n";
        return $output;
    }

    function createmenu($idparent, $childs, $classparent, $classchilds) {

        if (empty($childs)) {
            $childs = 0;
        }
        $parent = $this->getListmenubyparent('ASC', $idparent);
        $output = '';
        $linkclass = '';
        if ($childs != 0) {
            $output.='<ul class="' . $classparent . '">' . "\n";
        }

        foreach ($parent->result()as $parent) {
            $ischild = $this->checkchild($parent->idmenu)->ischild;
            if ($ischild != 0) {
                $child = $classchilds;
                if ($classchilds == 'dropdown') {
                    $linkclass = 'data-toggle="dropdown" class="dropdown-toggle" ';
                }
            } else {
                $child = "";
            }
            $output .='<li id="menu-menu-' . $parent->idmenu . '" class="' . $child . '"><a ' . $linkclass . ' href="' . $parent->url . '">' . $parent->title . '</a>' . "\n" . '';
            if ($parent->idmenu >= 1) {
                $output .= $this->createmenu($parent->idmenu, $ischild, $classparent, $classchilds);
            }
            $output .= '</li>' . "\n";
        }

        if ($childs != 0) {
            $output.='</ul>' . "\n";
        }

        return $output;
    }

    function getorderdetailmenu($start, $end, $mode, $idmenu) {
        $xstr = "SELECT idmenu,title,typepost,parent,url FROM menu WHERE idmenu='" . $idmenu . " order by idmenu $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertmenu($idmenu, $title, $typepost, $parent, $url) {
        $xstr = "INSERT INTO menu(idmenu,title,typepost,parent,url) VALUES('" . $idmenu . "','" . $title . "','" . $typepost . "','" . $parent . "','" . $url . "')";

        $query = $this->db->query($xstr);
    }

    function updatemenu($idmenu, $title, $typepost, $parent, $url) {
        $xstr = "Update menu set " .
                "idmenu='" . $idmenu . "'," .
                "title='" . $title . "'," .
                "typepost='" . $typepost . "'," .
                "parent='" . $parent . "'," .
                "url='" . $url . "'" .
                " WHERE idmenu='" . $idmenu . "'";
        $query = $this->db->query($xstr);
    }

    function deletemenu($idmenu) {
        $xstr = "DELETE from menu WHERE idmenu='" . $idmenu . "'";
        $query = $this->db->query($xstr);
    }

    public function massUpdate($data, $root) {
        $child = array();
        foreach ($data as $id => $parentId) {
            if ($parentId <= 0) {
                $parentId = $root;
            }
            $child[$parentId][] = $id;
        }

        foreach ($child as $parentId => $menus) {
            $i = 1;
            foreach ($menus as $menuId) {
                $sql = " UPDATE  menu SET parent=" . (int) $parentId . ',positionmenu=' . $i . ' WHERE idmenu=' . (int) $menuId;
                $this->db->query($sql);
                $i++;
            }
        }
    }

}