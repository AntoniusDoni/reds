<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Post Comment
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/gmadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"> Comment</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <?php if (empty($_GET['id'])) { ?>
                        <h3 class="box-title"> Comment</h3>
                        <div class="box-body ">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Post Title</th>
                                        <th>Name (email)</th>
                                        <th>Subject</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $tablecontent; ?>
                                </tbody>  
                            </table>
                        </div>
                    <?php } else { ?>
                        <h3 class="box-title">Reply Comment</h3>
                        <div class="box-body ">
                            <form class="contact-form" id="contact-form" action="<?= base_url()?>jpmp/comments/reply" method="post">
                                <input type="hidden" id="id_parent_comment" name="id_parent_comment" value="<?= $_GET['id']?>">

                                <textarea class="form-control" rows="5" placeholder="Enter your message" style="margin: 0px;" id="comments" name="comments"></textarea>
                                <input type="submit" class='btn btn-primary' value="Reply Comment" />
                            </form>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </section>
</div>
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
                                function getStatusComment(id, idComment) {
                                    $(document).ready(function() {
                                        $.ajax({
                                            type: "POST",
                                            url: '<?= base_url(); ?>jpmp/comments/updateStatus',
                                            data: "status_comment=" + $("#status_comment" + id).val() + "&idComment=" + idComment,
                                        }).done(function(data) {

                                            document.location.href = "<?= base_url(); ?>jpmp/comments";
                                        });
                                    });
                                }
</script>
