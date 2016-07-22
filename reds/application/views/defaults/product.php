<section id='main'>
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="filter-bar">
                    <div class="half">

                        <div class="sort-wrap pull-left">
                            <label for="sort-by">Sort by: </label>
                            <select name="sort-by" id="sort-by" class="chosen-select" onchange="getLoadCategoryProduct('0');">
                                <option value="default" />Default
                                <option value="asc" />Price Asc
                                <option value="desc" />Price Desc
                                <option value="title" />Name
                            </select>
                        </div>
                    </div>
                    <div class="half" >
                        <div class="sort-wrap pull-left" >
                            <label for="show-no">Sort by: </label>
                            <select name="show-no" id="show-no"  onchange="getLoadCategoryProduct('0');">
                              
                                <option value="8" />8
                                <option value="16" />16
                                <option value="24" />24
                                <option value="32" />32
                            </select>
                        </div>
                    </div>

                    <div class="half">
                        <div class="range-wrap custom-range pull-left">
                            <label for="range-price">Price filter: </label>
                            <input id="range-price" type="text" class="col-sm-8 col-md-7 col-xs-6 range-slider" value="" data-slider-value="[10,500]" />
                        </div>
                    </div>
                </div>
                <div class="main-bottom">
                    <div class="section-title" style="width: 50%;">
                        <h1>products</h1>
                    </div>
                    <div class="half text-right" id="category-products-pagin">

                    </div>
                </div>
                <div class="row" id="category-products">
                   
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
                </div>
            </aside>
        </div>
    </div>
</section>
<script>
                                function getLoadCategoryProduct(pages) {
                                    $(document).ready(function() {
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>home/getLoadCategoryProduct",
                                            data: "pages=" + pages + "&sortby=" + $("#sort-by").val() + "&showno=" + $("#show-no").val() + "&rangeprice=" + $("#range-price").val() + "&idcategory=0",
                                            type: 'POST',
                                            dataType: 'json',
                                            beforeSend: function() {
                                                $('#home').append('<div id="pageload"></div>');
                                            },
                                            complete: function() {
                                                $('#pageload').remove();
                                            },
                                            success: function(json) {
                                                $("#category-products-pagin").html(json.contentPagin);
                                                $("#category-products").html(json.contentProduct);
                                            },
                                            error: function(xmlHttpRequest, textStatus, errorThrown) {
                                                start = xmlHttpRequest.responseText.search("<title>") + 7;
                                                end = xmlHttpRequest.responseText.search("</title>");
                                                errorMsg = xmlHttpRequest.responseText;
                                                if (start > 0 && end > 0)
                                                    alert("Undifine " + errorMsg + xmlHttpRequest.responseText + "  [" + xmlHttpRequest.responseText.substring(start, end) + "]");
                                                else
                                                    alert("Error  " + errorMsg + xmlHttpRequest.responseText);
                                            }
                                        });
                                    });
                                }

                                function initialSlidePrice() {
                                    $(document).ready(function() {
                                        var index = 0;
                                        $('.range-slider').slider({
                                            selection: "before",
                                            orientation: "horizontal",
                                            min: 10,
                                            max: 500,
                                            step: 10,
                                            tooltip: "hide",
                                            handle: "square",
                                            formater: function(val) {
                                                var value = $('<b></b>').text("Rp" + val + "000.00");
                                                if (index == 0) {
                                                    $('.slider-handle').first().html(value);
                                                    index++;
                                                } else {
                                                    $('.slider-handle').last().html(value);
                                                }
                                            }
                                        }).on('slide', function(ev) {
                                            $('.slider-handle').each(function(index) {
                                                var value = $('<b></b>').text("Rp" + ev.value[index] + "000.00");
                                                $(this).html(value);
                                                
                                            });
                                            getLoadCategoryProduct('0');
                                        });
                                    });
                                }
                                initialSlidePrice();
                                getLoadCategoryProduct('0');
</script>   