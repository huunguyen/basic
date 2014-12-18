<?php
$this->breadcrumbs=array(
	'Guests'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Guest','url'=>array('index')),
	array('label'=>'Create Guest','url'=>array('create')),
	array('label'=>'Update Guest','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Guest','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Guest','url'=>array('admin')),
);
?>
<?php
$this->widget('bootstrap.widgets.TbAlert', array('block'=>true, 'fade'=>true, 'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),));
?>
<h1>View Guest #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'salt',
		'password_strategy',
		'requires_new_password',
		'email',
		'login_attempts',
		'login_time',
		'login_ip',
		'validation_key',
		'create_id',
		'create_time',
		'update_id',
		'update_time',
	),
)); ?>
