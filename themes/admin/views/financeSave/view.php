<?php
$this->breadcrumbs=array(
	'Finance Saves'=>array('index'),
	$model->finance_save_name,
);

$this->menu=array(
	array('label'=>'List FinanceSave','url'=>array('index')),
	array('label'=>'Create FinanceSave','url'=>array('create')),
	array('label'=>'Update FinanceSave','url'=>array('update','id'=>$model->finance_save_name)),
	array('label'=>'Delete FinanceSave','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->finance_save_name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FinanceSave','url'=>array('admin')),
);
?>

<h1>View FinanceSave #<?php echo $model->finance_save_name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'finance_save_name',
		'finance_save_value',
		'finance_save_string',
		'finance_save_info',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
		'check_time',
		'check_user_id',
	),
)); ?>
