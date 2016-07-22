<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelmember
 *
 * @author user
 */
class modelmember extends CI_Model {

    //put your code here
    function getRowDataMember($statement) {
        $xstr = "SELECT * FROM member $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListMember($statement) {
        $xstr = "SELECT * FROM member $statement";
        $query = $this->db->query($xstr);

        return $query;
    }

    function insertMember($name, $emails, $phone, $address, $password) {
        $xstr = "INSERT INTO member (name,emails,phone,address,password) VALUES ('$name','$emails','$phone','$address','$password')";
        $this->db->query($xstr);
    }

    function updateMember($id_member, $name, $emails, $phone, $address, $password) {
        $xstr = "UPDATE member SET name='$name',emails='$emails',phone='$phone',address='$address',password='$password'  WHERE id_member='$id_member'";
        $this->db->query($xstr);
    }

    function updateMemberTheme($member_themes,$id_member) {
        $xstr = "UPDATE member SET member_themes='$member_themes'WHERE id_member='$id_member'";
        $this->db->query($xstr);
    }

    function deleteMember($id_member) {
        $xstr = "DELETE FROM member WHERE id_member='$id_member'";
        $this->db->query($xstr);
    }

}

?>
