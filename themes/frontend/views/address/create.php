<?php
$link2 = "javascript:void(0)";
$link3 = "javascript:void(0)";
$link4 = "javascript:void(0)";
if (isset(Yii::app()->request->cookies['count'])&&isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->request->cookies['count'])&&isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0) {
    $i = Yii::app()->request->cookies['count']->value;
    if ($i >=0) {
        $link2 = Yii::app()->createUrl("address/create");
    }
}
if (isset(Yii::app()->request->cookies['count'])&&isset(Yii::app()->session['address2'])&&isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->request->cookies['count'])&&isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0&&isset(Yii::app()->session['address2'])) {
    $i =Yii::app()->request->cookies['count']->value;
    if ($i >= 1) {
        $link3 = Yii::app()->createUrl("cart/create");
    }
    if ($i >= 2) {
        $link4 = Yii::app()->createUrl("cart/createOder");
    }
}
?>
<div class="wizard-steps">
    <div class="more-step"><a href="<?= Yii::app()->createUrl("product/showCart") ?>"><span>1</span>Th&ocirc;ng tin sản phẩm </a></div>
    <div class="active-step"> <a href="<?=$link2?>"><span>2</span>Điền thông tin khách hàng </a></div>
    <div class="more-step"> <a href="<?=$link3?>"><span>3</span>Xác định đơn hàng </a></div>
    <div class="more-step"> <a href="<?=$link4?>"><span>4</span>Thanh toán </a></div>
    <div class="more-step"><a href="javascript:void(0)"><span>5</span> Hoàn thành đơn hàng </a></div> 
</div>
<div class="clear">&nbsp;</div>
<div id="cart_sh">
    <?php $this->renderpartial('_viewCart', array('data' => $data, 'data_cart_pack' => $data_cart_pack)); ?>
</div>
<?php $this->renderpartial('_form', array('model' => $model, 'model1' => $model1, 'cart' => $cart,'flat'=>$flat)); ?>
