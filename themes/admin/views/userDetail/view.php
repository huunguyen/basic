<?php
$this->breadcrumbs=array(
	'User Details'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List UserDetail','url'=>array('index')),
	array('label'=>'Create UserDetail','url'=>array('create')),
	array('label'=>'Update UserDetail','url'=>array('update','id'=>$model->user_id)),
	array('label'=>'Delete UserDetail','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserDetail','url'=>array('admin')),
);
?>

<h1>View UserDetail #<?php echo $model->user_id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'passwordHint',
		'isEmailVisible',
		'isScreenNameEditable',
		'deactivationTime',
		'fullName',
		'initials',
		'occupation',
		'gender',
		'birthDate',
		'textStatus',
		'secretQuestion',
		'secretAnswer',
		'administratorNote',
	),
)); ?>
