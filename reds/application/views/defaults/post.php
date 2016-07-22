<link rel="stylesheet" href="<?php echo $path; ?>css/set1.css" />
<link rel="stylesheet" href="<?php echo $path; ?>css/normalize.css" />
<script src="https://npmcdn.com/masonry-layout@4.1/dist/masonry.pkgd.js"></script>
<script src="https://npmcdn.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
<section id="category-home">
    <div class="container">
        
        <div class="row">
            <div class="presentation-boxes">
                <?php 
                $queryProductHome=$this->modelpost->getListDataPost(" order by id_post");
                foreach ($queryProductHome->result()as $rowproducthome) {
                ?>
                <div class="grid-item grid-sizer col-sm-6">
                   
                        <figure class="effect-romeo">
                            
                            <img src="<?php echo $rowproducthome->images; ?>" alt="<?php echo $rowproducthome->title; ?>" />
                            
                            <figcaption>
                                <div class="content">
                                    <h2 style="font-size: 200%; color: rgb(240, 135, 124);"><a href="<?php echo base_url(); ?>detailpost/<?= $rowproducthome->url;?>"><?php echo $rowproducthome->title; ?></a></h2>
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
    $('.presentation-boxes').masonry({
  // options...
   itemSelector: '.grid-item', // use a separate class for itemSelector, other than .col-
  columnWidth: '.grid-sizer',
//  gutter: 10,
  percentPosition: true,
});
</script>
<style>
    .presentation-boxes{margin-top:25px;}
    .grid-item {
  margin-bottom: 10px;
}

</style>  