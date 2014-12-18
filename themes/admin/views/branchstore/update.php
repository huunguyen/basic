<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý Chi Nhánh', 'url' => array('user/grid')),
    array('name' => 'Tạo hoặc Cập nhật'),
  ));
?>

<?php echo $this->renderPartial('_branch', array('model'=>$model, 'address'=>$address)); ?>