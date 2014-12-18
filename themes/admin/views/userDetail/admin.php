<?php
$this->breadcrumbs=array(
	'User Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserDetail','url'=>array('index')),
	array('label'=>'Create UserDetail','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-detail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage User Details</h1>

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
	'id'=>'user-detail-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_id',
		'passwordHint',
		'isEmailVisible',
		'isScreenNameEditable',
		'deactivationTime',
		'fullName',
		/*
		'initials',
		'occupation',
		'gender',
		'birthDate',
		'textStatus',
		'secretQuestion',
		'secretAnswer',
		'administratorNote',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
