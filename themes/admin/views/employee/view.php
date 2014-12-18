<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id_user,
);

$this->menu=array(
array('label'=>'List User','url'=>array('index')),
array('label'=>'Create User','url'=>array('create')),
array('label'=>'Update User','url'=>array('update','id'=>$model->id_user)),
array('label'=>'Delete User','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_user),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage User','url'=>array('admin')),
);
?>

<h1>View User #<?php echo $model->id_user; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_user',
		'id_profile',
		'lastname',
		'firstname',
		'email',
		'passwd',
		'last_passwd_gen',
		'stats_date_from',
		'stats_date_to',
		'default_tab',
		'active',
		'id_last_order',
		'id_last_customer_message',
		'id_last_customer',
),
)); ?>
