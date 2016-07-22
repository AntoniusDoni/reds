<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jQuery/jquery.steps.css">
<script src="<?php echo base_url(); ?>assets/jQuery/jquery.steps.js"></script>
<script src="<?php echo base_url(); ?>assets/jQuery/jquery.validate.js"></script>

<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Checkout</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id='main'>
    <div id="after-loading-success-message"></div>
    <div class="container">
        <div class="wizard-box">
            <div class="wizard-box-body">
                <div class="text-center">
                    <h4><span class="glyphicon glyphicon-check"></span> Checkout</h4>
                </div>
                <form id="example-advanced-form" action="#">
                    <h3>Billing/Shipping</h3>
                    <section>
                        <div class="form-group has-feedback">
                            <input type="radio" name="usemember" value="1" id="usemember" onclick="getDataMember('1');" style="float:left;margin-right: 10px;"/> <label style="float: left;margin-right: 20px;">User member Data</label>
                            <input type="radio" name="usemember" value="0" id="usemember_n" onclick="getDataMember('0');" checked="checked" style="float:left;margin-right: 10px;"/> <label style="float: left;">New Data</label>
                        </div>

                        <div class="form-group has-feedback">
                            <input type="text" name="names" id="names" class="form-control" placeholder="Nama" class="required" required/>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name=phone id="phone" class="form-control" placeholder="Phone" class="required" required/>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="hidden" name="province_id" id="province_id" value=""/>
                            <input type="text" name="province" id="province" class="form-control" placeholder="Province" class="required" required/>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="hidden" name="city_id" id="city_id" value=""/>
                            <input type="text" name="city" id="city" readonly="readonly" class="form-control" placeholder="City" class="required" required />
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="address" id="address" readonly="readonly" class="form-control" placeholder="Address" class="required" required/>
                        </div>

                    </section>
                    <h3>Payment Method</h3>
                    <section>

                        <?php
                        $queryBank = $this->modelsetting->getListBank("");
                        $no = 1;
                        foreach ($queryBank->result()as $databank) {
                            if ($no == 1) {
                                $checked = 'checked="checked"';
                            } else {
                                $checked = '';
                            }
                            ?>
                            <div class="form-group has-feedback" style="background:#ccc;padding: 7px">
                                <input <?= $checked; ?> type="radio" name="bank_account" value="<?= $databank->bank_name; ?>" id="bank_account" style="float:left;margin-right: 10px;"/> 
                                <label style="float: left;margin-right: 20px;width:5%;"><?= $databank->bank_name; ?></label>
                                <label style="float: left;margin-right: 20px;;width:9%;"><?= $databank->bank_account; ?></label>
                                <label style="margin-right: 20px;;width:11%;"><?= $databank->bank_owner; ?></label>
                            </div>
                            <?php
                            $no++;
                        }
                        ?>
                        <div >
                            <h4>Shipping Method</h4>
                            <div class="form-group has-feedback">
                                <input type="hidden" name="etd" id="etd"/>
                                <input type="hidden" name="shippingCost" id="shippingCost"/>
                                <input type="hidden" name="shippingServices" id="shippingServices"/>
                                <select id="type-shipping" name="type-shipping" class="form-control" onchange="getShippingPrice()">
                                    <option value="jne">JNE</option>
                                    <option value="pos">Pos</option>
                                </select>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Services<td>
                                        <td>Cost<td>
                                        <td>Estimate Date<td>
                                        <td>&nbsp<td>
                                    </tr>
                                </thead>
                                <tbody id="shipping-content">

                                </tbody>
                            </table>
                        </div>
                    </section>
                    <h3>Order Review</h3>
                    <section>
                        <div id="data_orders_customer"></div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="20%"><div class="title-wrap">Product Name</div></th>
                            <th width="15%"><div class="title-wrap">Price</div></th>
                            <th width="5%"><div class="title-wrap">Quantity</div></th>
                            <th width="10%"><div class="title-wrap">Subtotal Price</div></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalPrice = 0;
                                $shipping = 0;
                                foreach ($this->cart->contents() AS $row) {
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="title-wrap" style="text-align: center;"><?= $row['name']; ?>
                                                </br>                                               
                                                <span class="detail-line">
                                                    <strong>Size: </strong> <?php echo $row['options']['Size']; ?>
                                                </span>

                                            </div>
                                        </td>
                                        <td><div class="title-wrap" style="text-align: center;"><?= number_format($row['price']); ?></div></td> 
                                        <td><div class="title-wrap" style="text-align: center;"><?= number_format($row['qty']); ?></div></td> 
                                        <td><div class="title-wrap" style="text-align: center;"><?= number_format(($row['price'] * $row['qty'])); ?></div></td> 
                                    </tr>
                                    <?php
                                    $totalPrice = $totalPrice + ($row['price'] * $row['qty']);
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="20%" style="text-align: center;" colspan="3"><div class="title-wrap">Shipping <b id="Cost-content"></b></div></th>
                            <th width="15%"><div class="title-wrap" style="text-align: center;" id="cost-shipping">Rp. <?= number_format($shipping); ?></div></th>
                            </tr>
                            <tr>
                                <th width="20%" style="text-align: center;" colspan="3"><div class="title-wrap">Total Order</div></th>
                            <th width="15%"><div class="title-wrap" style="text-align: center;" >Rp. <span id="total-price"><?= number_format($totalPrice); ?></span></div></th>
                            </tr>
                            <tr>
                                <th width="20%" style="text-align: center;" colspan="4">
                            <div class="title-wrap" id="tranfer_member">

                            </div>
                            </th>

                            </tr>
                            </tfoot>
                        </table>
                    </section>
                    <h3>Order Complete</h3>
                    <section>
                        <p>Order Number : <b id="order-code"></b></p>
                        <p>Your Order will be canceled automatical. if you are not Transferred your payment for 24 hours from now.</p>
                        <p>Confirm your payment on the payment confirmation page. Click button below for confirm your payment.</p>
                    </section>
                </form>
            </div>
        </div>
    </div>
</section>
<script>

                                var form = $("#example-advanced-form").show();

                                form.steps({
                                    headerTag: "h3",
                                    bodyTag: "section",
                                    transitionEffect: "slideLeft",
                                    autoFocus: true,
                                    startIndex: 0,
                                    onFinished: function(event, currentIndex) {
//                                        saveData();
                                        document.location.href = '<?= base_url(); ?>';
                                    },
                                    onStepChanging: function(event, currentIndex, newIndex)
                                    {
                                        // Allways allow previous action even if the current form is not valid!
                                        if (currentIndex > newIndex)
                                        {
                                            return true;
                                        }
                                        if (newIndex == 1) {
                                            getShippingPrice();
                                        }
                                        if (newIndex == 2) {

                                            getDataOrder();
                                        }
                                        if (newIndex == 3) {
                                            saveData();
                                        }
                                        // Needed in some cases if the user went back (clean up)
                                        if (currentIndex < newIndex)
                                        {
                                            // To remove error styles
                                            form.find(".body:eq(" + newIndex + ") label.error").remove();
                                            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                                        }
                                        form.validate().settings.ignore = ":disabled,:hidden";
                                        return form.valid();
                                    },
                                    onFinishing: function(event, currentIndex)
                                    {
                                        form.validate().settings.ignore = ":disabled";
                                        return form.valid();
                                    }
                                }).validate({
                                    /*errorPlacement: function errorPlacement(error, element) { element.before(error); }*/
                                });
                                function saveData() {
                                    $.ajax({
                                        type: "POST",
                                        url: '<?= base_url(); ?>checkout/checkoutOrder',
                                        data: "totalPrice=<?= $totalPrice; ?>" + '&names=' + $("#names").val() + "&phone=" + $("#phone").val() + "&address=" + $("#address").val() + "&province=" + $("#province").val() + "&city=" + $("#city").val() + "&type=" + $("#type-shipping").val() + "&etd=" + $("#etd").val() + "&shippingCost=" + $("#shippingCost").val() + "&shippingServices=" + $("#shippingServices").val(),
                                       
                                    }).done(function(data) {
                                        
                                        $("#order-code").html(data);
                                    });
                                }
                                function getDataMember(id) {

                                    if (id == '1') {
                                        $.ajax({
                                            type: "POST",
                                            url: '<?= base_url(); ?>checkout/getDataMember',
                                            data: 'idmember=<?= $idmember; ?>',
                                            dataType: "json"
                                        }).done(function(data) {
                                            $("#names").val(data.name_member);
                                            $("#phone").val(data.phone_member);
                                            $("#address").val(data.address_member);
                                            $("#province").val(data.province_member);
                                            $("#city").val(data.city);
                                            getCity_id();
                                            getProvince_id();
                                        });
                                    } else {
                                        $("#names").val("");
                                        $("#phone").val("");
                                        $("#address").val("");
                                    }
                                }
                                function getProvince_id() {
                                    $.ajax({
                                        type: "POST",
                                        url: '<?= base_url(); ?>checkout/getProvince',
                                        data: 'province=' + $("#province").val(),
                                        dataType: "json"
                                    }).done(function(data) {

                                        $("#province_id").val(data.data);
                                    });
                                }
                                function getCity_id() {
                                    $.ajax({
                                        type: "POST",
                                        url: '<?= base_url(); ?>checkout/getCity',
                                        data: 'city=' + $("#city").val() + "&province_id=" + $("#province_id").val(),
                                        dataType: "json"
                                    }).done(function(data) {

                                        $("#city_id").val(data.data);
                                    });
                                }
                                function getShippingPrice() {
                                    $.ajax({
                                        type: "POST",
                                        url: '<?= base_url(); ?>checkout/getShipping',
                                        data: 'city_id=' + $("#city_id").val() + "&quantity=<?= $qty; ?>" + "&type=" + $("#type-shipping").val(),
//                                            dataType: "json"
                                    }).done(function(data) {
                                        $("#shipping-content").html(data);

                                    });
                                }
                                function getDataOrder() {
                                    $("#data_orders_customer").html("<p>" + $("#names").val() + "</p><p>" + $("#address").val() + "</p><p> " + $("#province").val() + ",  " + $("#city").val() + "</p><p> Phone: " + $("#phone").val() + "</p>");
                                    $("#tranfer_member").html("Payment Method Bank Transfer " + $("input[name=bank_account]:checked").val());
                                }
                                function getDataShipping(services, cost, estimeate) {
                                    totalPrice = '<?= number_format($totalPrice); ?>';
                                    shippingPrice = parseInt(cost);
                                    $("#Cost-content").html(' ( ' + services + ') , Estimate Date ' + estimeate);
                                    $("#cost-shipping").html("Rp. " + shippingPrice.toLocaleString('de-DE'));
                                    sumPrice = parseInt(totalPrice.replace(",", "")) + shippingPrice;
                                    $("#total-price").html(sumPrice.toLocaleString('de-DE'));
                                    $("#etd").val(estimeate);
                                    $("#shippingCost").val(cost);
                                    $("#shippingServices").val(services);

                                    $("#after-loading-success-message").css('display', 'block');
                                    $("#after-loading-success-message").html('<div class ="background-overlay"></div>\n\
        <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-cart" style="position: relative; top: 45%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;">\n\
        <span>\n\
                                You Choosed Shipping With ' + $("#type-shipping").val() + ' ' + services + ' </span></button>');
                                    $("#continue_shopping").click(function() {
                                        $('#after-loading-success-message').fadeOut();
                                    });

                                }
                                function onlynumber(id) {
                                    $(document).ready(function() {
                                        $("#" + id).keydown(function(event) {
                                            // Allow only backspace and delete
                                            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
                                                // let it happen, don't do anything
                                            }
                                            else {
                                                // Ensure that it is a number and stop the keypress
                                                if (event.keyCode < 48 || event.keyCode > 57) {

                                                    if (event.keyCode == 190) {

                                                    } else {
                                                        event.preventDefault();
                                                    }
                                                }

                                            }

                                        });
                                    });
                                }
                                function DataProvince() {
                                    $(document).ready(function() {
                                        $('#province').autocomplete({
                                            multiple: true,
                                            minLength: 2,
                                            multipleSeparator: ",",
                                            source: function(request, response) {
                                                $.ajax({
                                                    url: '<?= base_url(); ?>checkout/getProvinces',
                                                    data: "province=" + $("#province").val(),
                                                    dataType: "json",
                                                    cache: false,
                                                    type: "POST",
                                                    success: function(json) {

                                                        response(json.data.split(","));

                                                    },
                                                    error: function(xmlHttpRequest, textStatus, errorThrown) {
                                                        start = xmlHttpRequest.responseText.search("<title>") + 7;
                                                        end = xmlHttpRequest.responseText.search("</title>");
                                                        errorMsg = " ON CARI " + xmlHttpRequest.responseText;
                                                        if (start > 0 && end > 0)
                                                            alert("Undifine " + errorMsg + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                                                        else
                                                            alert("Error  " + errorMsg);
                                                    }
                                                });
                                            },
                                            width: 100,
                                            max: 10,
                                            select: function(event, ui) {
                                                $("#city").attr('readonly', false);
                                                $("#address").attr('readonly', false);
                                                getProvince_id();
                                                DataCity();
                                            },
                                            change: function(event, ui) {
                                            }
                                        });
                                    });
                                }
                                function DataCity() {
                                    $(document).ready(function() {
                                        $('#city').autocomplete({
                                            multiple: true,
                                            minLength: 2,
                                            multipleSeparator: ",",
                                            source: function(request, response) {
                                                $.ajax({
                                                    url: '<?= base_url(); ?>checkout/getCitys',
                                                    data: "city=" + $("#city").val() + "&province_id=" + $("#province_id").val(),
                                                    dataType: "json",
                                                    cache: false,
                                                    type: "POST",
                                                    success: function(json) {

                                                        response(json.data.split(","));

                                                    },
                                                    error: function(xmlHttpRequest, textStatus, errorThrown) {
                                                        start = xmlHttpRequest.responseText.search("<title>") + 7;
                                                        end = xmlHttpRequest.responseText.search("</title>");
                                                        errorMsg = " ON CARI " + xmlHttpRequest.responseText;
                                                        if (start > 0 && end > 0)
                                                            alert("Undifine " + errorMsg + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                                                        else
                                                            alert("Error  " + errorMsg);
                                                    }
                                                });
                                            },
                                            width: 100,
                                            max: 10,
                                            select: function(event, ui) {
                                                getCity_id();
                                            },
                                            change: function(event, ui) {
                                            }
                                        });
                                    });
                                }
                                DataCity();
                                DataProvince();
                                onlynumber('phone');
</script>