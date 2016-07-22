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
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $data['images'] = $this->getDirImage();
            $this->load->view('jpmp/header');
            $this->load->view('jpmp/shop', $data);
            $this->load->view('jpmp/footer');
        } else {
            $this->load->helper('url');
            $uri = base_url() . 'jpmp/beadmin';
            redirect($uri);
        }
    }

    function getDirImage() {
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
                                        <img src="' . base_url() . '' . $file . '" style="width: 100%;"/>
                                    </div>
                                </div>
                                 <a href="' . base_url() . 'jpmp/shop/getiscom?thems=' . $filename[0] . '&iscom=1" class="small-box-footer">Active Themes <i class="fa fa-arrow-circle-right"></i></a>
                                 <a href="' . base_url() . 'jpmp/shop/getiscom?thems=defaults&iscom=0" class="small-box-footer" style="float: right;">Deactive Themes <i class="fa fa-arrow-circle-left"></i></a>
                            </div>';
            }
        }
        return $viewThems;
    }

    function getiscom() {
        $useracces = $this->session->userdata('useracces');
        if (!empty($useracces)) {
            $this->load->model('modelsetting');
            $thems = $_GET['thems'];
            $iscom = $_GET['iscom'];
            $idgm = $this->session->userdata('useracces');
            $this->modelsetting->getUpdateSetting($thems, $iscom, $idgm);
            echo '<script type="text/javascript">'
            . 'alert("Themes Set");'
            . 'document.location.href="' . base_url() . 'jpmp/shop"'
            . '</script>';
        } else {
            redirect(base_url() . 'jpmp/beadmin');
        }
    }

}

?>
