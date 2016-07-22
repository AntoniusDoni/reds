<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of filemanager
 *
 * @author Doni
 */
class filemanager extends CI_Controller {

    //put your code here
    public function index() {
        $this->load->model('modelimages');
        $data['no_image'] = $this->modelimages->resize('no_image.jpg', 100, 100);
        if (isset($_GET['CKEditorFuncNum'])) {
            $data['fckeditor'] = $_GET['CKEditorFuncNum'];
        } else {
            $data['fckeditor'] = false;
        }
        if (isset($_GET['field'])) {
           $data['field'] = $_GET['field'];
        } else {
           $data['field'] = '';
        }
        $this->load->view('jpmp/filemanager', $data);
    }

    function image() {
        $this->load->model('modelimages');

        if (isset($_GET['image'])) {
            return $this->modelimages->resize(html_entity_decode($_GET['image'], ENT_QUOTES, 'UTF-8'), 100, 100);
        }
    }

    public function directory() {

        $json = array();

        if (isset($_POST['directory'])) {
            $directories = glob(rtrim('images/data/' . str_replace('../', '', $_POST['directory']), '/') . '/*', GLOB_ONLYDIR);

            if ($directories) {
                $i = 0;

                foreach ($directories as $directory) {
                    $json[$i]['data'] = basename($directory);
                    $json[$i]['attributes']['directory'] = substr($directory, strlen('images/data/'));

                    $children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);

                    if ($children) {
                        $json[$i]['children'] = ' ';
                    }

                    $i++;
                }
            }
        }



//        $this->json_data = $json;
        echo json_encode($json);
//        echo json_encode($json);
    }

    public function files() {
        $json = array();

        if (!empty($_POST['directory'])) {
            $directory = 'images/data/' . str_replace('../', '', $_POST['directory']);
        } else {
            $directory = 'images/data/';
        }

        $allowed = array(
            '.jpg',
            '.jpeg',
            '.png',
            '.gif'
        );

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

                    while (($size / 1024) > 1) {
                        $size = $size / 1024;
                        $i++;
                    }

                    $json[] = array(
                        'filename' => basename($file),
                        'file' => substr($file, strlen('images/data/')),
                        'size' => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]
                    );
                }
            }
        }

//		$this->response->setOutput(json_encode($json));
        echo json_encode($json);
    }

    public function create() {
        $json = array();

        if (isset($_POST['directory'])) {
            if (isset($_POST['name']) || $_POST['name']) {
                $directory = rtrim('images//data/' . str_replace('../', '', $_POST['directory']), '/');

                if (!is_dir($directory)) {
                    $json['error'] = 'Warning: Please select a directory!';
                }

                if (file_exists($directory . '/' . str_replace('../', '', $_POST['name']))) {
                    $json['error'] = 'Warning: A file or directory with the same name already exists';
                }
            } else {
                $json['error'] = 'Warning: Please enter a new name!';
            }
        } else {
            $json['error'] = 'Warning: Please select a directory!';
        }



        if (!isset($json['error'])) {
            mkdir($directory . '/' . str_replace('../', '', $_POST['name']), 0777);

            $json['success'] = 'Folder is Created';
        }

        echo json_encode($json);
    }

    public function deleteimages() {


        $json = array();

        if (isset($_POST['path'])) {
            $path = rtrim('images/data/' . str_replace('../', '', html_entity_decode($_POST['path'], ENT_QUOTES, 'UTF-8')), '/');
            
            if (!file_exists($path)) {
                $json['error'] = 'Warning: Please select a directory or file!';
            }

            if ($path == rtrim('images/data/', '/')) {
                $json['error'] = 'Warning: You can not delete this directory!';
            }
        } else {
            $json['error'] = 'Warning: Please select a directory or file!';
        }



        if (!isset($json['error'])) {
            if (is_file($path)) {
                unlink($path);
            } elseif (is_dir($path)) {
                $files = array();

                $path = array($path . '*');

                while (count($path) != 0) {
                    $next = array_shift($path);

                    foreach (glob($next) as $file) {
                        if (is_dir($file)) {
                            $path[] = $file . '/*';
                        }

                        $files[] = $file;
                    }
                }

                rsort($files);

                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    } elseif (is_dir($file)) {
                        rmdir($file);
                    }
                }
            }
             

            $json['success'] = 'Success: Your file or directory has been deleted';
        }

        echo json_encode($json);
    }

    function folders() {
        echo $this->recursiveFolders('images/data/');
    }

    protected function recursiveFolders($directory) {
        $output = '';

        $output .= '<option value="' . substr($directory, strlen('images/data/')) . '">' . substr($directory, strlen('images/data/')) . '</option>';

        $directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);

        foreach ($directories as $directory) {
            $output .= $this->recursiveFolders($directory);
        }

        return $output;
    }

    public function move() {


        $json = array();

        if (isset($_POST['from']) && isset($_POST['to'])) {
            $from = rtrim('images/data/' . str_replace('../', '', html_entity_decode($_POST['from'], ENT_QUOTES, 'UTF-8')), '/');

            if (!file_exists($from)) {
                $json['error'] = 'Warning: File or directory does not exist!';
            }

            if ($from == 'images/data/') {
                $json['error'] = 'Warning: Can not alter your default directory!';
            }

            $to = rtrim('images/data/' . str_replace('../', '', html_entity_decode($_POST['to'], ENT_QUOTES, 'UTF-8')), '/');

            if (!file_exists($to)) {
                $json['error'] = 'Warning: Move to directory does not exists!';
            }

            if (file_exists($to . '/' . basename($from))) {
                $json['error'] = 'Warning: A file or directory with the same name already exists!';
            }
        } else {
            $json['error'] = 'Warning: Please select a directory!';
        }



        if (!isset($json['error'])) {
            rename($from, $to . '/' . basename($from));

            $json['success'] = 'Your file or directory has been moved!';
        }

        echo json_encode($json);
    }

    public function copy() {


        $json = array();

        if (isset($_POST['path']) && isset($_POST['name'])) {
            if ((strlen($_POST['name']) < 3) || (strlen($_POST['name']) > 255)) {
                $json['error'] = 'Warning: Filename must be a between 3 and 255!';
            }

            $old_name = rtrim('images/data/' . str_replace('../', '', html_entity_decode($_POST['path'], ENT_QUOTES, 'UTF-8')), '/');

            if (!file_exists($old_name) || $old_name == 'images/data') {
                $json['error'] = 'Warning: Can not copy this file or directory!';
            }

            if (is_file($old_name)) {
                $ext = strrchr($old_name, '.');
            } else {
                $ext = '';
            }

            $new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($_POST['name'], ENT_QUOTES, 'UTF-8') . $ext);

            if (file_exists($new_name)) {
                $json['error'] = 'Warning: A file or directory with the same name already exists!';
            }
        } else {
            $json['error'] = 'Warning: Please select a directory or file!';
        }



        if (!isset($json['error'])) {
            if (is_file($old_name)) {
                copy($old_name, $new_name);
            } else {
                $this->recursiveCopy($old_name, $new_name);
            }

            $json['success'] = 'Your file or directory has been copied!';
        }

        echo json_encode($json);
    }

    function recursiveCopy($source, $destination) {
        $directory = opendir($source);

        @mkdir($destination);

        while (false !== ($file = readdir($directory))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source . '/' . $file)) {
                    $this->recursiveCopy($source . '/' . $file, $destination . '/' . $file);
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }

        closedir($directory);
    }

    public function rename() {


        $json = array();

        if (isset($_POST['path']) && isset($_POST['name'])) {
            if ((strlen($_POST['name']) < 3) || (strlen($_POST['name']) > 255)) {
                $json['error'] = 'Warning: Filename must be a between 3 and 255!';
            }

            $old_name = rtrim('images/data/' . str_replace('../', '', html_entity_decode($_POST['path'], ENT_QUOTES, 'UTF-8')), '/');

            if (!file_exists($old_name) || $old_name == 'images/data') {
                $json['error'] = 'Warning: Filename must be a between 3 and 255!';
            }

            if (is_file($old_name)) {
                $ext = strrchr($old_name, '.');
            } else {
                $ext = '';
            }

            $new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($_POST['name'], ENT_QUOTES, 'UTF-8') . $ext);

            if (file_exists($new_name)) {
                $json['error'] = 'Warning: A file or directory with the same name already exists!';
            }
        }



        if (!isset($json['error'])) {
            rename($old_name, $new_name);

            $json['success'] = 'Success: Your file or directory has been renamed!';
        }

        echo json_encode($json);
    }

    public function upload() {


        $json = array();

        if (isset($_POST['directory'])) {
            if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
                $filename = basename(html_entity_decode($_FILES['image']['name'], ENT_QUOTES, 'UTF-8'));

                if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
                    $json['error'] = 'Warning: Filename must be a between 3 and 255!';
                }

                $directory = rtrim('images/data/' . str_replace('../', '', $_POST['directory']), '/');

                if (!is_dir($directory)) {
                    $json['error'] = 'Warning: Please select a directory';
                }

                if ($_FILES['image']['size'] > 3000000) {
                    $json['error'] = 'Warning: File too big please keep below 300kb and no more than 1000px height or width!';
                }

                $allowed = array(
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/x-png',
                    'image/gif',
                    'application/x-shockwave-flash'
                );

                if (!in_array($_FILES['image']['type'], $allowed)) {
                    $json['error'] = 'Warning: Incorrect file type!';
                }

                $allowed = array(
                    '.jpg',
                    '.jpeg',
                    '.gif',
                    '.png',
                    '.flv'
                );

                if (!in_array(strtolower(strrchr($filename, '.')), $allowed)) {
                    $json['error'] = 'Warning: Incorrect file type!';
                }

                // Check to see if any PHP files are trying to be uploaded
                $content = file_get_contents($_FILES['image']['tmp_name']);

                if (preg_match('/\<\?php/i', $content)) {
                    $json['error'] = 'Warning: Incorrect file type!';
                }

                if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
                    $json['error'] = 'error_upload_' . $_FILES['image']['error'];
                }
            } else {
                $json['error'] = 'Warning: Please select a file!';
            }
        } else {
            $json['error'] = 'Warning: Please select a directory!';
        }



        if (!isset($json['error'])) {
            if (@move_uploaded_file($_FILES['image']['tmp_name'], $directory . '/' . $filename)) {
                $json['success'] = 'Success: Your file has been uploaded!';
            } else {
                $json['error'] = 'Warning: File could not be uploaded for an unknown reason!';
            }
        }

        echo json_encode($json);
    }

}
