<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Đồng ý'),
  ));
?>


<div>
	<h3>Thông tin</h3>
	<p>
            Điều khoản
	</p>
</div>