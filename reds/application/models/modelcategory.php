<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelcategory
 *
 * @author user
 */
class modelcategory extends CI_Model{
    //put your code here
    function getArraycategory() {
        $xstr = "Select category_id,category_name,category_parent,category_images,category_url From category ";
        $query = $this->db->query($xstr);
        $xBufResult[0] = "Uncategorized";
        foreach ($query->result() as $row) {
            $xBufResult[$row->category_id] = $row->category_name;
        }
        return $xBufResult;
    }

    function getdetailcategory($category_id) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category WHERE category_id='" . $category_id . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getdetailcategorybycategory_url($category_url) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category WHERE category_url='" . $category_url . "'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getdetailcategorybycategory_name($category_name, $mode) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category WHERE category_name Like '" . $category_name . "' order by category_id $mode limit 0,1";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getdetailcategorybystatement($statement) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category $statement ";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListcategorybycategory_id($start, $end, $mode, $category_name = "") {
        if (!empty($category_name)) {
            $category_name = " WHERE category_name Like '%" . $category_name . "%'";
        }
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category $category_name order by category_id $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        return $query;
    }

    function getListcategory($mode) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category order by category_id $mode ";
        $query = $this->db->query($xstr);
        return $query;
    }

    function getListcategorybystatement($statement) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category $statement ";
        $query = $this->db->query($xstr);
        return $query;
    }

    function getorderdetailcategory($start, $end, $mode, $category_id) {
        $xstr = "SELECT category_id,category_name,category_parent,category_images,category_url FROM category WHERE category_id='" . $category_id . " order by category_id $mode limit " . $start . "," . $end;
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function insertcategory($category_id, $category_name, $category_parent, $category_images, $category_url) {
        $xstr = "INSERT INTO category(category_id,category_name,category_parent,category_images,category_url) VALUES('" . $category_id . "','" . $category_name . "','" . $category_parent . "','" . $category_images . "','" . $category_url . "')";

        $query = $this->db->query($xstr);
    }

    function updatecategory($category_id, $category_name, $category_parent, $category_images) {
        $xstr = "Update category set " .
                "category_id='" . $category_id . "'," .
                "category_name='" . $category_name . "'," .
                "category_parent='" . $category_parent . "'," .
                "category_images='" . $category_images . "'" .
                " WHERE category_id='" . $category_id . "'";
        $query = $this->db->query($xstr);
    }

    function updatecategorycategory_url($category_id, $category_url) {
        $xstr = "Update category set " .
                "category_url='" . $category_url . "'" .
                " WHERE category_id='" . $category_id . "'";
        $query = $this->db->query($xstr);
    }

    function deletecategory($category_id) {
        $xstr = "DELETE from category WHERE category_id='" . $category_id . "'";
        $query = $this->db->query($xstr);
    }
}

?>
