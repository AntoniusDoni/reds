<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelslider
 *
 * @author user
 */
class modelslider extends CI_Model {

    //put your code here

    function getDetailSlider($statement) {
        $xstr = "SELECT * FROM slider $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListSlider($statement) {
        $xstr = "SELECT * FROM slider $statement";
        $query = $this->db->query($xstr);
        
        return $query;
    }
    function insertSlider($description,$images,$links,$links_type){
    
        $xstr="INSERT INTO slider (description,images,links,links_type) VALUES ('$description','$images','$links','$links_type')";
        $this->db->query($xstr);
    }
    function updateSlider($id_slider,$description,$images,$links,$links_type){
        
        $xstr="UPDATE slider SET description='$description',images='$images',links='$links',links_type='$links_type' WHERE id_slider='$id_slider'";
        $this->db->query($xstr);
    }
    function deleteSlider($id_slider){
        $xstr="DELETE FROM slider WHERE id_slider='$id_slider'";
        $this->db->query($xstr);
    }
}

?>
