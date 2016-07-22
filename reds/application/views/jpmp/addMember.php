<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Member
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>jpmp/beadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Member</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Member</h3>
                    </div>
                    <div class="box-body">
                       
                        <form class="form-horizontal" method="POST" action="<?= base_url()?>jpmp/addmember/save" >

                            <input type="hidden" value="<?php echo @$idmember; ?>" id="id_member" name="id_member">
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Name</label>
                                <div class="col-sm-9">
                                    <input id="name" placeholder="Name" class="form-control" type="text" name="name" value="<?php echo @$this->modelmember->getRowDataMember("WHERE id_member='" . @$idmember . "'")->name; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Phone</label>
                                <div class="col-sm-9">
                                    <input id="phone" placeholder="Phone" class="form-control" type="text" name="phone" value="<?php echo @$this->modelmember->getRowDataMember("WHERE id_member='" . @$idmember . "'")->phone; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Email</label>
                                <div class="col-sm-9">
                                    <input id="emails" placeholder="Email" class="form-control" type="email" name="emails" value="<?php echo @$this->modelmember->getRowDataMember("WHERE id_member='" . @$idmember . "'")->emails; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Password</label>
                                <div class="col-sm-9">
                                    <input id="password" placeholder="Password" class="form-control" type="password" name="password" value="<?php echo @$this->modelmember->getRowDataMember("WHERE id_member='" . @$idmember . "'")->password; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label col-sm-2">Address</label>
                                <div class="col-sm-9">
                                    <textarea id="address" placeholder="Address" class="form-control"  name="address"><?php echo @$this->modelmember->getRowDataMember("WHERE id_member='" . @$idmember . "'")->address; ?>
                                    </textarea>
                                </div>
                            </div>
                            
                         
                            <hr>
                            <div class="form-group">
                                <label class="control-label col-lg-3"></label>
                                <div class="col-lg-4">
                                   
                                        <input type="submit" value="Submit" class="btn btn-primary">

                                    <a href="<?php echo base_url(); ?>jpmp/member"><input type="cancel" value="Back" class="btn btn-primary"></a>
                                </div>
                            </div>
                        
                            </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>