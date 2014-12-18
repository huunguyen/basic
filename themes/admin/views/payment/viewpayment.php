<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý giỏ hàng', 'url' => array('payment/books')),
    array('name' => 'Chi tiết giỏ hàng'),
  ));
?>
 
<?php echo $this->renderPartial('_viewpayment', array('model'=>$model)); ?>  