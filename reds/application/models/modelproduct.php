<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelproduct
 *
 * @author user
 */
class modelproduct extends CI_Model {

    //put your code here
     function getArrayProductSize($id_product) {
        $xstr = "Select size,id_product_detail From product_detail WHERE id_product='$id_product'";
        $query = $this->db->query($xstr);
        $xBufResult[0] = "Uncategorized";
        foreach ($query->result() as $row) {
            $xBufResult[$row->size] = $row->size;
        }
        return $xBufResult;
    }
    function getRowDataProduct($statement) {
        $xstr = "SELECT * FROM product $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function getRowDataProductCustome($statement,$returnCondition){
        $xstr = "SELECT $returnCondition FROM product $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListProduct($statement) {
        $xstr = "SELECT * FROM product $statement";
        $query = $this->db->query($xstr);

        return $query;
    }

    function getRowDataProduct_Detail($statement) {
        $xstr = "SELECT * FROM product_detail $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListProduct_detail($statement) {
        $xstr = "SELECT * FROM product_detail $statement";
        $query = $this->db->query($xstr);

        return $query;
    }

    function insertProduct($title, $description, $id_category, $main_images, $metaTag, $metaDescription, $product_random,$images1,$images2,$images3) {
        $xstr = "INSERT INTO product (title,description,id_category,main_images,metaTag,metaDescription,product_random,images1,images2,images3) VALUES ('$title','$description','$id_category','$main_images','$metaTag','$metaDescription','$product_random','$images1','$images2','$images3')";
        $this->db->query($xstr);
    }

    function insertProduct_detail($size, $prices, $stok, $id_product, $diskon) {
        $xstr = "INSERT INTO product_detail (size,prices,stok,id_product,diskon) VALUES ('$size','$prices','$stok','$id_product','$diskon')";
        $this->db->query($xstr);
    }

    function updateProduct($id_product, $title, $description, $id_category, $main_images, $metaTag, $metaDescription,$images1,$images2,$images3) {

        $xstr = "UPDATE product SET title='$title',description='$description',id_category='$id_category',main_images='$main_images',metaTag='$metaTag',metaDescription='$metaDescription',images1='$images1',images2='$images2',images3='$images3' WHERE id_product='$id_product'";
        $this->db->query($xstr);
    }

    function updateProductUrl($id_product,$url) {
        $xstr="UPDATE product SET url='$url' WHERE id_product='$id_product'";
        $this->db->query($xstr);
    }

    function updateProduct_detail($id_product_detail, $size, $prices, $stok, $id_product, $diskon) {
        $xstr = "UPDATE product_detail SET size='$size',prices='$prices',stok='$stok',diskon='$diskon' WHERE id_product_detail='$id_product_detail'";
        $this->db->query($xstr);
    }
    function updateProduct_detailStatement($statement,$updateStatement){
        $xstr="UPDATE product_detail SET $updateStatement $statement";
        $this->db->query($xstr);
    }
    function deleteProduct($id_product) {
        $xstr = "DELETE FROM product WHERE id_product='$id_product'";
        $this->db->query($xstr);
    }

    function deleteProduct_detail($id_product) {
        $xstr = "DELETE FROM product_detail WHERE id_product='$id_product'";
        $this->db->query($xstr);
    }

    function getrandom() {
        $dates = date('d-m-Y') . substr((string) microtime(), 1, 32);
        $result = md5('product' . $dates);
        $chekrandom_code = @$this->getRowDataProduct("WHERE product_random='" . $result . "'")->product_random;
        if (empty($chekrandom_code)) {
            $post_random_code = $result;
        } else {
            $this->getrandom();
        }
        return $post_random_code;
    }

}

?>
