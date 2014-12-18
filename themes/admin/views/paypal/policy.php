<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Chính sách'),
  ));
?>


<div>
	<h3>Thông tin</h3>
	<p>
            qui định.
	</p>
</div>