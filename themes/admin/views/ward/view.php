<?php
$this->breadcrumbs=array(
	'Wards'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Ward','url'=>array('index')),
array('label'=>'Create Ward','url'=>array('create')),
array('label'=>'Update Ward','url'=>array('update','id'=>$model->id_ward)),
array('label'=>'Delete Ward','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_ward),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Ward','url'=>array('admin')),
);
?>

<h1>View Ward #<?php echo $model->id_ward; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_ward',
		'name',
		'iso_code',
		'id_district',
		'date_add',
		'date_upd',
),
)); ?>
