<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of shop
 *
 * @author user
 */
class shop extends CI_Controller {

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
            $data['images'] = $this->getDirImage();
            $data['path'] = base_url() . '' . $themes . '' . $load;
            $this->load->view($load . 'header_member', $data);
            $this->load->view('jpmp/shop', $data);
            $this->load->view($load . 'footer_member');
        } else {
            redirect(base_url() . 'sign');
        }
    }

    function getDirImage() {
        $iscommer = @$this->modelsetting->getdetailsetting(1)->isecommer;
        $idmember = $this->session->userdata('idmember');
        $this->load->model('modelmember');
        if ($iscommer != 1) {
            $directory = 'themes/pref/';

            $allowed = array(
                '.jpg',
                '.jpeg',
                '.png',
                '.gif'
            );
            $viewThems = '';
            $files = glob(rtrim($directory, '/') . '/*');
            if ($files) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $ext = strrchr($file, '.');
                    } else {
                        $ext = '';
                    }

                    if (in_array(strtolower($ext), $allowed)) {
                        $size = filesize($file);

                        $i = 0;

                        $suffix = array(
                            'B',
                            'KB',
                            'MB',
                            'GB',
                            'TB',
                            'PB',
                            'EB',
                            'ZB',
                            'YB'
                        );



                        $json[] = array(
                            'filename' => basename($file),
                            'file' => substr($file, strlen('themes/pref/')),
                            'size' => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]
                        );
                    }
                    $filenames = substr($file, strlen('themes/pref/'));
                    $filename = explode('.', $filenames);
                    
                    $viewThems.=' <div class="col-lg-3 col-xs-6">
                                <div class="small-box">
                                    <div class="icon">
                                        <img src="' . base_url() . '' . $file . '" style="width: 100%;max-height: 486px; min-height: 150px;"/>
                                    </div>
                                </div>
                                 <a  href="' . base_url() . 'shop/getiscom?thems=' . $filename[0] . '&iscom=1" class="small-box-footer">Active  <i class="fa fa-arrow-circle-right"></i></a>
                                 <a href="' . base_url() . 'shop/getiscom?thems=defaults&iscom=0" class="small-box-footer" style="float: right;">Deactive <i class="fa fa-arrow-circle-left"></i></a>
                            </div>';
                }
            }
        } else {
             $directory = 'themes/shop/';

            $allowed = array(
                '.jpg',
                '.jpeg',
                '.png',
                '.gif'
            );
            $viewThems = '';
            $files = glob(rtrim($directory, '/') . '/*');
            if ($files) {
                foreach ($files as $file) {
                    if (is_file($file)) {
                        $ext = strrchr($file, '.');
                    } else {
                        $ext = '';
                    }

                    if (in_array(strtolower($ext), $allowed)) {
                        $size = filesize($file);

                        $i = 0;

                        $suffix = array(
                            'B',
                            'KB',
                            'MB',
                            'GB',
                            'TB',
                            'PB',
                            'EB',
                            'ZB',
                            'YB'
                        );



                        $json[] = array(
                            'filename' => basename($file),
                            'file' => substr($file, strlen('themes/shop/')),
                            'size' => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]
                        );
                    }
                    $filenames = substr($file, strlen('themes/shop/'));
                    $filename = explode('.', $filenames);
                    $viewThems.=' <div class="col-lg-3 col-xs-6">
                                <div class="small-box">
                                    <div class="icon">
                                        <img src="' . base_url() . '' . $file . '" style="width: 100%;max-height: 486px; min-height: 150px;"/>
                                    </div>
                                </div>
                                 <a href="' . base_url() . 'shop/getiscom?thems=' . $filename[0] . '&iscom=1" class="small-box-footer">Active  <i class="fa fa-arrow-circle-right"></i></a>
                                 <a href="' . base_url() . 'shop/getiscom?thems=defaults&iscom=0" class="small-box-footer" style="float: right;">Deactive <i class="fa fa-arrow-circle-left"></i></a>
                            </div>';
                }
            }
        }
        return $viewThems;
    }

    function getiscom() {
        $idmember = $this->session->userdata('idmember');
        if (!empty($idmember)) {
            $this->load->model('modelmember');
            $thems = $_GET['thems'];
            $iscom = $_GET['iscom'];
            $idgm = $this->session->userdata('useracces');
            $this->modelmember->updateMemberTheme($thems, $idmember);
            echo '<script type="text/javascript">'
            . 'alert("Themes Set");'
            . 'document.location.href="' . base_url() . 'shop"'
            . '</script>';
        } else {
            redirect(base_url() . '');
        }
    }

}

?>
