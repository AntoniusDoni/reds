<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Post
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Post</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Post</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>jpmp/inputpost/save" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $idpost; ?>" id="idpost" name="idpost">
                            <div class="form-group">
                                <label for="name" class="control-label col-md-2">Title</label>
                                <div class="col-md-8">
                                    <input required id="title" placeholder="Title" class="form-control" type="text" name="title" value="<?php echo @$this->modelpost->getRowDataPost("WHERE id_post='" . @$idpost . "'")->title; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-md-2">Category</label>
                                <div class="col-md-8">
                                    <?php echo form_dropdown('id_category', $this->modelcategory->getArraycategory(), @$this->modelpost->getRowDataPost("WHERE id_post='" . @$idpost . "'")->id_category, ''); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-md-2">Description</label>
                                <div class="col-md-12">
                                    <ul class="nav nav-pills">
                                        <li class="active">
                                            <a href="#ind-pills" data-toggle="tab">
                                                <img src="<?php echo base_url(); ?>images/id.png" alt="Indonesia">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#eng-pills" data-toggle="tab">
                                                <img src="<?php echo base_url(); ?>images/england.png" alt="English">
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="ind-pills">
                                            <textarea style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 71px;" id="description_ind" name="description_ind" class="form-control ckeditor" >
                                                <?php echo @$this->modelpost->getRowDataPost_Desciption("WHERE id_post='" . @$idpost . "' and lang='ID'")->description; ?>
                                            </textarea>
                                        </div>
                                        <div class="tab-pane fade" id="eng-pills">
                                            <textarea style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 71px;" id="description_eng" name="description_eng" class="form-control ckeditor" >
                                                <?php echo @$this->modelpost->getRowDataPost_Desciption("WHERE id_post='" . @$idpost . "' and lang='EN'")->description; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="images" class="control-label col-md-2">Images</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="text" id="images" name="images" value="<?php echo @$this->modelpost->getRowDataPost("WHERE id_post='" . @$idpost . "'")->images; ?>" required>
                                    <div style="cursor: pointer;background:white;" onclick="image_upload('images', 'images');">Browse</div>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label for="matadescription" class="control-label col-md-2">Meta Key</label>
                                <div class="col-md-8">
                                    <input required type="text" name="matadescription" id="matadescription" placeholder="meta description" class="form-control" value="<?php echo @$this->modelpost->getRowDataPost("WHERE id_post='" . @$idpost . "'")->metadescription; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tags" class="control-label col-md-2">Meta Tags</label>
                                <div class="col-md-8">
                                    <input style="display: none;" name="metatag" id="tags" name="tags" value="<?php echo html_entity_decode(@$this->modelpost->getRowDataPost("WHERE id_post='" . @$idpost . "'")->metaTag); ?>" class="form-control" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-4">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    <a href="<?php echo base_url(); ?>jpmp/listpost"><input type="cancel" value="Clear" class="btn btn-primary"></a>
                                </div>
                            </div>
                        </form>
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
    }//--></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('description_ind',
            {
                filebrowserImageBrowseUrl: '<?php echo base_url(); ?>jpmp/filemanager'
            });
    CKEDITOR.replace('description_eng',
            {
                filebrowserImageBrowseUrl: '<?php echo base_url(); ?>jpmp/filemanager'
            });</script>