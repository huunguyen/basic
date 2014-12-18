<?php $this->pageTitle = $model->name; ?>
<style>
    .radio{margin:6px 0px 0px 6px}
</style>
<div id="main">
    <!------------------------------------------------------------->
    <div style="border-radius: 2px;float: left;margin-top: 5px;margin-bottom:5px;padding-left: 5px;padding-right: 10px">
        <div id="left_ct">
            <div id="webwidget_slideshow_html5_simple" style="border: 0px">
                <ul>
                    <?php foreach ($images as $image): ?>
                        <li>
                            <a href="javascript:void()" ><img src="<?php echo $image; ?>"  alt="<?= $model->name ?>"/></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php $this->renderpartial('_view_product', array('price' => $price, 'price_hot' => $price_hot, 'model' => $model, 'groups' => $groups, 'total_percent' => $total_percent, 'total_rate' => $total_rate, 'supp' => $supp, 'attributes' => $attributes, 'total' => $total)); ?>
    </div>
    <div id="right_ct">
        <ul>
            <li>
                <!-- Lets make a simple image magnifier -->
                <div class="magnify">

                    <!-- This is the magnifying glass which will contain the original/large version -->
                    <div class="large"></div>
                    <?php
                    $certificate = ImageHelper::FindImageByPk(Supplier::TYPE, 'cer_' . $supp->id_supplier);
                    if ($certificate !== null) {
                        $cer_thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($certificate, Supplier::TYPE, "640x480"));
                    } else {
                        $cer_thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'cer.png');
                    }
                    ?>
                    <!-- This is the small image -->
                    <img class="small" src="<?= $cer_thumbnail ?>" width="200" height="293"/>
                </div>
            </li>
        </ul>		  
    </div>
    <div id="head_big">
        <div id="bgmoc">&nbsp;</div>
    </div> 
    <div id="left_ct1">
        <?php
        $this->renderpartial("_feature", array("model" => $model));
        $this->renderpartial('_viewQuestion', array("post" => $post, 'pages_post' => $pages_post));
        ?>
        <div id="commentProduct">
            <?= $this->renderpartial('_comment', array("id_product" => $model->id_product, 'data' => $data_comment, 'pages_comment' => $pages_comment, 'model' => $modeltheard, 'model1' => $model1)); ?>
        </div>
    </div>
    <div id="content_ct1" >
        <?php $this->renderpartial('_sale'); ?>

        <!---==========================End slider_package====================================---->
        <?php
        if (isset($data_accessory) && count($data_accessory) != 0) {
            $this->renderPartial('_accessory', array('data' => $data_accessory));
        }
        ?>
        <?php
        if (count($product_similar) != 0) {
            $this->renderPartial("_Sampro", array("product_similar" => $product_similar, "pages" => $pages));
        }
        ?>
    </div>
    <script type="text/javascript">
        function show() {
            var item = document.getElementById('soluong').value;
            if (item == "") {
                document.getElementById('sum').innerHTML = '';
                return;
            } else {
                document.getElementById('sum').value = item;
            }
        }
    </script>
