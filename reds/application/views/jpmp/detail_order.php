<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Detail Order
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Detail Order</li>
        </ol>
    </section>
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Detail Order
                    <small class="pull-right">Date: <?= @$this->modelorder->getRowDataOrder(" WHERE id_order='$idorder'")->dates_order; ?></small>
                </h2>
            </div><!-- /.col -->


            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Name  </strong><br>
                </address>
            </div>
            <div class="col-sm-8 invoice-col">
                <address>
                    <strong> : <?= @$this->modelorder->getRowDataOrder("INNER JOIN member ON member.id_member=orders.id_member WHERE id_order='$idorder'")->name; ?></strong><br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Address  </strong><br>
                </address>
            </div>
            <div class="col-sm-8 invoice-col">
                <address>
                    <strong> : <?= @$this->modelorder->getRowDataOrder("INNER JOIN member ON member.id_member=orders.id_member WHERE id_order='$idorder'")->address; ?></strong><br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Phone  </strong><br>
                </address>
            </div>
            <div class="col-sm-8 invoice-col">
                <address>
                    <strong> : <?= @$this->modelorder->getRowDataOrder("INNER JOIN member ON member.id_member=orders.id_member WHERE id_order='$idorder'")->phone; ?></strong><br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Email  </strong><br>
                </address>
            </div>
            <div class="col-sm-8 invoice-col">
                <address>
                    <strong> : <?= @$this->modelorder->getRowDataOrder("INNER JOIN member ON member.id_member=orders.id_member WHERE id_order='$idorder'")->emails; ?></strong><br>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Estimate Deliver  </strong><br>
                </address>
            </div>
            <div class="col-sm-8 invoice-col">
                <address>
                    <strong> : <?= @$this->modelorder->getRowDataOrder(" WHERE id_order='$idorder'")->estimate_deliver; ?> Day's</strong><br>
                </address>
            </div>
        </div>
    </section>
    <section class="invoice">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-body">

                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $queryDetailOrder = $this->modelorder->getListOrderDetail(" 
                                    INNER JOIN product_detail ON product_detail.id_product_detail=order_detail.id_detail_product
                                    INNER JOIN product ON product_detail.id_product=product.id_product
                                    WHERE id_order='$idorder' 
                                    ");
                            $no = 1;
                            $sumprice = 0;
                            foreach ($queryDetailOrder->result() as $rowtable) {
                                ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $rowtable->title; ?></td>
                                    <td><?= $rowtable->quantity; ?></td>
                                    <td>Rp. <?= number_format(($rowtable->quantity * $rowtable->price)); ?></td>
                                </tr>
                                <?php
                                $no++;
                                $sumprice = $sumprice + $rowtable->quantity * $rowtable->price;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align: center;">Shipping</th>
                                <td>Rp. <?= number_format(@$this->modelorder->getRowDataOrder("WHERE id_order='$idorder'")->shipping_price); ?></td>
                            </tr>
                            <tr>
                                <th colspan="3" style="text-align: center;"><b>Total</b></th>
                                <th><b>Rp. <?= number_format(@$this->modelorder->getRowDataOrder("WHERE id_order='$idorder'")->shipping_price + $sumprice); ?></b></th>
                            </tr>   
                        </tfoot>
                    </table>
                    </br>
                    <div class="form-group col-sm-8">
                        <label for="name" class="control-label col-md-2">Update Status</label>
                        <div class="col-md-8">
                            <?php
                            $status_order = @$this->modelorder->getRowDataOrder("WHERE id_order='$idorder'")->status_order;
                            echo form_dropdown('status_order', $getStatusOrder, $status_order, ' id="status_order" class="form-control" onchange="changeStatus();"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group col-sm-4">
                        <a href="<?= base_url()?>jpmp/order" class="btn btn-primary">Back to Order</a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>
<script>
    function changeStatus() {
        $.ajax({
            type: "POST",
            url: '<?= base_url();?>jpmp/detail_order/updatestatus',
            data: 'idorder=<?= $idorder;?>&status=' + $("#status_order").val(),
            dataType: "json"
        }).done(function(data) {
            alert(data.data);
        });
    }
</script>    