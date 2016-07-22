<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of checkout
 *
 * @author user
 */
class checkout extends CI_Controller {

    //put your code here
    function __construct() {

        parent::__construct();

        $this->load->model('modelcategory');
        $this->load->model("modelproduct");

        $this->load->library('session');
        $this->load->library('cart');
    }

    public function index() {
        $idmember = $this->session->userdata('idmember');
        if (!empty($idmember)) {
            if ($this->cart->contents() != null) {
                $qty = 0;
                foreach ($this->cart->contents() AS $row) {
                    $qty = $qty + $row['qty'];
                }
                $data['qty'] = $qty;
                $this->load->model("modelmember");
                $this->load->model("modelorder");
                $this->load->helper('form');
                $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
                $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | Checkout';
                $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->title . "| Checkout";
                $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->title . "| Checkout";
                $data['load'] = $load;
                $data['idmember'] = $idmember;
                //        init location folder themes
                $themes = 'themes/';
//        set path directory themes
                $data['path'] = base_url() . '' . $themes . '' . $load;
                $this->load->view($load . 'header', $data);
                $this->load->view($load . 'checkout', $data);
                $this->load->view($load . 'footer');
            } else {
                redirect(base_url() . '');
            }
        } else {
            redirect(base_url() . 'sign');
        }
    }

    function getDataMember() {
        $this->load->model('modelmember');
        $idmember = $_POST['idmember'];
        $queryMember = $this->modelmember->getRowDataMember("WHERE id_member='$idmember'");
        $data['name_member'] = $queryMember->name;
        $data['phone_member'] = $queryMember->phone;
        $dataAddres = explode('|', $queryMember->address);
        $data['address_member'] = $dataAddres[0];
        $data['province_member'] = $dataAddres[2];
        $data['city'] = $dataAddres[1];
        echo json_encode($data);
    }

    function getShipping() {
        $key = '9905aec997a5f003c40b0ce072537eb2';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=501&destination=" . $_POST['city_id'] . "&weight=" . $_POST['quantity'] . "&courier=" . $_POST['type'],
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
//            echo "cURL Error #:" . $err;
        } else {

            $object = json_decode($response, true);

            $countArrayCost = count($object['rajaongkir']['results'][0]['costs']);

            for ($i = 0; $i < $countArrayCost; $i++) {
                $des = $object['rajaongkir']['results'][0]['costs'][$i]['description'];
                $services = $object['rajaongkir']['results'][0]['costs'][$i]['service'];
                $cost = $object['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['value'];
                $etd = $object['rajaongkir']['results'][0]['costs'][$i]['cost'][0]['etd'];
                if ($_POST['type'] != 'jne') {
                    $calculateCost = $cost;
                } else {
                    $calculateCost = $cost * $_POST['quantity'];
                }
                echo '<tr>
                     <td>' . $des . ' (' . $services . ')<td>
                     <td>Rp. ' . number_format($calculateCost) . '<td>
                     <td>' . $etd . ' <td>
                     <td>
                     <div class="btn btn-primary" onclick="getDataShipping(\'' . $services . '\',\'' . $calculateCost . '\',\'' . $etd . '\');">Choose</div><td>
                     </tr>';
            }
        }
    }

    function getProvince() {
        $curl = curl_init();
        $key = '9905aec997a5f003c40b0ce072537eb2';
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $key"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
//            echo "cURL Error #:" . $err;
            $data = 0;
        } else {

            $object = json_decode($response, true);
            $countarray = count($object['rajaongkir']['results']);

            for ($i = 0; $i < $countarray; $i++) {
                if ($object['rajaongkir']['results'][$i]['province'] == $_POST['province']) {
                    $data = @$object['rajaongkir']['results'][$i]['province_id'];
                }
            }
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }

    function getProvinces() {
        $curl = curl_init();
        $data = '';
        $key = '9905aec997a5f003c40b0ce072537eb2';
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $key"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
//            echo "cURL Error #:" . $err;
            $data = 0;
        } else {

            $object = json_decode($response, true);
            $countarray = count($object['rajaongkir']['results']);

            for ($i = 0; $i < $countarray; $i++) {

                $data.= @$object['rajaongkir']['results'][$i]['province'] . ',';
            }
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }

    function getCity() {
        $curl = curl_init();
        $key = '9905aec997a5f003c40b0ce072537eb2';
//        $data = '';
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/city?id=&province=" . $_POST['province_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $key"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
//            echo "cURL Error #:" . $err;
            $data = 0;
        } else {

            $object = json_decode($response, true);
            $countarray = count($object['rajaongkir']['results']);

            for ($i = 0; $i < $countarray; $i++) {

                if ($object['rajaongkir']['results'][$i]['city_name'] == $_POST['city']) {
                    $data = @$object['rajaongkir']['results'][$i]['city_id'];
                }
            }
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }

    function getCitys() {
        $curl = curl_init();
        $key = '9905aec997a5f003c40b0ce072537eb2';
        $data = '';
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/city?id=&province=" . $_POST['province_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $key"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
//            echo "cURL Error #:" . $err;
            $data = 0;
        } else {

            $object = json_decode($response, true);
            $countarray = count($object['rajaongkir']['results']);

            for ($i = 0; $i < $countarray; $i++) {


                $data.= @$object['rajaongkir']['results'][$i]['city_name'] . ',';
            }
        }
        $this->json_data['data'] = $data;
        echo json_encode($this->json_data);
    }

    function checkoutOrder() {

        $name_order = $_POST['names'];
        $phone_order = $_POST['phone'];
        $address_order = $_POST['address'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $type = $_POST['type'];
        $estimate_deliver = $_POST['etd'];
        $shipping_price = $_POST['shippingCost'];
        $shippingServices = $_POST['shippingServices'];
        $this->load->model('modelorder');
        $this->load->model('modelproduct');
        $this->load->model('modelmember');
        $this->load->library('session');
        $this->load->library('cart');
        $id_member = $this->session->userdata('idmember');
        $order_random = $this->modelorder->getrandom();
        $totalPrice = $_POST['totalPrice'];
        $total_price = $totalPrice + $shipping_price;
        $notaterakhir = @$this->modelorder->getRowDataOrder("order by code_order DESC LIMIT 1")->code_order;
        date_default_timezone_set('Asia/Jakarta');
        $timenow = date('r');
        $kdtahun = date('Ym', strtotime($timenow));
        $code_order = '';
        if (empty($notaterakhir))
            $code_order = 'Eght/' . $kdtahun . '/' . '0001';
        $numeric = (int) substr(@$notaterakhir, -4);
        if ($notaterakhir)
            $code_order = 'Eght/' . $kdtahun . '/' . $this->zerofill($numeric + 1, '4');

        if ($this->cart->contents() != null) {
            $this->modelorder->insertOrder($code_order, $id_member, $estimate_deliver, $shipping_price, $total_price, $name_order, $address_order, $phone_order, 'Pending', $order_random, $type . ' (' . $shippingServices . ')');
            $id_order = $this->modelorder->getRowDataOrder("WHERE order_random='$order_random'")->id_order;
            foreach ($this->cart->contents() AS $row) {
                $this->modelorder->inserOrderDetail($id_order, $row['id'], $row['qty'], $row['price']);
                $getStokProduct = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product_detail='" . $row['id'] . "'")->stok;
                $lastStok = $getStokProduct + $row['qty'];
                $this->modelproduct->updateProduct_detailStatement("WHERE id_product_detail='" . $row['id'] . "'", "stok='$lastStok'");
            }
            $emails = @$this->modelmember->getRowDataMember("WHERE id_member='$id_member'")->emails;
            $subject = "Invoice Order | " . $store->title . ".com";
            $message = '<table width="100%" bgcolor="#f0f2ea" cellpadding="0" cellspacing="0" border="0">
                       <tbody>
                       <tr>
            <td style="padding:10px 0;">
            <table cellpadding="0" cellspacing="0" width="608" border="0" align="center" style="box-shadow: 0px 0px 15px -7px;">
            <tbody>
            <tr>
                            <td>
                            </tr>
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
                                             Thank You for your Order in ' . $store->title . '.com 
                                            </p>
                                            <!-- begin content -->
                                                <img src="http://localhost/myweb/themes/shop/virgo/logo.png" width="600" height="250" alt="Billing address" style="display:block; border:0; margin:0 0 44px; background:#eeeeee;">
                                                <p style="margin:0 30px 33px; font-size:12px; line-height:30px; font-weight:bold; color:#484a42;">Your order</p>
                                               <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                               <thead>
                            <tr>
                                <th width="20%"><div class="title-wrap" style="text-align: center;">Product Name</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;">Price</div></th>
                        <th width="5%"><div class="title-wrap" style="text-align: center;">Quantity</div></th>
                        <th width="10%"><div class="title-wrap" style="text-align: center;">Subtotal Price</div></th>
                        <th width="5%"><div class="title-wrap" style="text-align: center;">Delete Cart</div></th>
                        </tr>
                        </thead><tbody>';
            foreach ($this->cart->contents() AS $row) {
                $stock = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product_detail='" . $row['id'] . "'")->stok;

                $message.=' <tr>
                                        <td>
                                            <div class="cart-product">
                                                <figure>
                                                    <img src="' . @$this->modelproduct->getRowDataProduct("WHERE id_product='" . $row['options']['idproduct'] . "'")->main_images . '" alt="' . $row['name'] . '" />
                                                </figure>
                                                <div class="text">
                                                    <h2><a href="' . base_url() . 'detailproduct/' . @$this->modelproduct->getRowDataProduct("WHERE id_product='" . $row['options']['idproduct'] . "'")->url . '">' . $row['name'] . '</a></h2>
                                                    <div class="details">
                                                        <span class="detail-line">
                                                            <strong>Size: </strong>' . $row['options']['Size'] . '
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="title-wrap" style="text-align: center;">' . number_format($row['price']) . '</div></td> 
                                        <td>
                                            <div class="quantity">
                                                <div class="input-group">';
                if ($row['qty'] > 1) {
                    $message.='<span class="input-group-btn" "><button class="btn btn-default" type="button" ><i class="glyphicon glyphicon-minus"></i></button></span>';
                }

                $message.='<input type="text" class="form-control" value="' . $row['qty'] . '"  placeholder="Quantity" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="addquantity" ><i class="glyphicon glyphicon-plus"></i></button>
                                                    </span>

                                                </div>
                                            </div>
                                        </td> 
                                        <td><div class="title-wrap" style="text-align: center;">' . number_format(($row['price'] * $row['qty'])) . '</div></td> 
                                        <td><button class="btn btn-default custom-button" style="margin-left: 25px;" ><i class="glyphicon glyphicon-remove"></i></button></td>
                                    </tr>';

                $totalPrice = $totalPrice + ($row['price'] * $row['qty']);
            }

            $message.=' </tbody>
                        <tfoot>

                            <tr>
                                <th width="20%" style="text-align: center;" colspan="3"><div class="title-wrap">Total Order</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;" >Rp. <span id="total-price">' . number_format($totalPrice) . '</span></div></th>
                        </tr>

                        </tfoot>
                    </table>
                                            </td>
                                            </tr>
                             </tbody>
                             </table>
                            </td>
            </tbody>
            </table>
            </td>
            </tr>
                        </tbody>
                      </tabel>';
            $this->cart->destroy();
            $this->sendTomailAdmin($message, $emails, $subject);
            $this->senTomailMember($message, $emails, $subject);
            echo $code_order;
        } else {
            echo 'forbiden';
        }
    }

    function sendTomailAdmin($message, $emails, $subject) {
        $this->load->model('modelsetting');

        $row = $this->modelsetting->getdetailsetting(1);

        $this->load->library('email');
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from($emails, @$row->title);
        $this->email->to(@$row->emails);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

    function senTomailMember($message, $emails, $subject) {
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

    function zerofill($num, $zerofill) {
        while (strlen($num) < $zerofill) {
            $num = 0 . $num;
        }
        return $num;
    }

}

?>
