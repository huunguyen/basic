<script>
    jQuery("body").delegate("#pageSupp a", "click", function() {
        var qUrl = jQuery(this).attr("href");

        jQuery.get(qUrl, function(data) {
            jQuery('#ajaxRowSupp').html($(data).find('#ajaxRowSupp').html());
            jQuery('#ajaxPageSupp').html($(data).find('#ajaxPageSupp').html());
        });

        return false;
    });
</script>
<div id="title"> CHỌN NHÀ CUNG CẤP </div>
<div id = 'ajaxRowSupp'>
    <?php $i = 1;
    foreach ($dataProvider as $data):
        ?>
        <?php
        $img = ImageHelper::FindImageByPk(Supplier::TYPE, $data->id_supplier);
        if ($img != NULL) {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Supplier::TYPE, "240x180"));
        } else {
            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
        }
        ?>
    <?php if ($i % 4 == 0) { ?>
            <div id="content3_r">
                <div id="content3_k">
                    <ul> <li><a href="<?= Yii::app()->createUrl("supplier/view", array("id" => $data->id_supplier)) ?>"><img src="<?= $image ?>" width="200px" height="155px"/></a></li></ul>
                    <ul style="padding-left:10px;">
                        <li><h1><?php echo $data->name; ?></h1></li>
                    </ul>
                </div>        	
            </div>
            <div class="clear"></div>
    <?php } else { ?>
            <div id="content3_l">
                <div id="content3_k">
                    <ul> <li><a href="<?= Yii::app()->createUrl("supplier/view", array("id" => $data->id_supplier)) ?>"><img src="<?= $image ?>" width="200px" height="155px"/></a></li></ul>
                    <ul style="padding-left:10px;">
                        <li><h1><?php echo $data->name; ?></h1></li>
                    </ul>
                </div>        	
            </div>


        <?php } $i++; ?>
<?php endforeach; ?>
</div>
<div class="clear"></div>
<div class="scott">
    <div id='ajaxPageSupp' style="margin: auto;text-align: center;" align="center">
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
                'id' => 'pageSupp',
            ),
        ));
        ?>
    </div>

</div>

