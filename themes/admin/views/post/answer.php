<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Bản tin', 'url' => array('site/grid')),
    array('name' => 'Trả lời'),
  ));
?>
<?php echo $this->renderPartial('_create_answer', array('model'=>$model, 'files' => $files, 'qmodel' => $qmodel)); ?>
