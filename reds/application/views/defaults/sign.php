<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Sign in & Register</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id='main'>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="section-title"><h3 class="text-center">Sign In</h3></div>
                <form method="post" action="<?php echo base_url() ?>sign/loginmember"   class="contact-form ">
                    <div class="form-group">
                        <input class="form-control" required type="email" class="text" name="email" id="login" placeholder="Email" autofocus>
                    </div>

                    <div class="form-group">
                        <input class="form-control" required type="password" class="text" name="password" id="password" placeholder="Password">
                    </div>

                    <div class="text-center">
                        <button class="custom-button btn-sm" id="loginButton" type="submit">Sign In</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <div class="section-title"><h3 class="text-center">Register</h3></div>
                <form method="post" action="<?php echo base_url() ?>sign/registermember" class="contact-form ">
                    <div class="form-group">
                        <input class="form-control" required type="email" class="text" name="email" id="email" placeholder="Email" autofocus>
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="password" class="text" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="password" class="text" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" class="text" name="name" id="name" placeholder="Complete Name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" required type="text" class="text" name="streetname" id="address" placeholder="Street name">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="province_id" id="province_id" value=""/>
                        <input class="form-control" required type="text" class="text" name="province" id="province" placeholder="Province">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="city_id" id="city_id" value=""/>
                        <input class="form-control" required type="text" class="text" name="city" id="city" placeholder="City" readonly="">
                    </div>
                    <div class="form-group">
                        <input class="form-control" class="span3" name="country" type="text"  value="Indonesia" required>
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" class="text" name="phone" id="phone" placeholder="Phone" required>
                    </div>
                    <div class="text-center">
                        <button class="custom-button btn-sm " id="loginButton" type="submit" style="width: 90%;">Register</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
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
</script>