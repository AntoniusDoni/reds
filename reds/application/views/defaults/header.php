<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title><?= $title; ?></title>
        <meta name="description" content="<?= $metaDescription; ?> | <?= $title; ?>" />
        <meta name="keywords" content="<?= $metaKeyword; ?> | <?= $title; ?>" >
        <meta name="robots" content="<?= $title; ?> | <?= $metaKeyword; ?> | <?= $metaDescription; ?>">
        <meta property="og:title" content="<?= $title; ?>" >
        <meta property="og:type" content="company" >
        <meta property="og:image" content="<?php echo $path; ?>logo.png" >
        <meta name="viewport" content="width=device-width" />
        <link rel="icon" type="image/jpg" href="<?php echo $path; ?>logo.png" />

        <link rel="stylesheet" href="<?php echo $path; ?>css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $path; ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $path; ?>css/flexslider.css" />
        <link rel="stylesheet" href="<?php echo $path; ?>css/chosen.css" />
        <link rel="stylesheet" href="<?php echo $path; ?>css/slider.css" />
        <!--<link rel="stylesheet" href="css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="<?php echo $path; ?>css/style.css" />

        <script src="<?php echo $path; ?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $path; ?>js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="<?php echo $path; ?>js/vendor/jquery.flexslider-min.js"></script>
        <script src="<?php echo $path; ?>js/vendor/jquery.jcarousel.min.js"></script>
        <script src="<?php echo $path; ?>js/vendor/jquery.placeholder.min.js"></script>
        <script src="<?php echo $path; ?>js/vendor/tinynav.min.js"></script>
        <script src="<?php echo $path; ?>js/vendor/jquery.raty.min.js"></script>
        <script src="<?php echo $path; ?>js/vendor/chosen.jquery.min.js"></script>
        <script src="<?php echo $path; ?>js/vendor/bootstrap-slider.js"></script>
        <script src="<?php echo $path; ?>js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo $path; ?>js/plugin-apps.js"></script>
        
    </head>

    <body>
        <div id="after-loading-success-message" ></div>
        <div class="navbar navbar-inverse navbar-fixed-top navbar-custom">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!--Check session Login Member and Set Url login-->
                <?php
                $idw = $this->session->userdata('idmember');
                if (!empty($idw)) {
                    $link = base_url() . 'home/logout';
                    $account = 'Logout';
                } else {
                    $link = base_url() . 'sign';
                    $account = 'Sign in';
                }
                ?>
                <!--set head-fix menu-->
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <li class="active"><a href="<?php echo $link; ?>"><span class='glyphicon glyphicon-user'></span> <?php echo $account; ?></a></li>
                        <li><a href="<?php echo base_url(); ?>carts"><span class='glyphicon glyphicon-briefcase'></span> Shopping cart</a></li>
                        <li><a href="<?php echo base_url(); ?>checkout"><span class='glyphicon glyphicon-ok'></span> Checkout</a></li>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <a href="<?php echo base_url(); ?>member_account" ><span class='glyphicon glyphicon-edit'></span> My Account</a>
                        </li>
                        <li class="carttotals">

                            <a href="<?php echo base_url() ?>checkout" ><span class='glyphicon glyphicon-shopping-cart'></span> My Bag: <?php echo $this->cart->total_items(); ?> item(s)</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--set menu navbar-->
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="wrapper-block">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="<?php echo base_url(); ?>" class="brand" style="text-decoration: none;color: #fff; position: relative;">
                                       <?= $this->modelsetting->getdetailsetting(1)->title;?>
                                    </a>
                                </div>
                                <div class="col-sm-7">
                                    <nav role='main-nav'>
                                        <ul class='main-nav'>
                                            <?php
//                                            load data menu From modelmenu
                                            $querymenu = $this->modelmenu->getListmenu('');
                                            foreach ($querymenu->result()as $rowmenuparent) {
                                                ?>
                                                <?php
                                                $checkchild = @$this->modelmenu->getcheckmenuparent($rowmenuparent->idmenu)->idmenu;
//                                                check have a childs?
                                                if (!empty($checkchild)) {
                                                    $querymenuchild = $this->modelmenu->getListmenu($rowmenuparent->idmenu);
                                                    ?>
                                                    <li class="has-dropdown"><a href="<?php echo $rowmenuparent->url ?>" ><?php echo $rowmenuparent->title ?> 
                                                            <b class="caret"></b></a>
                                                        <ul>
                                                            <?php foreach ($querymenuchild->result()as $rowmenuchild) { ?>
                                                                <li><a href="<?php echo $rowmenuchild->url ?>"><?php echo $rowmenuchild->title ?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } else { ?>
                                                    <li ><a href="<?php echo $rowmenuparent->url ?>" ><?php echo $rowmenuparent->title ?></a>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>                                           

                                        </ul>
                                    </nav>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group search-block">
                                        <!--post to search product-->
                                        <form method="get" action="<?php echo base_url(); ?>search" class="input-group search-block">
                                            <input type="text" class="form-control" id="serachproduct" name="serachproduct" placeholder="Search Product here" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit"><span class='glyphicon glyphicon-search'></span></button>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
