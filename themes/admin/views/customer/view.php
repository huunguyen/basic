<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$model->id_customer,
);

$this->menu=array(
array('label'=>'List Customer','url'=>array('index')),
array('label'=>'Create Customer','url'=>array('create')),
array('label'=>'Update Customer','url'=>array('update','id'=>$model->id_customer)),
array('label'=>'Delete Customer','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_customer),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Customer','url'=>array('admin')),
);
?>

<h1>View Customer #<?php echo $model->id_customer; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_customer',
		'gender',
		'id_default_group',
		'id_risk',
		'company',
		'firstname',
		'lastname',
		'email',
		'passwd',
		'last_passwd_gen',
		'birthday',
		'website',
		'secure_key',
		'note',
		'active',
		'is_guest',
		'deleted',
		'date_add',
		'date_upd',
),
)); ?>
