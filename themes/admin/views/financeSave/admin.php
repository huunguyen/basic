<?php
$this->breadcrumbs=array(
	'Finance Saves'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FinanceSave','url'=>array('index')),
	array('label'=>'Create FinanceSave','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('finance-save-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Finance Saves</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'finance-save-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'finance_save_name',
		'finance_save_value',
		'finance_save_string',
		'finance_save_info',
		'create_time',
		'create_user_id',
		/*
		'update_time',
		'update_user_id',
		'check_time',
		'check_user_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
