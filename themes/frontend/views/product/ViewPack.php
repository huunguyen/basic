<div id="title"><?php echo $model->name; ?> </div>
<div style="padding-left:10px" id="description_short">
    <?php echo $model->description_short; ?>
</div>
<div style="padding-left:10px;display:none;" id="description">
    <?php echo $model->description; ?>
</div>
<div>
    <ul  id="left2_more1" style="float:right; padding-right:20px; padding-bottom:10px;">
        <li> <a onclick="show_content()" href="javascript:return false;">Xem thêm></a></li>
    </ul>
</div>
<div id="title"> SẢN PHẨM TRONG GÓI</div>
<div id = 'ajaxRowsup'>
    <?php 
    $i = 1;
   foreach ($data as $value):
       $product=  Product::model()->findByPk($value->id_product);
        $img = ImageHelper::FindImageByPk(Product::TYPE, $value->id_product);
        if ($img != NULL) {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR .Product::TYPE. DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img,Product::TYPE, "240x180"));
        } else {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
        }
        ?>
        <?php if ($i % 4 == 0) { ?>
            <div id="products_r">
                <div id="content2_k">
                    <ul> <li><img src="<?= $image ?>" /></li></ul>
                    <ul style="padding-left:10px;">
                        <li><h1><?php echo StringHelper::Limit($product->name,25); ?></h1></li>
                        <li>Name: <?php echo StringHelper::Limit($product->name,25); ?></li>
                        <li><b style="font-weight: bold">Lượt mua</b>:<i><?php echo ProductHelper::sumby($value->id_product); ?></i></li>
                        <li><b style="font-weight: bold">Loại</b>: <i><?=Lookup::item("ConditionProduct", $product->condition)?></i> </li>
                        <li><strong>Giá lẻ:</strong> <span class="style3"><?php echo $product->unit_price_ratio; ?> vnđ</span></li>
                        <li><strong>Giá sĩ:</strong>  <span class="style3"><?php echo $product->wholesale_price; ?> vnđ </span></li>
                    </ul>
                    <ul>  
                        <li style="float:left;"> <a href="<?= Yii::app()->createUrl('product/showCart/') ?>" class="button green">Giỏ hàng</a></li>
                        <li style="float:right;"> <a href="<?= Yii::app()->createUrl('Product/View', array('id' => $value->id_product)) ?>" class="button green">Xem ngay</a></a></li>
                    </ul>
                </div>        	
            </div>
        <?php } else { ?>
            <div id="content2_l">
                <div id="content2_k">
                    <ul> <li><img src="<?= $image ?>" /></li></ul>
                    <ul style="padding-left:10px;">
                        <li><h1><?php echo StringHelper::Limit($product->name,25); ?></h1></li>
                        <li>Name: <?php echo StringHelper::Limit($product->name,25); ?></li>
                        <li><b style="font-weight: bold">Lượt mua</b>:<i><?php echo ProductHelper::sumby($value->id_product); ?></i></li>
                        <li><b style="font-weight: bold">Loại</b>: <i><?=Lookup::item("ConditionProduct", $product->condition)?></i> </li>
                        <li><strong>Giá lẻ:</strong> <span class="style3"><?php echo $product->unit_price_ratio; ?> vnđ</span></li>
                        <li><strong>Giá sĩ:</strong>  <span class="style3"><?php echo $product->wholesale_price; ?> vnđ </span></li>
                    </ul>
                    <ul>  
                        <li style="float:left;"> <a href="<?= Yii::app()->createUrl('product/showCart/') ?>" class="button green">Giỏ hàng</a></li>
                        <li style="float:right;"> <a href="<?= Yii::app()->createUrl('Product/View', array('id' => $value->id_product)) ?>" class="button green">Xem ngay</a></a></li>
                    </ul>
                </div>        	
            </div>
        <?php }$i++; ?>
    <?php endforeach; ?>
</div>
<script>
    function show_content() {
        $("#left2_more1").hide();
        $("#description_short").hide();
        $("#description").show();
    }
</script>