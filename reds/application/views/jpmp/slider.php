<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Slider
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Slider</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Slider</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>jpmp/slider/save" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo @$idslider; ?>" id="id_slider" name="id_slider">
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-4">Description</label>
                                <div class="col-lg-7">
                                    <input id="description" placeholder="Description" class="form-control" type="text" name="description" value="<?php echo @$this->modelslider->getDetailSlider("WHERE id_slider='" . @$idslider . "'")->description; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images" class="control-label col-lg-4">Images</label>
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" id="images" name="images" value="<?php echo @$this->modelslider->getDetailSlider("WHERE id_slider='" . @$idslider . "'")->images; ?>" required>
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images', 'images');">Browse</div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="links" class="control-label col-lg-4">Link </label>
                                <div class="col-lg-8">
                                    <?php echo form_dropdown('links_type', $typeLink, @$this->modelslider->getDetailSlider("WHERE id_slider='" . @$idslider . "'")->links_type, 'id="links_type" class="form-control" onchange="getSearchLink();"') ?>
                                </div>
                            </div>
                             <?php $links= @$this->modelslider->getDetailSlider("WHERE id_slider='" . @$idslider . "'")->links;
                                        if($links=="#"){
                                            $style='style="visibility: hidden;"';
                                        }else{
                                             $style='style="visibility: visible;"';
                                        }
                                        ?>
                            <div id="div-link" <?=$style;?>>
                                <div class="form-group">
                                    <label for="links" class="control-label col-lg-4">&nbsp; </label>
                                    <div class="col-lg-7">
                                        <input id="links" placeholder="Link" class="form-control" type="text" name="links" value="<?php echo $links; ?>" >
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-4">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    <a href="<?php echo base_url(); ?>jpmp/slider"><input type="cancel" value="Clear" class="btn btn-primary"></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Slider</h3>
                    </div>
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Description</th>
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
<script type="text/javascript"><!--
function image_upload(field, thumb) {

        $('#dialog').remove();
        $('.content-wrapper').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;">\n\
<iframe src="<?php echo base_url(); ?>jpmp/filemanager/?field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
        $('#dialog').dialog({
            title: 'Be Admin FIlE MANAGER',
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
    }//--></script>
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
    function getSearchLink() {
        $(document).ready(function() {
            typepost = $('#links_type').val();
            if (typepost == 1) {
                $("#div-link").css('visibility', 'visible');
                getAutoComplitePost();
            } else if (typepost == 2) {
                $("#div-link").css('visibility', 'visible');
                getAutoCompliteCategory();
            } else if (typepost == 3) {
                $("#div-link").css('visibility', 'visible');
                getAutoCompliteProduct();
            }
              else if (typepost == 0) {
                $("#div-link").css('visibility', 'hidden');
            }
        });
    }
    function getAutoCompliteProduct(){
        $(document).ready(function () {
           $('#links').autocomplete({
                multiple: true,
                minLength: 2,
                multipleSeparator: ",",
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jpmp/slider/getproductAutocomplite/",
                        data: "links=" + $("#links").val() ,
                        dataType: "json",
                        cache: false,
                        type: "POST",
                        success: function (json) {

                            response(json.data.split(","));

                        },
                        error: function (xmlHttpRequest, textStatus, errorThrown) {
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
                select: function (event, ui) {
                    //alert(ui.item.value);
                },
                change: function (event, ui) {
                }
            }); 
        });
    }
    function getAutoComplitePost() {
        $(document).ready(function () {
           $('#links').autocomplete({
                multiple: true,
                minLength: 2,
                multipleSeparator: ",",
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jpmp/slider/getpostautocomplite/",
                        data: "links=" + $("#links").val() ,
                        dataType: "json",
                        cache: false,
                        type: "POST",
                        success: function (json) {

                            response(json.data.split(","));

                        },
                        error: function (xmlHttpRequest, textStatus, errorThrown) {
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
                select: function (event, ui) {
                    //alert(ui.item.value);
                },
                change: function (event, ui) {
                }
            }); 
        });
    }
    function getAutoCompliteCategory() {
         $(document).ready(function () {
           $('#links').autocomplete({
                multiple: true,
                minLength: 2,
                multipleSeparator: ",",
                source: function (request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jpmp/slider/getcategoryautocomplite/",
                        data: "links=" + $("#links").val() ,
                        dataType: "json",
                        cache: false,
                        type: "POST",
                        success: function (json) {

                            response(json.data.split(","));

                        },
                        error: function (xmlHttpRequest, textStatus, errorThrown) {
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
                select: function (event, ui) {
                    //alert(ui.item.value);
                },
                change: function (event, ui) {
                }
            }); 
        });
    }
    getSearchLink();
</script>