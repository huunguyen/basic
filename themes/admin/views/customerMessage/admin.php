<?php
$this->breadcrumbs=array(
	'Customer Messages'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List CustomerMessage','url'=>array('index')),
array('label'=>'Create CustomerMessage','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('customer-message-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Customer Messages</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'customer-message-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_customer_message',
		'id_customer_thread',
		'id_user',
		'title',
		'message',
		'file_name',
		/*
		'ip_address',
		'user_agent',
		'date_add',
		'private',
		'date_upd',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
