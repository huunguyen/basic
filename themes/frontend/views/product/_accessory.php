<div style="margin-left:10px; margin-bottom:20px;">
    <div id="title">KHUYẾN KÍCH MUA THÊM</div>


    <div id="slider1">
        <a class="buttons prev disable" href="javascript:void(0)">&lt;</a>
        <div class="viewport" style="width: 550px;" >
            <ul style="width: 640px; left: 0px;" class="overview">
                <?php foreach ($data as $value): ?>
                    <?php
                    $img = ImageHelper::FindImageByPk(Product::TYPE, $value->id_product);
                    if ($img != NULL) {
                        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR .Product::TYPE. DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img,Product::TYPE, "240x180"));
                    } else {
                        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                    }
                    $rate = Rate::model()->findByPk($value->id_product);
                    if (!empty($rate)) {
                        $total_rate = $rate->total_rate;
                        $avg = $rate->level / $total_rate;
                        $total_percent = ($avg / $rate->level_max) * 100;
                    } else {
                        $total_percent = 0;
                    }
                    ?>
                    <li>
                        <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>">
                            <img src="<?= $image ?>" alt="<?php echo StringHelper::Limit($value->name,15); ?>" width="131px" height="125px">
                        </a> 
                        <div class="textslider1" style="text-overflow:ellipsis;"> 
                            <a href="<?= Yii::app()->createUrl('product/view', array('id' => $value->id_product)) ?>"><?php echo $value->name; ?></a>
                        </div>
                        <span > Giá</span>:
                        <span class="sm_old_price"><?= number_format($value->price); ?> vnđ </span>
                        <span class="rating-static rating-<?php echo $total_percent; ?>"></span>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <a class="buttons next" href="javascript:void(0)">&gt;</a>

        <script type="text/javascript">
            $(document).ready(function()
            {
                $('#slider1').tinycarousel();
            });
        </script>

    </div>
<!--    <div><a href="trangbansanphamchitiet1.html"><img src="images/tvgh.jpg" border="0" style="float:right;" /></a></div>-->
</div>