<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý thành viên', 'url' => array('user/grid')),
    array('name' => 'mạng lưới'),
  ));
?>
 
<?php echo "Thiết lập các chi nhánh. Thành công!"; ?>  
