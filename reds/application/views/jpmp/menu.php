<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Menu
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Menu</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Add Menu</b>
                    </div>

                    <div class="row">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>jpmp/menu/save" method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <input type="hidden" name="idmenu" id="idmenu" value="<?php echo $idmenu; ?>">
                                <div class="form-group">
                                    <label for="name" class="control-label col-md-2">Title</label>
                                    <div class="col-md-9">
                                        <input placeholder="Title" class="form-control" type="text" id="title" name="title" value="<?php echo @$this->modelmenu->getdetailmenu(@$idmenu)->title; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label col-md-2">Type</label>
                                    <div class="col-md-9">
                                        <?php echo form_dropdown('typepost', $typepost, @$this->modelmenu->getdetailmenu(@$idmenu)->typepost, 'id="typepost" onchange="geturl()" class="form-control"'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label col-md-2">URL</label>
                                    <div class="col-md-9">
                                        <input placeholder="Url" class="form-control" type="text" id="url" name="url" value="<?php echo @$this->modelmenu->getdetailmenu($idmenu)->url; ?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="control-label col-md-2">Parent</label>
                                    <div class="col-md-9">
                                        <?php echo form_dropdown('parent', $this->modelmenu->getArraymenu(), @$this->modelmenu->getdetailmenu(@$idmenu)->parent, 'id="parent" class="form-control"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 center-block">
                                <div class="box-footer ">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    <a href="<?= base_url() ?>jpmp/menu" class="btn btn-primary">Clear</a>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>List Menu</b>
                    </div>
                    <div class="panel-body">
                        <div class="tree-megamenu">
                            <h4>Tree Menu</h4>
                            <?php $this->load->view('jpmp/menutree', $treemenu); ?>
                            <input type="button" name="serialize" id="serialize" value="Update" class="btn btn-primary"/>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>

    function geturl() {
        $(document).ready(function() {
//            $("#url").val("");
            typepost = $('#typepost').val();
            if (typepost == 1) {
                $('#url').val("");
                getAutoComplitePost();
            } else if (typepost == 2) {
//                $('#url').val("");
                getAutoCompliteCategory();
            } else if (typepost == 3) {
                $('#url').val('<?php echo base_url(); ?>postall/' + $("#title").val());
            } else if (typepost == 4) {
                $('#url').val('<?php echo base_url(); ?>categorytall/' + $("#title").val());
            } else if (typepost == 5) {
//                $('#url').val("");
            } else if (typepost == 6) {
//                $('#url').val("");
                getproductAutocomplite();
            } else if (typepost == 7) {
                $('#url').val('<?php echo base_url(); ?>product_all/' + $("#title").val());
            }
            else {
                $('#url').val('<?php echo base_url(); ?>');
            }
        });
    }
    function getAutoComplitePost() {
        $(document).ready(function() {
            $('#url').autocomplete({
                multiple: true,
                minLength: 2,
                multipleSeparator: ",",
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jpmp/slider/getpostautocomplite/",
                        data: "links=" + $("#url").val(),
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
                    //alert(ui.item.value);
                },
                change: function(event, ui) {
                }
            });
        });
    }
    function getAutoCompliteCategory() {
        $(document).ready(function() {
            $('#url').autocomplete({
                multiple: true,
                minLength: 2,
                multipleSeparator: ",",
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jpmp/slider/getcategoryautocomplite/",
                        data: "links=" + $("#url").val(),
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
                    //alert(ui.item.value);
                },
                change: function(event, ui) {
                }
            });
        });
    }
    function getproductAutocomplite() {
        $(document).ready(function() {
            $('#url').autocomplete({
                multiple: true,
                minLength: 2,
                multipleSeparator: ",",
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>jpmp/slider/getproductAutocomplite/",
                        data: "links=" + $("#url").val(),
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
                    //alert(ui.item.value);
                },
                change: function(event, ui) {
                }
            });
        });
    }
    geturl();
</script>