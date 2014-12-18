<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản trị người dùng', 'url' => array('user/grid')),
    array('name' => 'grid'),
  ));
?>
 
<?php echo $this->renderPartial('_admingrid', array('dataProvider'=>$dataProvider,
            'pageSize' => $pageSize)); ?>   
