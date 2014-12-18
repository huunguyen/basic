<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đóng gói'),
        ));
?>

<h3>Tạo gói hàng [sẽ <b>giảm giá</b> khi mua tất cả sản phẩm]</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>