<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelorder
 *
 * @author user
 */
class modelorder extends CI_Model {

    //put your code here

    function getRowDataOrder($statment) {
        $xstr = "SELECT * FROM orders $statment";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListOrder($statment) {
        $xstr = "SELECT * FROM orders $statment";
        $query = $this->db->query($xstr);

        return $query;
    }

    function getListOrderCustome($statment, $resultStatement) {
        $xstr = "SELECT $resultStatement FROM orders $statment";
        $query = $this->db->query($xstr);

        return $query;
    }

    function getRowDataOrderDetail($statment) {
        $xstr = "SELECT * FROM order_detail $statment";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListOrderDetail($statment) {
        $xstr = "SELECT * FROM order_detail $statment";
        $query = $this->db->query($xstr);

        return $query;
    }

    function getrandom() {
        $dates = date('d-m-Y') . substr((string) microtime(), 1, 32);
        $result = md5('orders' . $dates);
        $chekrandom_code = @$this->getRowDataOrder("WHERE order_random='" . $result . "'")->order_random;
        if (empty($chekrandom_code)) {
            $post_random_code = $result;
        } else {
            $this->getrandom();
        }
        return $post_random_code;
    }

    function insertOrder($code_order, $id_member, $estimate_deliver, $shipping_price, $total_price, $name_order, $address_order, $phone_order, $status_order, $order_random, $shipping_type) {
        $xstr = "INSERT INTO orders (code_order,id_member,estimate_deliver,shipping_price,total_price,name_order,address_order,phone_order,status_order,dates_order,order_random,shipping_type) VALUES ('$code_order','$id_member','$estimate_deliver','$shipping_price','$total_price','$name_order','$address_order','$phone_order','$status_order',now(),'$order_random','$shipping_type')";
        $this->db->query($xstr);
    }

    function inserOrderDetail($id_order, $id_detail_product, $quantity, $price) {
        $xstr = "INSERT INTO order_detail(id_order,id_detail_product,quantity,price) VALUES ('$id_order','$id_detail_product','$quantity','$price')";
        $this->db->query($xstr);
    }

    function updateOrder($id_order, $status_order) {
        $xstr = "UPDATE orders SET status_order='$status_order' WHERE id_order='$id_order'";
        $this->db->query($xstr);
    }

    function updateOrderCustome($Whereorder, $Custome_order) {
        $xstr = "UPDATE orders SET $Custome_order WHERE $Whereorder";
        $this->db->query($xstr);
    }

    function insertReturn($id_orders, $note, $images_return) {
        $xstr = "INSERT INTO returns (code_orders,note,date_return,images_return) VALUES ('$id_orders','$note','now()','$images_return')";
        $this->db->query($xstr);
    }

    function updateReturn($returns_id, $status) {
        $xstr = "UPDATE returns SET status='$status' WHERE returns_id='$returns_id'";
        $this->db->query($xstr);
    }

    function getDataReturn($statement, $ReturnStatment) {
        $xstr = "SELECT $ReturnStatment FROM returns $statement";
        $query = $this->db->query($xstr);
        return $query;
    }

    function getDetailDataReturn($statement,$ReturnStatment) {
        $xstr = "SELECT $ReturnStatment FROM returns $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

}

?>
