<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() ?>">Home</a></li>
                    <li class="active"><?php
                        if ($idcategory == 0) {
                            echo 'Uncategorized';
                        } else {
                            echo @$this->modelproduct->getRowDataProduct(" INNER JOIN category  on category.category_id=product.id_category WHERE id_product='$idproduct' ")->category_name;
                        }
                        ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>


<section id='main'>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="product-slider-small">
                    <ul id="mycarousel" class="jcarousel jcarousel-skin-tango">
                        <?php if (!empty($this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->main_images)) { ?>
                            <li  class="image"><a href="#" rel='<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->main_images; ?>'><img  src="<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->main_images; ?>" alt="<?php echo $title; ?>"/></a></li>
                        <?php }
                        ?>
                        <?php
                        if (!empty($this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images1)) {
                            ?>
                            <li  class="image"><a href="#" rel='<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images1; ?>'><img src="<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images1; ?>" alt="<?php echo $title; ?>"/></a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images2)) {
                            ?>
                            <li  class="image"><a href="#" rel='<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images2; ?>'><img  src="<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images2; ?>" alt="<?php echo $title; ?>"/></a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if (!empty($this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images3)) {
                            ?>
                            <li  class="image"><a href="#" rel='<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images3; ?>'><img  src="<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->images3; ?>" alt="<?php echo $title; ?>"/></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div  class="product-image-big" style="background-image: url('<?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->main_images; ?>');"></div>
            </div>
            <div class="col-sm-6">
                <div class="product-details">
                    <h1><?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->title; ?></h1>
                    <hr />
                    <div class="details">
                        <span class="detail-line"><strong>Availability:</strong> <div style="float: right; margin-right: 150px; font-weight: bold;" id="stok">Please Choose Size to see Stok</div></span>
                    </div>

                    <div class="col-sm-12" style="overflow: hidden; margin: 0px; padding: 0px;">
                        <div class="col-lg-2" style="overflow: hidden; margin: 0px; padding: 0px;"><strong>Size:</strong></div>
                        <div class="col-lg-10"><?php echo $selectsize; ?></div>
                    </div>
                    <div class="description">
                        <?php echo @$this->modelproduct->getRowDataProduct("WHERE id_product='$idproduct'")->description; ?>
                    </div>
                    <div class="price-line">
                        <div class="price">Rp. -Please Choose Size-</div>
                        <button class="btn btn-default custom-button custom-button-inverted" onclick="addtocarts('<?= $idproduct; ?>')">Add to bag</button>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" value="1" id="quantity" placeholder="Quantity" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="addquantity" ><i class="glyphicon glyphicon-plus"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="share-line">
                        <span class="title">Share: </span>
                        <div class="share-widget">
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-538e859c24991359" async="async"></script>
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_sharing_toolbox"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer"></div>  
        <div class="col-sm-12">
            <div class="section-title">
                <h1>Related products</h1>
            </div>
        </div>
        <?php
        $queryRelateProduct = @$this->modelproduct->getListProduct("INNER JOIN product_detail as detail on detail.id_product=product.id_product  WHERE id_category='$idcategory' GROUP  BY title order by product.id_product DESC LIMIT 0,4");
        foreach ($queryRelateProduct->result()as $rowprodre) {
            ?>
            <article class="category-article category-grid col-sm-3">
                <figure>
                    <?php if (!empty($rowprodre->diskon)) { ?>
                        <div class="corner-sign red">Sale <?php echo $rowprodre->diskon; ?> %</div>
                    <?php } ?>
                    <img src="<?php echo $rowprodre->main_images; ?>" alt="<?php echo $rowprodre->title; ?>" />
                    <div class="figure-overlay">
                        <input type="hidden" id="id_product_detail" name="id_product_detail" value="0"/>
                        <button class="btn btn-default custom-button" onclick="addtocart('<?php echo $rowprodre->url; ?>');">Add to Bag</button>


                    </div>
                </figure>
                <div class="text">
                    <h2><a href="<?= base_url() . 'detailproduct/' . $rowprodre->url; ?>"><?= $rowprodre->title; ?></a></h2>
                    <?php
                    if (!empty($rowprodre->diskon)) {
                        $discon = str_replace(',', '', $rowprodre->prices) * $rowprodre->diskon / 100;
                        $prices = str_replace(',', '', $rowprodre->prices) - $discon;
                    } else {
                        $prices = $rowprodre->prices;
                    }
                    ?>
                    <div class="price">
                        <span class="new-price">Rp. <?php echo number_format($prices) ?></span>
                    </div>
                </div>
            </article>
        <?php } ?>
    </div>

</section>




<script type="text/javascript">
//    send ajax to check stok by size and view stock and price the stock
                            function checkstok(idproduct) {
                                $(document).ready(function() {

                                    $.ajax({
                                        url: "<?php echo base_url(); ?>home/checkstok/",
                                        data: "idproduct=" + idproduct + "&size=" + $("#size").val(),
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

                                            $("#stok").html(json.data);
                                            $(".price").html("Rp. " + json.data1);
                                            $("#id_product_detail").val(json.data2);
                                            $("#addquantity").attr('onclick', "addquantity('" + json.data + "');");
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
                            //                            function add the quatity in proses cart
                            function addquantity(limit) {
                                $(document).ready(function() {
                                    vals = $("#quantity").val();
                                    count = parseInt(vals) + 1;

                                    if (limit >= count) {
                                        $("#minus").remove();
                                        $("#quantity").val(count);
                                        $('<span class="input-group-btn" id="minus"><button class="btn btn-default" type="button" id="minquantity"><i class="glyphicon glyphicon-minus"></i></button></span>').insertBefore("#quantity");
                                        $("#minquantity").attr('onclick', 'minquantity(1);');
                                    } else {
                                        alert("Out of Stock");
                                    }
                                });
                            }
//                            function min the quatity in proses cart
                            function minquantity(limit) {
                                $(document).ready(function() {
                                    vals = $("#quantity").val();
                                    count = parseInt(vals) - 1;
                                    if (limit == count) {
                                        $("#quantity").val(limit);
                                        $("#minus").remove();
                                    } else {
                                        $("#quantity").val(count);
                                    }
                                });
                            }
//                            send ajax post to add a cart
                            function addtocarts(idproduct) {
                                if ($("#size").val() != 0) {
                                    $(document).ready(function() {
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>home/addcartsdetailproduct/",
                                            data: "idproduct=" + idproduct + "&quantity=" + $("#quantity").val() + "&size=" + $("#size").val() + "&id_product_detail=" + $("#id_product_detail").val(),
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
                                                $("#after-loading-success-message").html("");
                                                $(".carttotals").html(json.data);
                                                $("#after-loading-success-message").css('display', 'block');
                                                $("#after-loading-success-message").html('<div class ="background-overlay"></div>\n\
        <p id="success-message-container" class="loader" >Product was successfully added to your shopping cart.	<br/><br/>\n\
        <button type="button" name="finish_and_checkout" id="finish_and_checkout" class="button btn-cart" ><span>\n\
                                Go to cart page		</span></button>\n\
        <br/><br/>\n\
        <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-cart" >\n\
        <span>\n\
                                Continue shopping		</span></button>');
                                                $("#continue_shopping").click(function() {
                                                    $('#after-loading-success-message').fadeOut();
                                                });
                                                $("#finish_and_checkout").click(function() {
                                                    document.location.href = "<?php echo base_url(); ?>checkout"
                                                });
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
                                } else {
                                    alert("Please Select Your Size");
                                }
                            }
                            $('#mycarousel a').on('click', function() {
                                var imgLink = jQuery(this).attr('rel');
                                $('.product-image-big').fadeOut('fast', function() {
                                    $('.product-image-big').css({
                                        "background-image": "url('" + imgLink + "')"
                                    }).fadeIn('fast');
                                });
                                return false;
                            });

</script>