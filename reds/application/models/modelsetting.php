<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelsetting
 *
 * @author user
 */
class modelsetting extends CI_Model {

    //put your code here
    function getDataLogin($email, $password) {
        $xstr = "SELECT * FROM setting WHERE emails='$email' and password='$password'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getDetailSetting($idgm) {
        $xstr = "SELECT * FROM setting WHERE idgm='$idgm' ";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getUpdateSetting($thems, $iscom, $idgm) {
        $xstr = "UPDATE setting set isecommer='$iscom', theme='$thems' WHERE idgm='$idgm'";
        $this->db->query($xstr);
    }

    function getArrayBank() {
        $xstr = "Select bank_account_id,bank_name,bank_account,bank_owner From bank_account ";
        $query = $this->db->query($xstr);
//        $xBufResult[0] = "Uncategorized";
        foreach ($query->result() as $row) {
            $xBufResult[$row->bank_account_id] = $row->bank_name . '-' . $row->bank_account . '-' . $row->bank_owner;
        }
        return $xBufResult;
    }

    function getListBank($statement) {
        $xstr = "Select bank_account_id,bank_name,bank_account,bank_owner From bank_account $statement";
        $query = $this->db->query($xstr);
        return $query;
    }

    function getDetailBank($bank_account_id) {
        $xstr = "Select bank_account_id,bank_name,bank_account,bank_owner From bank_account WHERE bank_account_id='$bank_account_id'";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function insertbank_account($bank_account_id, $bank_name, $bank_account, $bank_owner){
        $xstr="INSERT INTO bank_account (bank_account_id,bank_name,bank_account,bank_owner) VALUES('$bank_account_id', '$bank_name', '$bank_account', '$bank_owner')";
        $this->db->query($xstr);
    }
    function updatebank_account($bank_account_id, $bank_name, $bank_account, $bank_owner){
        $xstr="UPDATE bank_account SET bank_name='$bank_name',bank_account='$bank_account',bank_owner='$bank_owner' WHERE bank_account_id='$bank_account_id'";
        $this->db->query($xstr);
    }
    function deletebank_account($bank_account_id){
        $xstr="DELETE FROM bank_account WHERE bank_account_id='$bank_account_id'";
        $this->db->query($xstr);
    }

}

?>
