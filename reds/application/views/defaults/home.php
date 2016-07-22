<link rel="stylesheet" href="<?php echo $path; ?>css/set1.css" />
<link rel="stylesheet" href="<?php echo $path; ?>css/normalize.css" />
<section class="homepage-slider typeOne hidden-xs">

    <div class="row">
        <div class="col-lg-12">
            <div class="sliderTypeOne flexslider">
                <div class="slider-controls sliderTypeOne-controls">
                    <button class="next"><i class="glyphicon glyphicon-chevron-left"></i></button>
                    <button class="prev"><i class="glyphicon glyphicon-chevron-right"></i></button>
                </div>
                <ul class="slides">
                    <?php
//                        load data Slide from Slider
                    $querySlider = $this->modelslider->getListSlider("order by id_slider DESC");
                    foreach ($querySlider->result()as $rowtableSlider) {
                        ?>
                        <li style="background-image: url('<?= $rowtableSlider->images; ?>');">
                            <div class="slide-content all-white">
                                <div class="inner">
                                    <div class="clearfix"></div>
                                    <div class="small-separator"></div>
                                    <div class="clearfix"></div>
                                    <p><?= $rowtableSlider->description; ?></p>
                                    <div class="clearfix"></div>
                                    <a href="<?= $rowtableSlider->links; ?>" class='btn btn-default btn-lg custom-button'>Take a Look</a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id='main'>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="homepage-products">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active"><a href="#new-arrivals" data-toggle="tab">New Arrivals</a></li>

                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="new-arrivals">

                            <div class="new-arrivals-slider">
                                <ul class="slides">
                                    <?php
//                                    load data product and show 4 new product
                                    $queryProduct = $this->modelproduct->getListProduct(" order by id_product DESC LIMIT 0,4");
                                    ?>
                                    <li>
                                        <div class="row">
                                            <?php foreach ($queryProduct->result()as $rowtableProduct) { ?>
                                                <article class="category-article category-grid col-sm-3">
                                                    <figure>
                                                        <img src="<?= $rowtableProduct->main_images; ?>" alt="<?= $rowtableProduct->title; ?>" />
                                                        <div class="figure-overlay">


                                                            <button class="btn btn-default custom-button" onclick="addtocart('<?= $rowtableProduct->url; ?>');">Add to Bag</button>

                                                        </div>
                                                    </figure>

                                                    <div class="text">
                                                        <h2><a href="<?= base_url() . 'detailproduct/' . $rowtableProduct->url; ?>"><?= $rowtableProduct->title; ?></a></h2>
                                                        <div class="price">
                                                            <span class="new-price">Rp. <?= number_format($this->modelproduct->getRowDataProduct_Detail("WHERE id_product='$rowtableProduct->id_product' order by id_product_detail DESC limit 0,1")->prices); ?></span>
                                                        </div>
                                                    </div>
                                                </article>
                                            <?php } ?>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="separator middle"></div>
        </div>
    </div>
</section>
<section id="main">
    <div class="container">
        <div class="col-sm-12">
            <div class="head-title">
                <h1>Category</h1>
            </div>
            <div class="row">
                <div class="presentation-boxes" id='list'>
                    <?php
//                    load data category where news last get 4
                    $queryCategoryHome = $this->modelcategory->getListcategorybystatement(" order by category_id DESC LIMIT 0,4");
                    foreach ($queryCategoryHome->result()as $rowcatgoryhome) {
                        ?>
                        <div class="col-sm-6 category-list">

                            <figure class="effect-romeo">
                                <img src="<?php echo $rowcatgoryhome->category_images; ?>" alt="<?php echo $rowcatgoryhome->category_name; ?>" />
                                <figcaption>
                                    <div class="content">
                                        <h2 style="font-size: 200%; color: rgb(240, 135, 124);"><a href="<?php echo base_url(); ?>detailcategory/<?= $rowcatgoryhome->category_url; ?>"><?php echo $rowcatgoryhome->category_name; ?></a></h2>
                                    </div>
                                </figcaption>
                            </figure>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="separator middle"></div>
        </div>
    </div>
</section>
<script type='text/javascript' src='<?php echo $path ?>js/masonry.js'></script>
<script>
//    init javascript for slider 
                                                                $('.sliderTypeOne').flexslider({
                                                                    'controlNav': false,
                                                                    'directionNav': false,
                                                                    "touch": true,
                                                                    "animation": "slide",
                                                                    "animationLoop": true,
                                                                    "slideshow": true
                                                                });
                                                                createSliderButton('.sliderTypeOne', '.sliderTypeOne-controls .next', 'next');
                                                                createSliderButton('.sliderTypeOne', '.sliderTypeOne-controls .prev', 'prev');
//init javascrit for masonry colum width
                                                                $(window).load(function() {
                                                                    var columns = 4, setcolumns = function() {
                                                                        columns = $(window).width() > 700 ? 4 : $(window).width() > 480 ? 2 : 1
                                                                    };
                                                                    setcolumns();
                                                                    $(window).resize(setcolumns);
                                                                    $('#list').masonry({itemselector: '.category-list', gutterwidth: 66, isfitwidth: true, isanimated: true, columnwidth: function(containerwidth) {
                                                                            return containerwidth / columns;
                                                                        }});
                                                                });

</script>
<style>
    figure {
        margin: 15px;
    }
    figure.effect-romeo h2{text-align: center;}
    figure.effect-romeo h2 a{text-decoration: none;color:coral;}
    .head-title h1{text-align: center;text-transform: uppercase;font-family: "Source Code Pro", Arial, sans-serif;}
</style>
