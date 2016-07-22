<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelpost
 *
 * @author user
 */
class modelpost extends CI_Model {

//put your code here
    function getArrayPost() {
        $xstr = "Select id_post,title From post ";
        $query = $this->db->query($xstr);
        $xBufResult[0] = "Uncategorized";
        foreach ($query->result() as $row) {
            $xBufResult[$row->id_post] = $row->title;
        }
        return $xBufResult;
    }

    function getRowDataPost($stament) {
        $xstr = "SELECT * FROM post $stament";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getRowDataPostCustome($stament, $resultsData) {
        $xstr = "SELECT $resultsData FROM post $stament";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function getRowDataPostDesciptCustome($stament, $resultsData) {
        $xstr = "SELECT $resultsData FROM post_description $stament";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getRowDataPosCommenttCustome($stament, $resultsData) {
        $xstr = "SELECT $resultsData FROM post_comment $stament";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListDataPost($stament) {
        $xstr = "SELECT * FROM post $stament";
        $query = $this->db->query($xstr);

        return $query;
    }

    function getRowDataPost_Desciption($stament) {
        $xstr = "SELECT * FROM post_description $stament";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }

    function getListDataPost_Description($stament) {
        $xstr = "SELECT * FROM post_description $stament";
        $query = $this->db->query($xstr);

        return $query;
    }

    function getrandom() {
        $dates = date('d-m-Y') . substr((string) microtime(), 1, 32);
        $result = md5('post' . $dates);
        $chekrandom_code = @$this->getRowDataPost("WHERE post_randcode='" . $result . "'")->post_randcode;
        if (empty($chekrandom_code)) {
            $post_random_code = $result;
        } else {
            $this->getrandom();
        }
        return $post_random_code;
    }

    function insertPost($id_category, $title, $images, $metaTag, $metDescription, $post_randcode,$dates_post,$creat_id) {
        $xstr = "INSERT INTO post (id_category,title,images,metaTag,metadescription,post_randcode,dates_post,creat_id) VALUES('$id_category','$title','$images','$metaTag','$metDescription','$post_randcode','$dates_post','$creat_id')";
        $this->db->query($xstr);
    }

    function insertPost_Description($id_post_description, $description, $lang, $id_post) {
        $xstr = "INSERT INTO post_description (id_post_description,description,lang,id_post) VALUES('$id_post_description','$description','$lang','$id_post')";
        $this->db->query($xstr);
    }

    function updateUrlpost($id_post, $url) {
        $xstr = "UPDATE post SET url='$url'  WHERE id_post='$id_post'";
        $this->db->query($xstr);
    }

    function updatePost($id_category, $id_post, $title, $images, $metaTag, $metDescription,$dates_post) {
        $xstr = "UPDATE post SET id_category='$id_category',title='$title',images='$images',metaTag='$metaTag',metadescription='$metDescription',dates_post='$dates_post' WHERE id_post='$id_post'";
        $this->db->query($xstr);
    }

    function updatePost_Description($description, $lang, $id_post) {
        $xstr = "UPDATE post_Description SET description='$description' WHERE id_post='$id_post' and lang='$lang'";
        $this->db->query($xstr);
    }

    function deletePost($id_post) {
        $xstr = "DELETE FROM post WHERE id_post='$id_post'";
        $this->db->query($xstr);
    }

    function deletePost_Description($id_post) {
        $xstr = "DELETE FROM post_description WHERE id_post='$id_post'";
        $this->db->query($xstr);
    }

    //comment post
    function getListComment($idpost,$idparent,$mode) {
        $output='';
        $parent = $this->getListPostbyparent($mode,$idparent,$idpost);
        foreach ($parent->result()as $parent) {
              $output.='<li>';
            if($parent->id_parent_comment==0){
                $output.='
                <div class="comment">
                <div class="user">
                                            <span class="name">' . $parent->username . '</span>
                                            <span class="date">' . $parent->time_comment . '</span>
                                        </div>
                <div class="text">
                                            <div class="comment-style">
                                                <h3>' . $parent->subject . ' <a href="#contact-form" class="reply pull-right" onclick="getParentComment('.$parent->id_post_comment.')">Reply</a></h3>
                                                <div class="text-wrap">
                                                    <p>
                                                        ' . html_entity_decode($parent->comment) . '
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                </div>';
                 $output.=@$this->getListComment($parent->id_post,$parent->id_post_comment,'ASC');
            }else{
            
           
                $output.=' <ul>';
                $output.='<li>
                <div class="comment">
                <div class="user">
                                            <span class="name">' . $parent->username . '</span>
                                            <span class="date">' . $parent->time_comment . '</span>
                                        </div>
                <div class="text">
                                            <div class="comment-style">
                                                <h3>' . $parent->subject . ' <a href="#contact-form" class="reply pull-right" onclick="getParentComment('.$parent->id_post_comment.')">Reply</a></h3>
                                                <div class="text-wrap">
                                                    <p>
                                                        ' . html_entity_decode($parent->comment) . '
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                </div>';
                 $output.=@$this->getListComment($parent->id_post,$parent->id_post_comment,'DESC');
                $output.='<li></ul>';
                
            }
              $output.='</li>';
             
        }
        return $output;
    }

    function getListPostbyparent($mode,$idparent,$idpost) {
        $xstr = "SELECT *,DATE_FORMAT(input_date,'%d.%m.%y ') as time_comment FROM post_comment WHERE id_parent_comment='" . $idparent . "' and id_post='$idpost' and is_publish='1' order by input_date $mode ";
        $query = $this->db->query($xstr);
        return $query;
    }
    function getListComments($statement){
        $xstr = "SELECT post_comment.*,DATE_FORMAT(input_date,'%d.%m.%y ') as time_comment FROM post_comment $statement";
        $query = $this->db->query($xstr);
        return $query;
    }
    function getDetailComments($statement){
         $xstr = "SELECT *,DATE_FORMAT(input_date,'%d.%m.%y ') as time_comment FROM post_comment $statement";
        $query = $this->db->query($xstr);
        $row = $query->row();
        return $row;
    }
    function inserPostComment($id_post_comment,$subject,$comment,$username,$emails,$id_post,$id_parent_comment){
        $xstr="INSERT INTO post_comment (id_post_comment,subject,comment,username,emails,input_date,id_post,id_parent_comment) VALUES ('$id_post_comment','$subject','$comment','$username','$emails',now(),'$id_post','$id_parent_comment')";
        $this->db->query($xstr);
    }
    function inserPostComments($id_post_comment,$subject,$comment,$username,$emails,$id_post,$id_parent_comment,$is_publish){
        $xstr="INSERT INTO post_comment (id_post_comment,subject,comment,username,emails,input_date,id_post,id_parent_comment,is_publish) VALUES ('$id_post_comment','$subject','$comment','$username','$emails',now(),'$id_post','$id_parent_comment','$is_publish')";
        $this->db->query($xstr);
    }
    function updatePostComment($id_post_comment,$status){
        $xstr="UPDATE post_comment SET is_publish='$status' WHERE id_post_comment='$id_post_comment'";
        $this->db->query($xstr);
    }
    function delete($id_post_comment){
        $xstr="DELETE FROM post_comment WHERE id_post_comment='$id_post_comment'";
        $this->db->query($xstr);
    }

}

?>
