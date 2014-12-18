<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý Thanh toán', 'url' => array('payment/index')),
    array('name' => 'mạng lưới'),
  ));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'books' => $books)); ?>