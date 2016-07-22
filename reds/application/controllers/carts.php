<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carts
 *
 * @author user
 */
class carts extends CI_Controller {

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

//                $data['qty'] = 0;
            $this->load->model("modelmember");
            $this->load->model("modelorder");
            $this->load->helper('form');
            $load = $this->modelsetting->getdetailsetting(1)->theme . '/';
            $data['title'] = $this->modelsetting->getdetailsetting(1)->title . ' | Shopping Cart';
            $data['metaDescription'] = $this->modelsetting->getdetailsetting(1)->title . "| Shopping Cart";
            $data['metaKeyword'] = $this->modelsetting->getdetailsetting(1)->title . "| Shopping Cart";
            $data['load'] = $load;
            $data['idmember'] = $idmember;
             //        init location folder themes
            $themes = 'themes/';
//        set path directory themes
            $data['path'] = base_url() . '' . $themes . '' . $load;
            $this->load->view($load . 'header', $data);
            $this->load->view($load . 'cart', $data);
            $this->load->view($load . 'footer');
        } else {
            redirect(base_url() . 'sign');
        }
    }

    function updateCart() {
        $id = $_POST['id'];
        $qty = $_POST['count'];
        $data = array(
            'rowid' => $id,
            'qty' => $qty
        );
        $this->cart->update($data);
        $this->json_data['data'] = $this->cart->total_items();
        echo json_encode($this->json_data);
    }

    function removeCart() {
        $id = $_POST['id'];

        $data = array(
            'rowid' => $id,
            'qty' => 0
        );
        $this->cart->update($data);
        $content = "";
        $totalPrice = 0;
        if ($this->cart->contents() != null) {
            $content.='<table class="table">
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
                $content.='<tr>
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
                    $content.='<span class="input-group-btn" id="minus_' . $row['rowid'] . '"><button class="btn btn-default" type="button" id="minquantity_' . $row['rowid'] . '" onclick="minquantity(1, \'' . $row["rowid"] . '\')"><i class="glyphicon glyphicon-minus"></i></button></span>';
                }

                $content.='<input type="text" class="form-control" value="' . $row['qty'] . '" id="quantity_' . $row['rowid'] . '" placeholder="Quantity" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="addquantity" onclick="addquantity(' . $stock . ', \'' . $row["rowid"] . '\');"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </span>

                                                </div>
                                            </div>
                                        </td> 
                                        <td><div class="title-wrap" style="text-align: center;">' . number_format(($row['price'] * $row['qty'])) . '</div></td> 
                                        <td><button class="btn btn-default custom-button" style="margin-left: 25px;" onclick="removeCart(\'' . $row["rowid"] . '\');"><i class="glyphicon glyphicon-remove"></i></button></td>
                                    </tr>';
                $totalPrice = $totalPrice + ($row['price'] * $row['qty']);
            }
            $content.= '</tbody>
                        <tfoot>

                            <tr>
                                <th width="20%" style="text-align: center;" colspan="3"><div class="title-wrap">Total Order</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;" >Rp. <span id="total-price">'. number_format($totalPrice).'</span></div></th>
                        </tr>

                        </tfoot>
                    </table>';
        } else {
            $content.='<table class="table">
                        <thead>
                            <tr>
                                <th width="20%"><div class="title-wrap" style="text-align: center;">Product Name</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;">Price</div></th>
                        <th width="5%"><div class="title-wrap" style="text-align: center;">Quantity</div></th>
                        <th width="10%"><div class="title-wrap" style="text-align: center;">Subtotal Price</div></th>
                        <th width="5%"><div class="title-wrap" style="text-align: center;">Delete Cart</div></th>
                        </tr>
                        </thead>
                        <tbody><tr><td colspan="4"><div class="title-wrap" style="text-align: center;">No Cart</div></td></tr>
                        </tbody>
                        <tfoot>

                            <tr>
                                <th width="20%" style="text-align: center;" colspan="3"><div class="title-wrap">Total Order</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;" >Rp. <span id="total-price">' . number_format($totalPrice) . '</span></div></th>
                        </tr>

                        </tfoot>
                    </table>';
        }
        $this->json_data['table'] = $content;
        $this->json_data['data'] = $this->cart->total_items();
        echo json_encode($this->json_data);
    }

}

?>
