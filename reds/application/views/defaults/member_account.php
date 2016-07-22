
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/jQuery/dateTimePicker/jquery.datetimepicker.min.css"/>
<script src="<?php echo base_url(); ?>assets/jQuery/dateTimePicker/jquery.datetimepicker.full.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">My Account</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id='main'>
    <div id="after-loading-success-message"></div>
    <div class="container">
        <div class="col-sm-4">
            <div class="section-title"><h3 class="text-center">My Account</h3></div>
            <div class="widget-content">
                <div class="accordion">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" onclick="getmyAccount('account')">
                                        My Account
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" onclick="getmyAccount('order_history')">
                                        Order History
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" onclick="getmyAccount('confirmation_payment')">
                                        Payment Confirmation
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" onclick="getmyAccount('return_order')">
                                        Return
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" onclick="getmyAccount('logout')">
                                        Logout
                                    </a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div id="account" style="display: none;">
                <div class="section-title"><h3 class="text-center">Edit Account</h3></div>
                <div  class="contact-form ">
                    <input type="hidden" id="id_member" name="id_member" value="<?= @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->id_member; ?>"/>
                    <?php
                    $Complateaddress = @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->address;
                    $dataAddress = explode("|", $Complateaddress);
                    ?>
                    <div class="form-group">
                        <input class="form-control" required type="email"  name="email" id="email" placeholder="Email" value="<?= @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->emails; ?>" autofocus/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="password"  name="password" id="password" value="<?= @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->password; ?>" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="password"  name="confirm_password" id="confirm_password" value="<?= @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->password; ?>" placeholder="Confirm Password"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text"  name="name" id="name" placeholder="Complete Name" value="<?= @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->name; ?>"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Street name" name="streetnames" id="streetnames"  value="<?= @$dataAddress[0] ?>" />
                    </div>
                     <div class="form-group">
                        <input type="hidden" name="province_id" id="province_id" value=""/>
                        <input class="form-control" required type="text"  name="province" id="province" placeholder="Province" value="<?= @$dataAddress[2] ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="city_id" id="city_id" value=""/>
                        <input class="form-control" required type="text"  name="city" id="city" placeholder="City" value="<?= @$dataAddress[1] ?>"/>
                    </div>
                   
                    <div class="form-group">
                        <input class="form-control" class="span3" name="country" id="country" type="text" placeholder="country"  value="<?= @$dataAddress[3] ?>" required>
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text"  name="phone" id="phone" placeholder="Phone" value="<?= @$this->modelmember->getRowDataMember("WHERE id_member='$idmember'")->phone; ?>" required>
                    </div>
                    <div class="text-center">
                        <button class="custom-button btn-sm " onclick="editAccount();" id="loginButton"  style="width: 90%;">Update Account</button>
                    </div>
                </div>
            </div>
            <div id="order_history" style="display: none;">
                <div class="section-title"><h3 class="text-center">Order History</h3></div>
                <div class="table-responsive shopping-cart">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="30%"><div class="title-wrap">Order Code</div></th>
                        <th width="15%"><div class="title-wrap">Order Date</div></th>
                        <th width="15%"><div class="title-wrap">Total Price</div></th>
                        <th width="5%"><div class="title-wrap">Shipping Code </div></th>
                        <th width="15%"><div class="title-wrap">Status</div></th>

                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $queryHistoryOrder = $this->modelorder->getListOrderCustome(" 
                                  INNER JOIN order_detail  ON order_detail.id_order=order_detail.id_order
INNER JOIN product_detail ON product_detail.id_product_detail=order_detail.id_detail_product
INNER JOIN product ON product_detail.id_product=product.id_product
                                    WHERE id_member='$idmember' GROUP BY code_order ORDER BY dates_order DESC", " orders.id_order,code_order,DATE_FORMAT(dates_order,'%d/%M/%y') as dates_order,total_price,shiping_code,status_order ");

                            $totalPrice = 0;
                            foreach ($queryHistoryOrder->result() as $rowOrder) {
                                ?>
                                <tr> 
                                    <td width="30%"><div class="title-wrap"><?= $rowOrder->code_order; ?></div></td>
                                    <td width="15%"><div class="title-wrap"><?= $rowOrder->dates_order; ?></div></td>
                                    <td width="15%"><div class="title-wrap">Rp. <?= number_format($rowOrder->total_price); ?></div></td>
                                    <td width="5%"><div class="title-wrap"><?= $rowOrder->shiping_code; ?></div></td>
                                    <td width="15%"><div class="title-wrap"><?= $rowOrder->status_order; ?></div></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
            <div id="confirmation_payment" style="display: none;">
                <div class="section-title"><h3 class="text-center">Payment Confirmation</h3></div>
                <div  class="contact-form ">
                    <div class="form-group col-sm-4">
                        <input class="form-control" required type="text"  name="order_code" id="order_code" placeholder="Order Code" value="" autofocus/>
                    </div>
                    <div class="form-group col-sm-4">
                        <select class="form-control" name="member_bank" id="member_bank">
                            <option value="0">Select Bank</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <input class="form-control" required type="text"  name="member_account_bank" id="member_account_bank" placeholder="Your Account Code" value="" autofocus/>
                    </div>
                    <div class="form-group col-sm-6">
                        <?= form_dropdown('id_bank', $this->modelsetting->getArrayBank(), '', 'id="id_bank" class="form-control" ') ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <input class="form-control" required type="text"  name="total_price" id="total_price" placeholder="Total Payment" value="" autofocus/>
                    </div>
                    <div class="form-group col-sm-6">
                        <input class="form-control" required type="text"  name="transfer_date" id="transfer_date" placeholder="Date of Transfer" value="" autofocus/>
                    </div>
                    <div class="form-group col-sm-6">
                        <input  required type="file"  required name="images_bank" id="images_bank" placeholder="Proove od Transfer" value="" autofocus/>
                    </div>
                    <div class="form-group ">
                        <textarea class="form-control" name="note" id="note" placeholder="Note"></textarea>
                    </div>
                    <div class="form-group ">
                        <input class="form-control btn btn-primary" type="submit" name="SendPay" id="SendPay" value="Confirmation Payment" onclick="confirmation_pay()" />
                    </div>
                </div>

            </div>
            <div id="return_order" style="display: none;">
                <div class="section-title"><h3 class="text-center">RETURN</h3>
                    <p style="text-align: center;">Product that are purchased can be return with a maximum period of 2 working day after recieving the product.</p> <p style="text-align: center;">Please read the <a href="#">Term of Services</a> for more informations.</p>
                    <div class="separator middle"></div>
                    <div  class="contact-form ">
                        <div class="form-group col-sm-6">
                            <input class="form-control" required type="text"  name="order_code_return" id="order_code_return" placeholder="Order Code" value="" autofocus/>
                        </div>
                        <div class="form-group col-sm-6">
                            <input  required type="file"  required name="images_bank_return" id="images_bank_return" placeholder="Proove od Transfer" value="" autofocus/>
                        </div>
                        <div class="form-group ">
                            <textarea class="form-control" name="note_return" id="note_return" placeholder="Note"></textarea>
                        </div>
                        <div class="form-group ">
                            <input class="form-control btn btn-primary" type="submit" name="sendReturn" id="SendPay" value="Submit Return" onclick="sendReturn()" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
                                        function getmyAccount(id_div) {
                                            $("#account").css('display', 'none').fadeOut(25000);
                                            $("#order_history").css('display', 'none').fadeOut(25000);
                                            $("#confirmation_payment").css('display', 'none').fadeOut(25000);
                                            $("#return_order").css('display', 'none').fadeOut(25000);
                                            if (id_div == 'logout') {
                                                document.location.href = "<?= base_url(); ?>home/logout";
                                            } else {

                                                $("#" + id_div).css('display', 'block').fadeIn(20000);



                                            }
                                        }
                                        getmyAccount("account");
                                        function editAccount() {
                                            $(document).ready(function() {
                                                $.ajax({
                                                    url: "<?php echo base_url(); ?>member_account/editacount/",
                                                    data: "id_member=" + $("#id_member").val() + "&name=" + $("#name").val() + "&phone=" + $("#phone").val() + "&email=" + $("#email").val() + "&password=" + $("#password").val() + "&streetnames=" + $("#streetnames").val() + "&city=" + $("#city").val() + "&province=" + $("#province").val() + "&country=" + $("#country").val(),
                                                    cache: false,
                                                    dataType: 'json',
                                                    type: 'POST',
                                                    beforeSend: function() {
                                                        $('#home').append('<div id="pageload"></div>');
                                                    },
                                                    complete: function() {
                                                        $('#pageload').remove();
                                                    },
                                                    success: function(json) {
                                                        $("#after-loading-success-message").css('display', 'block');
                                                        $("#after-loading-success-message").html('<div class ="background-overlay"></div>\n\
        <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-cart" style="position: relative; top: 45%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;">\n\
        <span>\n\
                                ' + json.data + ' </span></button>');
                                                        $("#continue_shopping").click(function() {
                                                            $('#after-loading-success-message').fadeOut();
                                                        });
                                                        $('#after-loading-success-message').delay(2000).fadeOut();

                                                    },
                                                    error: function(xmlHttpRequest, textStatus, errorThrown) {
                                                        start = xmlHttpRequest.responseText.search("<title>") + 7;
                                                        end = xmlHttpRequest.responseText.search("</title>");
                                                        errorMsg = xmlHttpRequest.responseText;
                                                        if (start > 0 && end > 0)
                                                            alert("Undifine " + errorMsg + xmlHttpRequest.responseText + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                                                        else
                                                            alert("Error  " + errorMsg + xmlHttpRequest.responseText);
                                                    }
                                                });
                                            });
                                        }
                                        function confirmation_pay() {
                                            $(document).ready(function() {
                                                var file_data = $('#images_bank').prop('files')[0];
                                                var form_data = new FormData();
                                                form_data.append('images_bank', file_data);
                                                form_data.append('order_code', $('#order_code').val());
                                                form_data.append('member_bank', $('#member_bank').val());
                                                form_data.append('member_account_bank', $('#member_account_bank').val());
                                                form_data.append('id_bank', $('#id_bank').val());
                                                form_data.append('total_price', $('#total_price').val());
                                                form_data.append('transfer_date', $('#transfer_date').val());
                                                form_data.append('note', $('#note').val());

                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url(); ?>member_account/confirmation_pay/",
                                                    processData: false,
                                                    contentType: false,
                                                    data: form_data,
                                                    dataType: 'json'
                                                }).done(function(json) {
                                                    $("#after-loading-success-message").css('display', 'block');
                                                    $("#after-loading-success-message").html('<div class ="background-overlay"></div>\n\
        <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-cart" style="position: relative; top: 45%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;">\n\
        <span>\n\
                                ' + json.data + ' </span></button>');
                                                    $("#continue_shopping").click(function() {
                                                        $('#after-loading-success-message').fadeOut();
                                                        if (json.confirmStatus == 'valid') {
                                                            clearDataPayment();
                                                            document.location.href="<?= base_url();?>member_account";
                                                        }
                                                    });
                                                    $('#after-loading-success-message').delay(2000).fadeOut("slow", function() {
                                                        if (json.confirmStatus == 'valid') {
                                                            clearDataPayment();
                                                            document.location.href="<?= base_url();?>member_account";
                                                        }
                                                    });

                                                });
                                            });
                                        }
                                        function sendReturn() {
                                            $(document).ready(function() {
                                                var file_data = $('#images_bank_return').prop('files')[0];
                                                var form_data = new FormData();
                                                form_data.append('images_bank_return', file_data);
                                                form_data.append('order_code_return', $('#order_code_return').val());
                                                form_data.append('note_return', $('#note_return').val());

                                                $.ajax({
                                                    type: "POST",
                                                    url: "<?php echo base_url(); ?>member_account/sendReturn/",
                                                    processData: false,
                                                    contentType: false,
                                                    data: form_data,
                                                    dataType: 'json'
                                                }).done(function(json) {
                                                    $("#after-loading-success-message").css('display', 'block');
                                                    $("#after-loading-success-message").html('<div class ="background-overlay"></div>\n\
        <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-cart" style="position: relative; top: 45%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;">\n\
        <span>\n\
                                ' + json.data + ' </span></button>');
                                                    $("#continue_shopping").click(function() {
                                                        $('#after-loading-success-message').fadeOut();
                                                        if (json.confirmStatus == 'valid') {
                                                            clearDataPayment();
                                                        }
                                                    });
                                                    $('#after-loading-success-message').delay(2000).fadeOut("slow", function() {
                                                        if (json.confirmStatus == 'valid') {
                                                            clearDataPayment();
                                                        }
                                                    });

                                                });
                                            });
                                        }
                                        function clearDataPayment() {
                                            $('#order_code').val("");
                                            $('#member_bank').val("0");
                                            $('#member_account_bank').val("");
                                            $('#id_bank').val("1");
                                            $('#total_price').val("");
                                            $('#transfer_date').val("");
                                            $('#note').val("");
                                            $('#images_bank').val(" ");
                                        }
                                        $(document).ready(function() {
                                            $('#transfer_date').datetimepicker({
                                                format: 'Y-m-d H:i'
                                            });
                                        });
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
                                        onlynumber('total_price');
                                       
</script>
