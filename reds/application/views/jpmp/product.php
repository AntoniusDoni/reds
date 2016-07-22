<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Product
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Product</li>
        </ol>
    </section>
    <script>
        function addProduct() {
            $("#content-add-product").css('display', 'block');
            $("#add-btn-Product").attr('onclick', 'clearAddProduct()');
            $("#add-btn-Product").val("Cancel");
        }
        function clearAddProduct() {
            document.location.href = "<?= base_url(); ?>" + "jpmp/product";
//        $("#content-add-product").css('display', 'none');
//        $("#add-btn-Product").attr('onclick', 'addProduct()');
//        $("#add-btn-Product").val("Add Product");

        }
    </script>
    <?php
    if ($id_product != 0) {
        $title = $this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->title;
        $id_category = $this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->id_category;
        $description = $this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->description;
        $main_images = $this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->main_images;
        $metaTag = $this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->metaTag;
        $metaDescription = $this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->metaDescription;
        $sizeType = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product='$id_product' order by id_product_detail DESC LIMIT 0,1")->size;
        $no = 1;
        $contentTypeSize = "";
        ?>
        <?php
        if ($sizeType != 'allsize') {
            $discont = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product='$id_product' order by id_product_detail DESC LIMIT 0,1")->diskon;
            $prices = "";
            $stok = "";

            $queryAditionalType = $this->modelproduct->getListProduct_detail(" WHERE id_product='$id_product'");

            foreach ($queryAditionalType->result() as $rowtable) {
                if ($no == 1) {
                    $stok1 = $rowtable->stok;
                    $prices1 = $rowtable->prices;
                    $size1 = $rowtable->size;
                } else {
                    $contentTypeSize.='<div id="size-content-' . ($no - 1) . '" style="overflow: hidden;"><div class="form-group col-lg-3" >
                   <label for="size" class="control-label col-md-2">&nbsp;</label>
                   <div class="col-md-8">
                     <div class="input-group">
                        <span class="input-group-addon">Size</span>
                        <input class="form-control col-md-8" type="text"  name="size_' . $no . '" value="' . $rowtable->size . '" id="size_' . $no . '">
                    </div>
                    </div>
                    </div>
                    <div class="form-group col-lg-4">
                     <label for="defaultprice" class="control-label col-md-2">Price</label>
                    <div class="col-md-9">
                       <div class="input-group">
                           <span class="input-group-addon">Rp.</span>
                           <input class="form-control" type="text" name="price_' . $no . '" value="' . $rowtable->prices . '" id="price_' . $no . '" required>
                           <span class="input-group-addon">00</span>
                       </div>
                    </div>
                    </div>
                    <div class="form-group col-lg-3" id="stock">
                       <label for="size" class="control-label col-md-2">&nbsp;</label>
                       <div class="col-md-8">
                           <div class="input-group">
                               <span class="input-group-addon">Stok</span>
                               <input class="form-control" type="text"  name="stock_' . $no . '" value="' . $rowtable->stok . '" id="stock_' . $no . '">
                           </div>
                       </div>
                    </div>
                    <div class="form-group col-lg-2">
                       <label class="control-label col-md-2"></label>
                       <div class="col-md-4">
                           <button  type="button" id="addsize"  class="btn btn-primary" onclick="removesizeitem(' . ($no - 1) . ')" >Remove size</button>
                       </div>
                    </div>
                    </div>';
                }
                $no++;
            }
            ?>
            <script>
                $(document).ready(function() {
                    $("#stock-content").css('display', 'block');
                    $("#price-content").remove();
                    $("#allsizeN").attr('checked', 'checked');
                });
            </script>
            <?php
        } else {
            $contentTypeSize = "";
            $discont = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product='$id_product' order by id_product_detail DESC LIMIT 0,1")->diskon;
            $prices = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product='$id_product' order by id_product_detail DESC LIMIT 0,1")->prices;
            $stok = $this->modelproduct->getRowDataProduct_Detail("WHERE id_product='$id_product' order by id_product_detail DESC LIMIT 0,1")->stok;
            $stok1 = "";
            $prices1 = "";
            $size1 = "";
            ?>
            <script>
                $(document).ready(function() {
                    $("#stock-content").css('display', 'none');
                    $("#allsizeY").attr('checked', 'checked');

                });
            </script>
        <?php }
        ?>
        <script>
            $(document).ready(function() {
                addProduct();
            });
        </script>

        <?php
    } else {
        $title = "";
        $id_category = "";
        $description = "";
        $main_images = "";
        $metaTag = "";
        $metaDescription = "";
        $contentTypeSize = "";
        $prices = "";
        $stok = "";
        $discont = "";
        $no = 1;
        $stok1 = "";
        $prices1 = "";
        $size1 = "";
    }
    ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12" id="content-btnadd-product">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label col-md-1"></label>
                            <div class="col-lg-4">
                                <input type="submit" value="Add Product" class="btn btn-primary" id="add-btn-Product" onclick="addProduct();">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="content-add-product">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Product</h3>
                    </div>

                    <div class="box-body">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>jpmp/product/save" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo @$id_product; ?>" id="id_product" name="id_product">
                            <div class="form-group">
                                <label for="title" class="control-label col-md-2">Title</label>
                                <div class="col-md-7">
                                    <input id="title" placeholder="Title" class="form-control" type="text" name="title" value="<?= $title; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-md-2">Category</label>
                                <div class="col-md-8">
                                    <?php echo form_dropdown('id_category', $this->modelcategory->getArraycategory(), $id_category, ' id="id_category" class="form-control"'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-md-2">Description</label>
                                <div class="col-md-12">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="ind-pills">
                                            <textarea style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 71px;" id="description" name="description" class="form-control ckeditor" >
                                                <?= $description; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images" class="control-label col-md-2">Images</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="images" name="images" value="<?= $main_images; ?>" required>
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images', 'images');">Browse</div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="images" class="control-label col-md-2">Images 1</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="images1" name="images1" value="<?=  @$this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->images1; ?>" >
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images1', 'images1');">Browse</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images" class="control-label col-md-2">Images 2</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="images2" name="images2" value="<?=  @$this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->images2; ?>" >
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images2', 'images2');">Browse</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images" class="control-label col-md-2">Images 3</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="images3" name="images3" value="<?=  @$this->modelproduct->getRowDataProduct("WHERE id_product='$id_product'")->images3; ?>" >
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images3', 'images3');">Browse</div>
                                </div>
                            </div>
                            <div class="form-group " >
                                <label for="defaultprice" class="control-label col-md-2">Discount</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="diskon" name="diskon" value="<?= $discont; ?>" required>
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="insertdefaultstock">
                                <label class="control-label col-lg-2">All Size</label>
                                <div class="col-lg-3">
                                    <label class="radio-inline">
                                        <input name="allsize" id="allsizeY" value="1" type="radio"  required onchange="getstok(0);" checked="checked">YES
                                    </label>
                                    <label class="radio-inline">
                                        <input name="allsize" id="allsizeN" value="0" type="radio" onchange="getstok(1);" >NO
                                    </label>
                                </div>
                                <div id="space-price"></div>
                                <div id="price-content">
                                    <div class="form-group col-lg-4" >
                                        <label for="price" class="control-label col-md-2">Price</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input class="form-control" type="text" id="price" name="price" value="<?= $prices; ?>" required>
                                                <span class="input-group-addon">00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-3" >
                                        <label for="size" class="control-label col-md-2">&nbsp;</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <span class="input-group-addon">Stok</span>
                                                <input class="form-control" type="text"  name="stock" value="<?= $stok; ?>" id="stock">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            </br>
                            <div class="col-lg-12" id="stock-content">
                                <div class="form-group col-lg-3" >
                                    <label for="size" class="control-label col-md-2">&nbsp;</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">Size</span>
                                            <input class="form-control col-md-8" type="text"  name="size_1" value="<?= $size1; ?>" id="size_1">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="defaultprice" class="control-label col-md-2">Price</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp.</span>
                                            <input class="form-control" type="text"  name="price_1" value="<?= $prices1; ?>" id="price_1" >
                                            <span class="input-group-addon">00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3" >
                                    <label for="size" class="control-label col-md-2">&nbsp;</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">Stok</span>
                                            <input class="form-control" type="text"  name="stock_1" value="<?= $stok1; ?>" id="stock_1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2">
                                    <label class="control-label col-md-2"></label>
                                    <div class="col-md-4">
                                        <button  type="button" id="addsize"  class="btn btn-primary" onclick="addsizeitem(<?= $no; ?>)" >add size</button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="stokscontainer"><div id="stocks-warper"></div><?= $contentTypeSize; ?></div>

                            <div class="form-group">
                                <label for="matadescription" class="control-label col-lg-2">Meta description</label>
                                <div class="col-lg-8">
                                    <input required type="text" name="matadescription" id="matadescription" placeholder="meta description" class="form-control" value="<?= $metaDescription; ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tags" class="control-label col-lg-2">Meta Tags</label>
                                <div class="col-lg-8">
                                    <input style="display: none;" name="metatag" id="tags"  value="<?= $metaTag; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-4">
                                    <input type="submit" value="Save Product" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="list-content-product">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Product</h3>
                    </div>
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Images</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $tablecontent; ?>
                            </tbody>  
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/tagsinput/jquery.tagsinput.css" />
<script src="<?php echo base_url(); ?>assets/tagsinput/jquery.tagsinput.min.js"></script>
<script>
            $('#tags').tagsInput();
</script>

<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('description',
            {
                filebrowserImageBrowseUrl: '<?php echo base_url(); ?>jpmp/filemanager'
            });
</script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {

        $('#dialog').remove();
        $('.content-wrapper').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;">\n\
<iframe src="<?php echo base_url(); ?>jpmp/filemanager/?field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
        $('#dialog').dialog({
            title: 'JpMp FIlE MANAGER',
            close: function(event, ui) {
                if ($('#' + field).attr('value')) {
                    $.ajax({
                        url: '<?php echo base_url(); ?>jpmp/filemanager/image?image=' + encodeURIComponent($('#' + field).attr('value')),
                        dataType: 'text',
                        success: function(data) {
//                    $('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
                        }
                    });
                }
            },
            bgiframe: false,
            width: 600,
            height: 400,
            resizable: false,
            modal: false
        });
    }//-->
    function getstok(condition) {
        var indexOfContent = "<?= $no; ?>";
        if (condition == 1) {

            if (indexOfContent != 1) {
                document.location.reload();
            } else {
                $("#stock-content").css('display', 'block');
                $("#price-content").remove();
            }

        } else {
            $("#stock-content").css('display', 'none');
            $('<div id="price-content">' +
                    '<div class="form-group col-lg-4" >' +
                    '   <label for="price" class="control-label col-md-2">Price</label>' +
                    '  <div class="col-md-9">' +
                    '     <div class="input-group">' +
                    '        <span class="input-group-addon">Rp.</span>' +
                    '       <input class="form-control" type="text" id="price" name="price" value="<?= $prices; ?>" required>' +
                    '      <span class="input-group-addon">00</span>' +
                    ' </div>' +
                    '</div>' +
                    ' </div>' +
                    '<div class="form-group col-lg-3" >' +
                    '   <label for="size" class="control-label col-md-2">&nbsp;</label>' +
                    '  <div class="col-md-8">' +
                    '     <div class="input-group">' +
                    '        <span class="input-group-addon">Stok</span>' +
                    '       <input class="form-control" type="text"  name="stock" value="<?= $stok; ?>" id="stock">' +
                    '  </div>' +
                    '</div>' +
                    '</div>' +
                    '</div>').insertAfter("#space-price");

            if (indexOfContent != 1) {
                for (i = 0; i <= indexOfContent; i++) {
                    $("#size-content-" + i).remove();
                }

            }

        }
    }
    function addsizeitem(id) {
        no = id + 1;
        if (id < 6) {
            $('<div id="size-content-' + id + '" style="overflow: hidden;"><div class="form-group col-lg-3" >' +
                    '<label for="size" class="control-label col-md-2">&nbsp;</label>' +
                    '<div class="col-md-8">' +
                    ' <div class="input-group">' +
                    '    <span class="input-group-addon">Size</span>' +
                    '    <input class="form-control col-md-8" type="text"  name="size_' + no + '" value="" id="size_' + no + '">' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group col-lg-4">' +
                    ' <label for="defaultprice" class="control-label col-md-2">Price</label>' +
                    '<div class="col-md-9">' +
                    '   <div class="input-group">' +
                    '       <span class="input-group-addon">Rp.</span>' +
                    '       <input class="form-control" type="text" name="price_' + no + '" value="" id="price_' + no + '" required>' +
                    '       <span class="input-group-addon">00</span>' +
                    '   </div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="form-group col-lg-3" id="stock">' +
                    '   <label for="size" class="control-label col-md-2">&nbsp;</label>' +
                    '   <div class="col-md-8">' +
                    '       <div class="input-group">' +
                    '           <span class="input-group-addon">Stok</span>' +
                    '           <input class="form-control" type="text"  name="stock_' + no + '" value="" id="stock_' + no + '">' +
                    '       </div>' +
                    '   </div>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '   <label class="control-label col-md-2"></label>' +
                    '   <div class="col-md-4">' +
                    '       <button  type="button" id="addsize"  class="btn btn-primary" onclick="removesizeitem(' + (no - 1) + ')" >Remove size</button>' +
                    '   </div>' +
                    '</div>\n\
                    </div>').insertAfter("#stocks-warper");
            $("#addsize").attr('onclick', 'addsizeitem(' + no + ');');

        } else {
            alert("Max is 5 add");
        }
    }
    function removesizeitem(id) {
        no = id - id;
        $("#addsize").attr('onclick', 'addsizeitem(' + no + ');');
        $("#size-content-" + id).remove();
    }

</script>

<style>
    #stock-content{display: none;}
    #content-add-product{display: none;}
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/datatables/dataTables.bootstrap.css">
<script src="<?php echo base_url(); ?>assets/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $(function() {

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
