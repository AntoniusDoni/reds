<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comments
 *
 * @author user
 */
class comments extends CI_Controller {

    //put your code here
    public function index() {

        $idmember = $this->session->userdata('idmember');
        if (!empty($idmember)) {
            $this->load->model("modelmember");
            $this->load->model("modelorder");
            $this->load->helper('form');
            $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | My Account';
            $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->title . "| My Account";
            $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->title . "| My Account";
            $data['load'] = $load;
            $data['idmember'] = $idmember;
            $iscommer = @$this->modelsetting->getdetailsetting(1)->isecommer;
            if ($iscommer == '1') {
                $themes = 'themes/shop/';
            } else {
                $themes = 'themes/profile/';
            }
            $this->load->model('modelpost');
            $this->load->model('modelcategory');
            $this->load->helper('form');
            if (!empty($_GET['id'])) {
                $idpost = $_GET['id'];
            } else {
                $idpost = 0;
            }
            $data['idpost'] = $idpost;
            $data['tablecontent'] = $this->getComment();
            $data['path'] = base_url() . '' . $themes . '' . $load;
            $this->load->view($load . 'header_member', $data);
            $this->load->view('jpmp/comments', $data);
            $this->load->view($load . 'footer_member');
        } else {
            redirect(base_url() . 'sign');
        }
    }

    function getComment() {
        $this->load->model('modelpost');
        $this->load->model("modelmember");
        $idmember = $this->session->userdata('idmember');
        $creat_id=@$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->emails;
        $querytable = $this->modelpost->getListComments("
            INNER JOIN post AS p ON p.id_post=post_comment.id_post 
INNER JOIN member AS m ON m.emails=p.creat_id WHERE creat_id='$creat_id' order by input_date DESC");
        $content = '';
        $no = 1;
        $arrayStatus['0'] = 'No Publish';
        $arrayStatus['1'] = 'Publish';
        foreach ($querytable->result()as $rowtable) {
            $content.=' <tr>
                                <td>' . $no . '</td>
                                <td>' . @$this->modelpost->getRowDataPost("WHERE id_post='$rowtable->id_post'")->title . '</td>
                                <td>' . $rowtable->username . ' ( ' . $rowtable->emails . ' )</td>
                                <td>' . $rowtable->subject . '</td>
                                <td>' . html_entity_decode($rowtable->comment) . '</td>
                                <td>
                               ' . form_dropdown('status_comment' . $no, $arrayStatus, $rowtable->is_publish, 'id="status_comment' . $no . '" onchange="getStatusComment(' . $no . ',' . $rowtable->id_post_comment . ');"') . '</td>
                                 <td><a href="' . base_url() . 'comments?id=' . $rowtable->id_post_comment . '"><i class="fa fa-reply" title="Reply" style="cursor:pointer;"  ></i></a> / '
                    . '                 <a href="' . base_url() . 'comments/delete?id=' . $rowtable->id_post_comment . '"><i class="fa fa-remove"  title="Remove" style="cursor:pointer;"></i></a>
                                </td>
                            </tr>';
            $no++;
        }
        return $content;
    }

    function delete() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $id = $_GET['id'];
            $this->load->model('modelpost');
            $this->modelpost->delete($id);
            redirect(base_url() . 'jpmp/comments');
        } else {
            $this->load->helper('url');
            $uri = base_url() . '';
            redirect($uri);
        }
    }

    function updateStatus() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelpost');
            $status_comment = $_POST['status_comment'];
            $idComment = $_POST['idComment'];
            $this->modelpost->updatePostComment($idComment, $status_comment);
        } else {
            $this->load->helper('url');
            $uri = base_url() . '';
            redirect($uri);
        }
    }

    function reply() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelpost');
            $this->load->model('modelsetting');
            $id_parent_comment = $_POST['id_parent_comment'];
            $xdetailComment = $this->modelpost->getDetailComments("WHERE id_post_comment='$id_parent_comment'");
            $xstting = $this->modelsetting->getDetailSetting(1);
            $comments = str_replace("'", '&#39;', $_POST['comments']);

            $this->modelpost->inserPostComments('', $xdetailComment->subject, $comments, 'Admin', $xstting->emails, $xdetailComment->id_post, $id_parent_comment, '1');
            $uri = base_url() . 'comments';
            redirect($uri);
        } else {
            $uri = base_url() . 'comments';
            redirect($uri);
        }
    }

}

?>
