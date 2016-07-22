<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sign
 *
 * @author user
 */
class sign extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();
        
        $this->load->model('modelcategory');
        $this->load->model("modelproduct");

        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index() {
        $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
        $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | Login | Sign in';
        $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->title . "| Login | Sign in";
        $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->title . "| Login | Sign in";
        $data['load'] = $load;
        //        init location folder themes
            $themes = 'themes/';
//        set path directory themes
            $data['path'] = base_url() . '' . $themes . '' . $load;
        $this->load->view($load . 'header', $data);
        $this->load->view($load . 'sign', $data);
        $this->load->view($load . 'footer');
    }

    function loginmember() {
        $this->load->model('modelmember');
        $emails = $_POST['email'];
        $password = $_POST['password'];
        $checkMember = @$this->modelmember->getRowDataMember("WHERE emails='$emails' and password='$password'");
        if (!empty($checkMember)) {
            $this->session->set_userdata('idmember', $checkMember->id_member);
            $this->load->library('cart');
            if ($this->cart->total_items() != 0) {
                echo '<script type="text/javascript">'
                . 'alert("Login done..");'
                . 'document.location.href="' . base_url() . '"'
                . '</script>';
            } else {
                echo '<script type="text/javascript">'
                . 'alert("Login done..");'
                . 'document.location.href="' . base_url() . 'member_account"'
                . '</script>';
            }
        } else {
            echo '<script type="text/javascript">'
            . 'alert("Emails or Password invalid");'
            . 'document.location.href="' . base_url() . 'sign"'
            . '</script>';
        }
    }

    function registermember() {
        $this->load->model('modelmember');
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $emails = $_POST['email'];
        $address = $_POST['streetname'] . "|" . $_POST['city'] . "|" . $_POST['province'] . "|" . $_POST['country'];

        $password = $_POST['password'];
        $row = @$this->modelmember->getRowDataMember("WHERE emails='$emails'")->id_member;
        $store = @$this->modelsetting->getdetailsetting(1);
        if (empty($row)) {
            $this->modelmember->insertMember($name, $emails, $phone, $address, $password);
            $xrow = @$this->modelmember->getRowDataMember("WHERE emails='$emails'")->id_member;
            $this->session->set_userdata('idmember', $xrow);
            $subject = "Registration | " . $store->title . ".com";
            $message = '<table width="100%" bgcolor="#f0f2ea" cellpadding="0" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td style="padding:10px 0;">

                <table cellpadding="0" cellspacing="0" width="608" border="0" align="center" style="box-shadow: 0px 0px 15px -7px;">
                    <tbody>
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tbody>

                                        <tr>
                                            <td width="8" height="4" colspan="2" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="8" height="4" colspan="2" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                        
                                        <tr>
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td colspan="3" rowspan="3" bgcolor="#FFFFFF" style="padding:0 0 30px;">
											<p style="margin:10 0px 0px; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                                    Thank You for Registering with '.$store->title.'.com 
                                                </p>
                                                <!-- begin content -->
                                                <img src="http://localhost/myweb/themes/shop/virgo/logo.png" width="600" height="250" alt="Billing address" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
                                                
												<p style="margin:0 30px 33px; font-size:12px; line-height:30px; font-weight:bold; color:#484a42;">
                                                    Hi
                                                </p>
												
												<p style="margin:0 30px 33px; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                                    Billing address :
                                                </p>
												<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tbody>
                                                        <tr valign="top">
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                            <td>
                                                                <p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">STREEN NAME : ' . $_POST['streetname'] . '</p>
																<p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">CITY : ' . $_POST['city'] . '</p>
																<p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">PROVINCE : ' . $_POST['province'] . '</p>
																<p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">COUNTRY : ' . $_POST['country'] . '</p> 
																<p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">PHONE : ' . $_POST['phone'] . '</p>
															 
															</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
												<br>
												<br>
												<p style="margin:0 30px 33px; text-align:center; text-transform:uppercase; font-size:24px; line-height:30px; font-weight:bold; color:#484a42;">
                                                    You can use this for login :
                                                </p>
												<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tbody>
                                                        <tr valign="top">
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                            <td>
                                                                <p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">EMAIL : ' . $emails . '</p>
																<p style="margin:0 0 10px; font-size:12px; line-height:18px; color:#333333;">PASSWORD : ' . $password . '</p>
															</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- begin articles -->
                                                
                                                <!-- /end articles -->
                                                <p style="margin:0; border-top:2px solid #000; font-size:5px; line-height:5px; margin:0 30px 29px;">&nbsp;</p>
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tbody>
                                                        <tr valign="top">
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                            <td>
                                                                <p style="margin:0 0 4px; font-weight:bold; color:#333333; font-size:14px; line-height:22px;">DIANA MUSIK</p>
                                                                <p style="margin:0; color:#333333; font-size:11px; line-height:18px;">
																	Jalan Pakuningratan 51 Yogyakarta<br>
                                                                    Website: <a href="http://' . $store->title . '.com" style="color:#6d7e44; text-decoration:none; font-weight:bold;">www.dianamusik.com</a>
                                                                </p>
                                                            </td>
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                            
                                                            <td width="30"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- end content --> 
                                            </td>
                                            <td width="4" height="4"><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td width="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                        
                                        <tr> 
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                 
                                        <tr>
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                            <td width="4" height="4" ><p style="margin:0; font-size:1px; line-height:1px;">&nbsp;</p></td>
                                        </tr>
                                    </tbody>
                                </table>
                    
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            </td>
        </tr>
    </tbody>
</table>';
            $this->sendTomail($message, $emails, $subject);

            echo '<script type="text/javascript">'
            . 'alert("Register is Done..,Please Chek your mail");'
            . 'document.location.href="' . base_url() . 'member_account"'
            . '</script>';
        }else {
            echo '<script type="text/javascript">'
            . 'alert("Your Mail Has been registered");'
            . 'document.location.href="' . base_url() . 'sign"'
            . '</script>';
        }
    }
     function sendTomail($message, $emails, $subject) {
        $this->load->model('modelsetting');

        $row = $this->modelsetting->getdetailsetting(1);

        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from(@$row->emails, @$row->title);
        $this->email->to($emails);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

}

?>
