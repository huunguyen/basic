<?php
$this->breadcrumbs=array(
	'Stores'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Store','url'=>array('index')),
array('label'=>'Create Store','url'=>array('create')),
array('label'=>'Update Store','url'=>array('update','id'=>$model->id_store)),
array('label'=>'Delete Store','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_store),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Store','url'=>array('admin')),
);
?>

<h1>View Store #<?php echo $model->id_store; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_store',
		'id_store_group',
		'id_city',
		'id_theme',
		'active',
		'name',
		'address1',
		'address2',
		'latitude',
		'longitude',
		'phone',
		'fax',
		'email',
		'note',
		'date_add',
		'date_upd',
		'slug',
),
)); ?>
