<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id='main'>
    <div id="after-loading-success-message"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive shopping-cart" id="cart-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="20%"><div class="title-wrap" style="text-align: center;">Product Name</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;">Price</div></th>
                        <th width="5%"><div class="title-wrap" style="text-align: center;">Quantity</div></th>
                        <th width="10%"><div class="title-wrap" style="text-align: center;">Subtotal Price</div></th>
                        <th width="5%"><div class="title-wrap" style="text-align: center;">Delete Cart</div></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalPrice = 0;
                            $shipping = 0;
                            if ($this->cart->contents() != null) {
                                foreach ($this->cart->contents() AS $row) {
                                    $stock = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product_detail='" . $row['id'] . "'")->stok;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="cart-product">
                                                <figure>
                                                    <img src="<?= @$this->modelproduct->getRowDataProduct("WHERE id_product='" . $row['options']['idproduct'] . "'")->main_images; ?>" alt="<?= $row['name']; ?>" />
                                                </figure>
                                                <div class="text">
                                                    <h2><a href="<?= base_url() . 'detailproduct/' . @$this->modelproduct->getRowDataProduct("WHERE id_product='" . $row['options']['idproduct'] . "'")->url; ?>"><?= $row['name']; ?></a></h2>
                                                    <div class="details">
                                                        <span class="detail-line">
                                                            <strong>Size: </strong> <?= $row['options']['Size']; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="title-wrap" style="text-align: center;"><?= number_format($row['price']); ?></div></td> 
                                        <td>
                                            <div class="quantity">
                                                <div class="input-group">
                                                    <?php if ($row['qty'] > 1) { ?>
                                                        <span class="input-group-btn" id="minus_<?= $row['rowid']; ?>"><button class="btn btn-default" type="button" id="minquantity_<?= $row['rowid']; ?>" onclick="minquantity('1', '<?= $row['rowid']; ?>')"><i class="glyphicon glyphicon-minus"></i></button></span>
                                                    <?php }
                                                    ?>
                                                    <input type="text" class="form-control" value="<?= $row['qty']; ?>" id="quantity_<?= $row['rowid']; ?>" placeholder="Quantity" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" id="addquantity" onclick="addquantity('<?= $stock; ?>', '<?= $row['rowid']; ?>');"><i class="glyphicon glyphicon-plus"></i></button>
                                                    </span>

                                                </div>
                                            </div>
                                        </td> 
                                        <td><div class="title-wrap" style="text-align: center;"><?= number_format(($row['price'] * $row['qty'])); ?></div></td> 
                                        <td><button class="btn btn-default custom-button" style="margin-left: 25px;" onclick="removeCart('<?= $row['rowid']; ?>');"><i class="glyphicon glyphicon-remove"></i></button></td>
                                    </tr>
                                    <?php
                                    $totalPrice = $totalPrice + ($row['price'] * $row['qty']);
                                }
                            } else {
                                echo '<tr><td colspan="4"><div class="title-wrap" style="text-align: center;">No Cart</div></td></tr>';
                            }
                            ?>
                        </tbody>
                        <tfoot>

                            <tr>
                                <th width="20%" style="text-align: center;" colspan="3"><div class="title-wrap">Total Order</div></th>
                        <th width="15%"><div class="title-wrap" style="text-align: center;" >Rp. <span id="total-price"><?= number_format($totalPrice); ?></span></div></th>
                        </tr>

                        </tfoot>
                    </table>
                </div>
                <?php if ($this->cart->contents() != null) { ?>
                    <a href="<?= base_url(); ?>checkout" ><div class="btn btn-primary">Proses to Checkout</div></a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<script>
                                                function addquantity(limit, id) {
                                                    vals = 0;
                                                    $(document).ready(function() {

                                                        vals = $("#quantity_" + id).val();
                                                        count = parseInt(vals) + 1;
                                                        if (limit >= count) {
                                                            $.ajax({
                                                                type: "POST",
                                                                url: '<?= base_url(); ?>carts/updateCart',
                                                                data: "count=" + count + "&id=" + id,
                                                                dataType: 'json',
                                                            }).done(function(data) {
                                                                $("#minus_" + id).remove();
                                                                $("#quantity_" + id).val(count);
                                                                $('<span class="input-group-btn" id="minus_' + id + '"><button class="btn btn-default" type="button" id="minquantity_' + id + '"><i class="glyphicon glyphicon-minus"></i></button></span>').insertBefore("#quantity_" + id);
                                                                $("#minquantity_" + id).attr('onclick', 'minquantity("1","' + id + '");');
                                                                $(".carttotals").html('<a href="<?= base_url() ?>checkout" ><span class="glyphicon glyphicon-shopping-cart"></span> My Bag: ' + data.data + ' item(s)</a>');
                                                            });


                                                        } else {
                                                            alert("Out of Stock");
                                                        }


                                                    });
                                                }
                                                function minquantity(limit, id) {
                                                    vals = 0;
                                                    $(document).ready(function() {

                                                        vals = $("#quantity_" + id).val();
                                                        count = parseInt(vals) - 1;
                                                        $.ajax({
                                                            type: "POST",
                                                            url: '<?= base_url(); ?>carts/updateCart',
                                                            data: "count=" + count + "&id=" + id,
                                                            dataType: 'json',
                                                        }).done(function(data) {

                                                            if (limit == count) {
                                                                $("#quantity_" + id).val(limit);
                                                                $("#minus_" + id).remove();
                                                            } else {
                                                                $("#quantity_" + id).val(count);
                                                            }
                                                            $(".carttotals").html('<a href="<?= base_url() ?>checkout" ><span class="glyphicon glyphicon-shopping-cart"></span> My Bag: ' + data.data + ' item(s)</a>');
                                                        });
                                                    });

                                                }
                                                function removeCart(id) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: '<?= base_url(); ?>carts/removeCart',
                                                        data: "id=" + id,
                                                        dataType: 'json',
                                                    }).done(function(data) {
                                                        $("#cart-content").html(data.table);
                                                        $(".carttotals").html('<a href="<?= base_url() ?>checkout" ><span class="glyphicon glyphicon-shopping-cart"></span> My Bag: ' + data.data + ' item(s)</a>');
                                                    });
                                                }
</script>
