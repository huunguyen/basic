<?php
$link2 = "javascript:void(0)";
$link3 = "javascript:void(0)";
$link4 = "javascript:void(0)";
if (isset(Yii::app()->request->cookies['count'])&&isset(Yii::app()->session['address2'])&&isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->request->cookies['count'])&&isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0&&isset(Yii::app()->session['address2'])) {
    $i =Yii::app()->request->cookies['count']->value;
    if ($i >=0) {
        $link2 = Yii::app()->createUrl("address/create");
    }
    if ($i >= 1) {
        $link3 = Yii::app()->createUrl("cart/create");
    }
    if ($i >= 2) {
        $link4 = Yii::app()->createUrl("cart/createOder");
    }
}
?>
<div id="content_step">
    <div class="wizard-steps">
        <div class="active-step"><a href="<?= Yii::app()->createUrl("product/showCart") ?>"><span>1</span>Th&ocirc;ng tin sản phẩm </a></div>
        <div class="more-step"> <a href="<?= $link2 ?>"><span>2</span>Điền thông tin khách hàng </a></div>
        <div class="more-step"> <a href="<?= $link3 ?>"><span>3</span>Xác định đơn hàng </a></div>
        <div class="more-step"> <a href="<?= $link4 ?>"><span>4</span>Thanh toán </a></div>
        <div class="more-step"><a href="javascript:void(0)"><span>5</span> Hoàn thành đơn hàng </a></div> 
    </div>
    <div class="clear">&nbsp;</div>
    <div class="widget">
        <div class="invoice">
            <div class="inHead">
                <span class="inLogo"><a href="index.html" title="invoice">Đơn hàng của bạn</a></span>
                <div class="inInfo">
                    <span class="invoiceNum">qcdn#1258</span>
                    <i><?php echo date('d/m/Y'); ?></i>
                </div>
                <div class="clear"></div>
            </div>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'image-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            ));
            ?>
            <div id="cart_sh">
                <?php $this->renderpartial('_viewcart', array('data' => $data, 'data_cart_pack' => $data_cart_pack)); ?>
            </div>
        </div>
    </div>
    <div class="contact-submit"><input style="float:left;" type="submit" value="Quay lại" name="back"> </div>
    <div class="contact-submit"><input type="submit" value="Tiếp tục" name="next"></div>
        <?php $this->endWidget(); ?>

</div>