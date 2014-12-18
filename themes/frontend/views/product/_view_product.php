<div id="content_ct" style="padding-left: 5px">
    <ul>
        <li class="blu" style="color: #333"><?php echo $model->name; ?></li>
        <div id="price">
            <?php $this->renderpartial('_viewPrice', array('price' => $price, 'price_hot' => $price_hot, 'total' => $total,'model'=>$model)); ?>
        </div>
        <li>
            <?php if($groups!=null): ?>
            <div class="colors_selector" style="width: 100%">
                <div id="attributes" style="width: 95%;background-color:#F5F5F5;border-top: 1px dotted #DDD;padding: 5px 10px;margin-top: 6px;height: auto;float: left">
                    <?php $array=array();?>
                    <?php $this->renderpartial('_attribute', array('array'=>$array,'model' => $model, 'groups' => $groups, 'attributes' => $attributes)); ?>
                </div>
            </div>
            <?php endif;?>
        </li>
        <li>
            Thông tin<br />
            <?php echo $model->description_short; ?>
        </li>
        <li id="rate">
            <?php $this->renderpartial("_viewRate", array('total_percent' => $total_percent, 'id_pro' => $model->id_product, 'total_rate' => $total_rate)); ?>
        </li>
        <li>
            <a style="float: left" href="<?= Yii::app()->createUrl('supplier/view', array('id' => $supp->id_supplier)) ?>">
                <?php
                $img = ImageHelper::FindImageByPk(Supplier::TYPE, $supp->id_supplier);
                if ($img != NULL) {
                    $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Supplier::TYPE, "240x180"));
                } else {
                    $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                }
                ?>
                <img style="border:1px #CCCCCC solid; margin:3px;" src="<?= $image ?>" border="0" width="151px" height="65px"/>
            </a> 
            <?php
            if ($total> 0) {
                $stye = "display:block";
                $stye1 = "display:none";
            } else {
                $stye1 = "display:block";
                $stye = "display:none";
            }
            ?>
            <a id="addcart" onclick="addcart_product(this)" style="<?= $stye ?>;margin-left: 40px;margin-top: 15px;float:left;width:214px;height: 42px" href="javascript:void(0)"><img src="<?= Yii::app()->baseUrl ?>/images/addcart.png"></a>
            <a id="buttonaddcart" style="<?= $stye1 ?>;margin-left: 40px;margin-top: 15px;float:left;width:175px;height: 42px;background:url(<?= Yii::app()->baseUrl ?>/images/call.png)" href="javascript:void(0)">
                <div style="width: 125px;text-align: center;color: #797979;font-size: 70%;margin-top: 4px;">Đặt hàng qua điện thoại</div>
                <div style="width: 125px;text-align: center;color:#C50D0B;font-weight: bold;margin-top: -4px"><?= Yii::app()->params['phone']; ?></div>
            </a>
        </li>				

    </ul>
</div>