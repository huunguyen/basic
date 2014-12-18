<?php
$this->breadcrumbs=array(
	'Answers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Answer','url'=>array('index')),
	array('label'=>'Create Answer','url'=>array('create')),
	array('label'=>'Update Answer','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Answer','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Answer','url'=>array('admin')),
);
?>

<h1>View Answer #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		'attach_file',
		'create_time',
		'update_time',
		'create_user_id',
		'update_user_id',
		'check_user_id',
		'status',
		'question_id',
		'parent_id',
	),
)); ?>
