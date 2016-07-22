<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Post
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/gmadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">List Post</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List Post</h3>
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
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
</script>