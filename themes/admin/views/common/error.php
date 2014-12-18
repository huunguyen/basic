<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'News Home', 'url' => array('news/grid')),
    array('name' => 'Post Home', 'url' => array('post/grid')),
    array('name' => 'Human Home', 'url' => array('user/grid')),
    array('name' => 'error'),
  ));
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>