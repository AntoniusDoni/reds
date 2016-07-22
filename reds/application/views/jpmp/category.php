<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Category
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Category</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Category</h3>
                    </div>
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
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
            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Category</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>jpmp/category/save" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo @$idcategory; ?>" id="idcategory" name="idcategory">
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-4">Category</label>
                                <div class="col-lg-7">
                                    <input id="name" placeholder="Category" class="form-control" type="text" name="title" value="<?php echo @$this->modelcategory->getdetailcategory(@$idcategory)->category_name; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-4">Parent</label>
                                <div class="col-lg-8">
                                    <?php echo form_dropdown('parent', $this->modelcategory->getArraycategory(), @$this->modelcategory->getdetailcategory(@$idcategory)->category_parent, '') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images" class="control-label col-lg-4">Images</label>
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" id="images" name="image" value="<?php echo @$this->modelcategory->getdetailcategory(@$idcategory)->category_images; ?>" required >
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images', 'images');">Browse</div>
                                </div>
                            </div>              
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-4">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    <a href="<?php echo base_url(); ?>jpmp/category"><input type="cancel" value="Clear" class="btn btn-primary"></a>
                                </div>
                            </div>
                        </form>
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
</script>