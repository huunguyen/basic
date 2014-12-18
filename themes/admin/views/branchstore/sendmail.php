<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Gửi thư'),
  ));
?>
<div class="fluid">    
    <?php if($status): ?>
    <h3>Gửi mail Thành Công</h3>
    <h1>Thông tin về chi nhánh đã gửi #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'info:html',
		'city_name',
                'address_store:html',
		'last_update',
	),
)); ?>
    <?php else: ?>
    <h3>Gửi mail Thất bại</h3>
    <?php endif; ?>
    
</div>
