<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="Content-Type: text/html; charset=utf-8">

        <title>Be ADMIN | HOME</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/ionicons.min.css">
        <!-- Theme style -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">

        <!--javascript-->
        <script src="<?php echo base_url(); ?>assets/jQuery/jquery.js"></script>
        <script src="<?php echo base_url(); ?>assets/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/jQuery/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="hold-transition skin-black-light sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo base_url(); ?>jpmp/beadmin" class="logo" style="background: #3c8dbc;color:#fff;">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>Be</b>Admin</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Be</b>Admin</span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation" style="background: #3c8dbc;">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>  
            <aside class="control-sidebar control-sidebar-light">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                    <li><a href="<?php echo base_url(); ?>jpmp/beadmin/logoutaccount" alt="Sign Out"><i class="fa fa-sign-out"></i></a></li>
                </ul>
            </aside>
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url(); ?>assets/dist/img/user3-128x128.jpg" class="img-circle" alt="Be Admin">
                        </div>
                        <div class="pull-left info">
                            <p>Be Admin</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>
                        <li>
                            <a href="<?php echo base_url(); ?>jpmp/beadmin">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>

                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>jpmp/comments">
                                <i class="fa fa-envelope"></i> <span>Comment</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-share"></i> <span>Web Content</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url(); ?>jpmp/category"><i class="fa fa-circle-o"></i>Category</a></li>
                                <li><a href="<?php echo base_url(); ?>jpmp/inputpost"><i class="fa fa-circle-o"></i>Add Post</a></li>
                                <li><a href="<?php echo base_url(); ?>jpmp/listpost"><i class="fa fa-circle-o"></i>List Post</a></li>
                                <li><a href="<?php echo base_url(); ?>jpmp/slider"><i class="fa fa-circle-o"></i>Slider</a></li>
                            </ul>
                        </li>
                        <?php $versioning=@$this->modelsetting->getDetailSetting($this->session->userdata('useracces'))->versioning;
                        if ($versioning ==0 ) {
                        ?>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-plus-circle"></i> <span>Plugin</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo base_url(); ?>jpmp/shop"><i class="fa fa-circle-o"></i>E-Comerence</a></li>
                                <li><a href="<?php echo base_url(); ?>jpmp/shop"><i class="fa fa-circle-o"></i>Themes</a></li>
                            </ul>
                        </li>
                        <?php }?>
                        <?php
                        $iscom = @$this->modelsetting->getDetailSetting($this->session->userdata('useracces'))->isecommer;
                        if ($iscom == 1) {
                            ?>
                            <li class="treeview">
                                <a href="#">
                                   <i class="fa fa-bar-chart-o"></i> <span>Shop</span>
                                   <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url(); ?>jpmp/product"><i class="fa fa-plus-circle"></i>Product</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/order"><i class="fa fa-plus-circle"></i>New Order</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/order_shipping"><i class="fa fa-plus-circle"></i>Order On Progres</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/order_All"><i class="fa fa-plus-circle"></i>All Order</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/returns"><i class="fa fa-plus-circle"></i>Return</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/accountBank"><i class="fa fa-plus-circle"></i>Account Bank</a></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                   <i class="fa fa-users"></i> <span>Member</span>
                                   <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url(); ?>jpmp/member"><i class="fa fa-plus-circle"></i>Member</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/memberOrder"><i class="fa fa-plus-circle"></i>Member Order</a></li>
                                </ul>
                            </li>
                        <?php }else{ ?>
                            <li class="treeview">
                                <a href="#">
                                   <i class="fa fa-users"></i> <span>Member</span>
                                   <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo base_url(); ?>jpmp/addmember"><i class="fa fa-plus-circle"></i>Add Member</a></li>
                                    <li><a href="<?php echo base_url(); ?>jpmp/member"><i class="fa fa-plus-circle"></i>Member</a></li>
                                    
                                </ul>
                            </li>
                        <?php }?>    
                        <li>
                            <a href="<?php echo base_url(); ?>jpmp/menu">
                                <i class="fa fa-gears"></i> <span>Menu</span> <i class="fa fa-angle-left pull-right"></i>
                            </a>

                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
