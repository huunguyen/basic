<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản trị người dùng', 'url' => array('user/grid')),
    array('name' => 'xem chi tiết người'),
  ));
?>
