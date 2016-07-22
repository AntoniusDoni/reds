<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h1><?= @$this->modelpost->getRowDataPost("WHERE id_post='$idpost'")->title; ?></h1>
            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb text-right">
                    <li><a href="<?= base_url(); ?>">Home</a></li>
                    <li class="active"><?= @$this->modelpost->getRowDataPost("WHERE id_post='$idpost'")->title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section id='main' class="blog-page">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <article class="blog-article">
                    <h2><a href="#"><?= @$this->modelpost->getRowDataPost("WHERE id_post='$idpost'")->title; ?></a></h2>
                    <?php
                    $image = @$this->modelpost->getRowDataPost("WHERE id_post='$idpost'")->images;
                    if ($image != '') {
                        ?>
                        <figure class="effect-romeo">
                            <img src="<?php echo $image; ?>" alt="<?= @$this->modelpost->getRowDataPost("WHERE id_post='$idpost'")->title; ?>" />
                        </figure>
                        <?php
                    }
                    ?>
                    <div class="text">
                        <div class="left-info">
                            <span class="bold-text"><?= @$this->modelpost->getRowDataPostCustome("WHERE id_post='$idpost'", "DATE_FORMAT(dates_post,'%d %M %Y') as dates_post")->dates_post; ?></span>
                            <span class="bold-text"><a href="#"><?= @$this->modelpost->getRowDataPosCommenttCustome("WHERE id_post='$idpost' and is_publish='1'", "COUNT(id_post_comment)as count_comment ")->count_comment; ?> Comment(s)</a></span>
                            <div class="info-separator">
                                <div class="separator-icon photo"></div>
                            </div>
                            <span class="small-text">by <a href="#"><?= @$this->modelsetting->getdetailsetting(1)->title; ?></a></span>

                        </div>
                        <div class="right">
                            <div class="text-editor">
                                <?= @$this->modelpost->getRowDataPost_Desciption("WHERE id_post='$idpost' and lang='ID'")->description; ?>
                            </div>
                            <div class="share-line">
                                <span class="title">Share: </span>
                                <div class="share-widget">
                                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-538e859c24991359" async="async"></script>
                                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                    <div class="addthis_sharing_toolbox"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="blog-comments main-widget">
                    <div class="widget-title">
                        <h2>Comments (<?= @$this->modelpost->getRowDataPosCommenttCustome("WHERE id_post='$idpost' and is_publish='1'", "COUNT(id_post_comment)as count_comment ")->count_comment; ?>)</h2>
                    </div>
                    <div class="widget-content">
                        <ul class='comment-wrap'>
                            <?= $this->modelpost->getListComment($idpost, 0, 'ASC'); ?>
                        </ul>
                    </div>
                </div>
                <div></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="contact-form" id="contact-form">
                            <input type="hidden" id="id_parent_comment" name="id_parent_comment" value="0">
                            <h2>Leave a comment</h2>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                                <input type="text" class="form-control" placeholder="Enter Your Subject" id="subjects" name="subjects"/>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" placeholder="Enter Your Name*" id="usernamesComment" name="usernamesComment"/>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input type="email" class="form-control" placeholder="Enter Your E-mail*" id="emails" name="emails"/>
                            </div>


                            <textarea class="form-control" rows="5" placeholder="Enter your message" style="margin: 0px;" id="comments" name="comments"></textarea>

                            <input type="submit" class='btn btn-default custom-button' value="Post Comment" onclick="sendComment();" />
                        </div>
                    </div>
                </div>
            </div>
            <aside class="col-sm-4">
                <div class="widget">
                    <div class="widget-title">
                        <h2>Categories</h2>
                    </div>
                    <div class="widget-content">
                        <div class="accordion">
                            <div class="panel-group" id="accordion">
                                <?php
                                $queryParentCategory = $this->modelcategory->getListcategorybystatement("WHERE category_parent='0' order by category_id DESC limit 0,10");
                                foreach ($queryParentCategory->result()as $rowParent) {
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#<?= $rowParent->category_name; ?>">
                                                    <?= $rowParent->category_name; ?>
                                                </a>
                                            </h4>
                                        </div>
                                        <?php
                                        $checkchildCatgory = @$this->modelcategory->getdetailcategorybystatement("WHERE category_parent='$rowParent->category_id' order by category_id DESC limit 0,10")->category_id;
                                        if (!empty($checkchildCatgory)) {
                                            ?>
                                            <div id="<?= $rowParent->category_name; ?>" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <ul>
                                                        <?php
                                                        $queryChildCatgorylv1 = $this->modelcategory->getListcategorybystatement("WHERE category_parent='$rowParent->category_id' order by category_id DESC limit 0,10");
                                                        foreach ($queryChildCatgorylv1->result()as $rowChilds) {
                                                            ?>

                                                            <li><a href="#"><?= $rowChilds->category_name; ?></a>

                                                            </li>



                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!--Latest Post-->
                    <div class="widget">
                        <div class="widget-title">
                            <h2>Latest Post</h2>
                            <div class="slider-controls latest-post-controls">
                                <button class="next"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                <button class="prev"><i class="glyphicon glyphicon-chevron-right"></i></button>
                            </div>
                        </div>
                        <div class="widget-content">
                            <div class="latest-post-slider">
                                <ul class="slides">
                                    <?php
                                    $queryLatePost = $this->modelpost->getListDataPost("WHERE id_post!='$idpost' order by id_post DESC LIMIT 0,10");
                                    foreach ($queryLatePost->result()as $rowLatePost) {
                                        ?>
                                        <li>
                                            <div class="latest-post">
                                                <?php if ($rowLatePost->images != '') { ?>
                                                    <figure>
                                                        <img src="<?= $rowLatePost->images; ?>" alt="<?= $rowLatePost->title; ?>" />
                                                    </figure>
                                                <?php } ?>
                                                <h2><a href="<?= base_url(); ?>detailpost/<?= $rowLatePost->url; ?>"><?= $rowLatePost->title; ?></a></h2>
                                                <div class="excerpt">

                                                    <?= @$this->modelpost->getRowDataPostDesciptCustome("WHERE id_post='$rowLatePost->id_post' and lang='ID'", "SUBSTRING_INDEX(description,'</p>',1) as readmore")->readmore; ?>

                                                </div>
                                                <a href="#" class="read-more">Read More &gt;</a>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
<script>
                                function getParentComment(parent_comment) {
                                    $("#id_parent_comment").val(parent_comment);
                                }
                                function sendComment() {
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo base_url(); ?>home/sendComment',
                                        data: "idpost=<?= $idpost ?>" + '&id_parent_comment=' + $("#id_parent_comment").val() + "&subjects=" + $("#subjects").val() + "&comments=" + $("#comments").val() + "&emails=" + $("#emails").val() + "&usernamesComment=" + $("#usernamesComment").val()
                                    }).done(function(data) {
                                        $("#after-loading-success-message").css('display', 'block');
                                        $("#after-loading-success-message").html('<div class ="background-overlay"></div>\n\
        <p id="success-message-container" class="loader" >Message Sends	<br/><br/>\n\
        <br/><br/>\n\
        <button type="button" name="continue_shopping" id="continue_shopping" class="button btn-cart" >\n\
        <span>\n\
                                Sucsess		</span></button>');
                                        $("#continue_shopping").click(function() {
                                            $('#after-loading-success-message').fadeOut();
                                        });
//            document.location.reload();
                                    });
                                }

                                $('.latest-post-slider').flexslider({
                                    'controlNav': false,
                                    'directionNav': false,
                                    "touch": true,
                                    "animation": "slide",
                                    "animationLoop": true,
                                    "slideshow": false
                                });
                                createSliderButton('.latest-post-slider', '.latest-post-controls .next', 'next');
                                createSliderButton('.latest-post-slider', '.latest-post-controls .prev', 'prev');
</script>    