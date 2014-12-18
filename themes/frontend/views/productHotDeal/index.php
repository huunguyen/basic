<script type="text/javascript">
    var h = 12;
    var i = 0;
    var s = 0;
    function GetCount(ddate, iid) {
        amount = ddate //calc milliseconds between dates
        hours = 0;
        mins = 0;
        secs = 0;
        day = 0;
        out = "";
        day = Math.floor(amount / 86400)
        amount = amount % 86400;
        hours = Math.floor(amount / 3600);
        amount = amount % 3600;
        mins = Math.floor(amount / 60);
        amount = amount % 60;
        secs = Math.floor(amount);
        out += "<strong>" + (day <= 9 ? '0' : '') + day + "</strong> Ngày ";
        out += "<strong>" + (hours <= 9 ? '0' : '') + hours + ": ";
        out += "" + (mins <= 9 ? '0' : '') + mins + ": ";
        out += "" + (secs <= 9 ? '0' : '') + secs + "</strong>" + ", ";
        out = out.substr(0, out.length - 2);
        document.getElementById(iid).innerHTML = out;
        setTimeout(function() {
            GetCount(ddate - 1, iid)
        }, 1000);
    }
    
    jQuery("body").delegate("#page_hotdeal a", "click", function() {
        $("#attribute0").css("display", "block");
        var qUrl = jQuery(this).attr("href");
        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxhotdeal').html($(data).find('#ajaxhotdeal').html());
            jQuery('#ajaxPagehot').html($(data).find('#ajaxPagehot').html());
            $("#attribute0").css("display", "none");
        });

        return false;
    });
</script>
<?php $this->renderpartial("soft",array('model1'=>$model1,'model2'=>$model2,'model3'=>$model3));?>
<div class="products-list clear-fix" id="ajaxhotdeal">
    <?php foreach ($data_hot_deal as $value): ?>
        <?php
        $price = "";
        $hotdeal = $value->productHotDeals[0];
        if (isset($hotdeal->idProductAttribute)) {
            $price = $hotdeal->idProductAttribute->price;
            if ($hotdeal->idProductAttribute->price != 0) {
                $ti_le = (($hotdeal->idProductAttribute->price - $hotdeal->price) / $hotdeal->idProductAttribute->price) * 100;
            } else {
                $ti_le = 0;
            }
        } else {
            if ($hotdeal->idProduct->price != 0) {
                $price = $hotdeal->idProduct->price;
                $ti_le = (($hotdeal->idProduct->price - $hotdeal->price) / $hotdeal->idProduct->price) * 100;
            } else {
                $ti_le = 0;
            }
        }
        $path = ImageHelper::FindImageByPk(Product::TYPE, $value->id_product);
        if ($path != NULL) {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($path, Product::TYPE, '240x180'));
        } else {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
        }
        ?>
        <ul>
            <li>
                <div class="section" id="deal-1580">
                    <h3 class="title"><a href="javascript:void(0)"><?= StringHelper::Limit($value->name, 32); ?> </a></h3>
                    <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>" class="thumb">
                        <img class="lazy" src="<?= $image ?>" data-original="<?= $image ?>" height="173px" width="230px"/>
                        <span class="discount-layer"><strong>-<?php echo $ti_le; ?>%</strong></span></a>
                    <div class="box clear-fix">
                        <ul>
                            <li class="item-1" style="height: 48px">
                                <div class="price">
                                    <p><strong><?= number_format($hotdeal->price); ?>đ</strong></p>
                                    <p class="old-price">Giá gốc: <del><?= number_format($price); ?>đ</del></p></div>
                                <div class="btn-buy"><a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>">Mua</a></div>
                            </li>
                            <li class="item-2">Thời gian còn lại <span class="type" id="<?= $value->id_product; ?>">        
                                </span>

                                <?php
                                $id = $value->id_product;
                                $date = ProductHelper::getDateTime($hotdeal->idSpecificPriceRule->to);
                                echo "<script>
                                         GetCount($date,$id);
                                        </script>";
                                ?>
                            </li>
                            <li class="item-3">Giảm<span class="type"><strong><?php echo $ti_le; ?>%</strong></span></li>
                            <li class="item-4">Đã mua <span class="type"><strong><?php echo ProductHelper::sumby($value->id_product); ?></strong></span></li>
                        </ul>
                    </div><div class="clear"></div>	
                    <p class="text" style="height: 50px"><?= StringHelper::Limit($value->description_short, 95); ?> <a class="more" title="" href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>">Chi tiết</a></p>
                </div>
            </li>
        </ul>
    <?php endforeach; ?>
</div>

<div class="clear">&nbsp;</div>
<div style="text-align:center;margin-bottom: 10px;float: left;width: 100%">
    <div id='ajaxPagehot' style="margin: auto;text-align: center;" align="center">
        <?php
        $this->widget('CLinkPager', array(
            'Pages' => $pages,
            'maxButtonCount' => 8,
            'prevPageLabel' => '<<',
            'nextPageLabel' => '>>',
            'firstPageLabel' => '',
            'lastPageLabel' => '',
            'header' => '',
            'cssFile' => Yii::app()->request->baseUrl . '/css/pager.css',
            'htmlOptions' => array(
                'id' => 'page_hotdeal',
            ),
        ));
        ?>
    </div>
</div>
