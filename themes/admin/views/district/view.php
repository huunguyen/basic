<?php
$this->breadcrumbs=array(
	'Districts'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List District','url'=>array('index')),
array('label'=>'Create District','url'=>array('create')),
array('label'=>'Update District','url'=>array('update','id'=>$model->id_district)),
array('label'=>'Delete District','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_district),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage District','url'=>array('admin')),
);
?>

<h1>View District #<?php echo $model->id_district; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_district',
		'name',
		'id_city',
		'iso_code',
		'date_add',
		'date_upd',
		'slug',
),
)); ?>
