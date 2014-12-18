<?php
$this->breadcrumbs=array(
	'Taxes'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Tax','url'=>array('index')),
array('label'=>'Create Tax','url'=>array('create')),
array('label'=>'Update Tax','url'=>array('update','id'=>$model->id_tax)),
array('label'=>'Delete Tax','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_tax),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Tax','url'=>array('admin')),
);
?>

<h1>View Tax #<?php echo $model->id_tax; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_tax',
		'rate',
		'active',
		'deleted',
		'name',
),
)); ?>
