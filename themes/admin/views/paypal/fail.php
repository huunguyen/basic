<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Thất bại'),
  ));
?>


<div>
	<h3>Thông tin</h3>
	<p>
            Xảy ra lỗi có thể do giao dịch đã được thực hiện.
	</p>
</div>