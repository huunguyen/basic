<style>
    #slider_pro {position:relative; width:650px; height:260px;list-style: none}
    #slider_pro li {position:absolute;left:0; top:0;}

</style>
<script>
    $(function() {
        $('#slider_pro li:gt(0)').hide();
        setInterval(function() {
            $('#slider_pro li:first-child').fadeOut()
                    .next('li').fadeIn()
                    .end().appendTo('#slider_pro');
        },
                5000);
    });
</script>
<div id="title" style="margin-left:10px;">kHUYẾN MÃI BỘ SẢN PHẨM TRỌN GÓI</div>
<?php
$pack = Pack::model()->findAll();
$item = array();
foreach ($pack as $value3) {
    $item[] = $value3->id_pack_group;
}
$str = implode(",", $item);
$date = date('d/m/Y');
$criteria = new CDbCriteria();
$criteria->condition = "active=1 and available_date >= $date and id_pack_group in($str)";
$criteria->limit = '4';
$data = PackGroup::model()->findAll($criteria);
?>
<!---==========================End slider_package====================================---->
<div style="margin-left:10px; margin-bottom:10px;">

    <div id="slider_wrapper">
        <div id="slider">
            <ul id="slider_pro">
                <?php
                foreach ($data as $value):
                    $pack = Pack::model()->findByAttributes(array('id_pack_group' => $value->id_pack_group));
                    if (!empty($pack)) {
                        $img = ImageHelper::FindImageByPk(Product::TYPE, $pack->id_product);
                        if ($img != NULL) {
                            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($img, Product::TYPE, "240x180"));
                        } else {
                            $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                        }
                    } else {
                        $image = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . "logo_64x64.png");
                    }
                    ?>
                    <li>
                        <div style="float: left;width: 100%">
                            <div style="float: left;width: 320px">
                                <h2 style="font-weight:bold;font-size: 20px;color: #333"><?php echo $value->name; ?></h2>
                                <p><?php echo StringHelper::Limit($value->description_short, 250); ?></p>
                                <a class="button" href="javascript:return false;" onclick="addcartpack(<?php echo $value->id_pack_group; ?>)">Thêm vào giỏ hàng</a>
                                <a class="button" href="<?= Yii::app()->createUrl('product/showpack', array('id' => $value->id_pack_group)) ?>">Xem</a>
                            </div>
                            <div style="float: left">
                                <img src="<?= $image ?>" width="320" height="260" />
                            </div>
                        </div>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
    </div>			

</div>
<script>
    function addcartpack(id)
    {
        $('#loading').css('display', 'block');
        $.ajax({
            type: "POST",
            async: false,
            url: "<?= Yii::app()->createUrl('product/addpackcart') ?>",
            data: "id_pack=" + id,
            success: function(data) {
                var getData = '( ' + $.parseJSON(data) + ' )';
                $('#loading').css('display', 'none');
                $('#success').css('display', 'block');
                setTimeout(function() {
                    $('#success').css('display', 'none');
                }, 1000);
                $('#shop_cart').html(getData);
            }
        });
    }
</script>