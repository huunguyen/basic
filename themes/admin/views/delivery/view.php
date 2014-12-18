<?php
$this->breadcrumbs=array(
	'Deliveries'=>array('index'),
	$model->id_delivery,
);

$this->menu=array(
array('label'=>'List Delivery','url'=>array('index')),
array('label'=>'Create Delivery','url'=>array('create')),
array('label'=>'Update Delivery','url'=>array('update','id'=>$model->id_delivery)),
array('label'=>'Delete Delivery','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_delivery),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Delivery','url'=>array('admin')),
);
?>

<h1>View Delivery #<?php echo $model->id_delivery; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_delivery',
		'id_carrier',
		'range_price',
		'range_weight',
		'range_distant',
		'price',
),
)); ?>
