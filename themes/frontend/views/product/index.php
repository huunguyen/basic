<?php $this->pageTitle="Bán sĩ, lẻ online tất cả các loại hàng"; ?>
<script>
    jQuery("body").delegate("#pagepro a", "click", function() {
        $("#attribute0").css("display", "block");
        var qUrl = jQuery(this).attr("href");
        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRowpro').html($(data).find('#ajaxRowpro').html());
            jQuery('#ajaxPagepro').html($(data).find('#ajaxPagepro').html());
            $("#attribute0").css("display", "none");
        });

        return false;
    });
</script>
<?php $this->renderpartial("soft",array('model1'=>$model1,'model2'=>$model2,'model3'=>$model3));?>
<div id="title"> SẢN PHẨM MỚI </div>
<div id = 'ajaxRowpro'>
    <?php $i = 1; ?>
    <?php foreach ($data as $value): ?>

        <?php
        $data = ProductHelper::sumproduct($value);
        $att = $data['attribute'];
        $total = $data['total'];
        $img = ImageHelper::FindImageByPk(Product::TYPE, $value->id_product);
        if ($img != NULL) {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
        } else {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
        }
        if ($i % 5 == 0) {
            ?>
            <div id="products_r">
                <div id="content2_k">
                    <ul> <li><a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>"><img src="<?= $image ?>" /></a></li></ul>
                    <ul style="padding-left:10px;">
                        <li><h1><?php echo StringHelper::Limit($value->name, 15); ?></h1></li>
                        <li>Name: <?php echo StringHelper::Limit($value->name, 15); ?></li>
                        <li><b style="font-weight: bold">Lượt mua</b>:<i><?php echo ProductHelper::sumby($value->id_product); ?></i></li>
                        <li><b style="font-weight: bold">Loại</b>: <i><?=Lookup::item("ConditionProduct", $value->condition)?></i> </li>
                        <li><strong>Giá lẻ:</strong> <span class="style3"><?=number_format($value->unit_price_ratio); ?> vnđ</span></li>
                        <li><strong>Giá sĩ:</strong>  <span class="style3"><?=number_format($value->wholesale_price); ?> vnđ </span></li>
                    </ul>
                    <ul>  
                        <li style="float:left;">
                            <?php if ($total > 0) { ?>
                                <a href="javascript:void(0)" onclick="addcart(<?= $att ?>,<?= $value->id_product ?>)" class="button green">Giỏ hàng</a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" class="button green" style="color: red">Liên Hệ</a>
                            <?php } ?>
                        </li>
                        <li style="float:right;"> <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>" class="button green">Xem ngay</a></a></li>
                    </ul>
                </div>        	
            </div>
        <?php } else { ?>
    <div id="content2_l" style="margin-right:25px">
                <div id="content2_k">
                    <ul> <li><a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>"><img src="<?= $image ?>" alt="<?php echo $value->meta_title; ?>" /></a></li></ul>
                    <ul style="padding-left:10px;">
                        <li><h1><?php echo StringHelper::Limit($value->name, 15); ?></h1></li>
                        <li>Name: <?php echo StringHelper::Limit($value->name, 15); ?></li>
                        <li><b style="font-weight: bold">Lượt mua</b>:<i><?php echo ProductHelper::sumby($value->id_product); ?></i></li>
                        <li><b style="font-weight: bold">Loại</b>: <i><?=Lookup::item("ConditionProduct", $value->condition)?></i></li>
                        <li><strong>Giá lẻ:</strong> <span class="style3"><?=number_format($value->unit_price_ratio); ?> vnđ</span></li>
                        <li><strong>Giá sĩ:</strong>  <span class="style3"><?=number_format($value->wholesale_price); ?> vnđ </span></li>
                    </ul>
                    <ul>  
                        <li style="float:left;"> 
                            <?php if ($total > 0) { ?>
                                <a href="javascript:void(0)" onclick="addcart(<?= $att ?>,<?= $value->id_product ?>)" class="button green">Giỏ hàng</a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" class="button green" style="color: red">Liên Hệ</a>
                            <?php } ?>
                        </li>
                        <li style="float:right;"> <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>" class="button green">Xem ngay</a></a></li>
                    </ul>
                </div>        	
            </div>
        <?php } $i++; ?>
    <?php endforeach; ?>
</div>
<div style="text-align:center;margin-bottom: 10px;float: left;width: 100%">
    <div id='ajaxPagepro' style="margin: auto;text-align: center;" align="center">
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
                'id' => 'pagepro',
            ),
        ));
        ?>
    </div>
</div>
<!-----------------------------------------------------lap lai---------------------------------------------------->
<div>&nbsp;</div>

<!-----------------------------------------------------lap lai---------------------------------------------------->
<?php
if ($data_hot != "") {
    $this->renderpartial("product_hot", array("data" => $data_hot, "page" => $pages_hot));
}
?>
