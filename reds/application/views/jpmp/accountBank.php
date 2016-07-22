<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Bank
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bank</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List Bank</h3>
                    </div>
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bank Name</th>
                                    <th>Bank Account</th>
                                    <th>Bank Owner</th>
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
                        <h3 class="box-title">Add Bank</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>jpmp/accountBank/save" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo @$bank_account_id; ?>" id="bank_account_id" name="bank_account_id">
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-4"> Name</label>
                                <div class="col-lg-7">
                                    <input id="bank_name" placeholder="Bank Name" class="form-control" type="text" name="bank_name" value="<?php echo @$this->modelsetting->getDetailBank(@$bank_account_id)->bank_name; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-4">Bank Account</label>
                                <div class="col-lg-7">
                                    <input id="bank_account" placeholder="Bank Account" class="form-control" type="text" name="bank_account" value="<?php echo @$this->modelsetting->getDetailBank(@$bank_account_id)->bank_account; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-lg-4">Bank Owner</label>
                                <div class="col-lg-7">
                                    <input id="bank_owner" placeholder="Bank Owner" class="form-control" type="text" name="bank_owner" value="<?php echo @$this->modelsetting->getDetailBank(@$bank_account_id)->bank_owner; ?>" required>
                                </div>
                            </div>          
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-4">
                                    <input type="submit" value="Submit" class="btn btn-primary">
                                    <a href="<?php echo base_url(); ?>jpmp/accountBank"><input type="cancel" value="Clear" class="btn btn-primary"></a>
                                </div>
                            </div>
                        </form>
                    </div>
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