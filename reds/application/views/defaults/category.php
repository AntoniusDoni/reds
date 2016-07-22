<link rel="stylesheet" href="<?php echo $path; ?>css/set1.css" />
<link rel="stylesheet" href="<?php echo $path; ?>css/normalize.css" />
<script type='text/javascript' src='<?php echo $path ?>js/masonry.js'></script>
<section id="category-home">
    <div class="container">

        <div class="row">
            <div class="presentation-boxes">
                <?php
//                load category and view
                $queryCategoryHome = $this->modelcategory->getListcategorybystatement(" order by category_id");
                foreach ($queryCategoryHome->result()as $rowcatgoryhome) {
                    ?>
                    <div class="grid-item grid-sizer col-sm-6">

                        <figure class="effect-romeo">
                            <img src="<?php echo $rowcatgoryhome->category_images; ?>" alt="<?php echo $rowcatgoryhome->category_name; ?>" />
                            <figcaption>
                                <div class="content">
                                    <h2 style="font-size: 200%; color:coral;"><a style="color:coral;text-decoration:none;" href="<?php echo base_url(); ?>detailcategory/<?= $rowcatgoryhome->category_url; ?>"><?php echo $rowcatgoryhome->category_name; ?></a></h2>
                                </div>
                            </figcaption>
                        </figure>

                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="separator middle"></div>
        </div>
    </div>
</section>

<script>
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
    .presentation-boxes{margin-top:25px;}
    .grid-item {
        margin-bottom: 10px;
    }

</style>  