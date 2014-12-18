<?php
$this->breadcrumbs=array(
	'Order Carriers'=>array('index'),
	$model->id_order_carrier,
);

$this->menu=array(
array('label'=>'List OrderCarrier','url'=>array('index')),
array('label'=>'Create OrderCarrier','url'=>array('create')),
array('label'=>'Update OrderCarrier','url'=>array('update','id'=>$model->id_order_carrier)),
array('label'=>'Delete OrderCarrier','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_order_carrier),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage OrderCarrier','url'=>array('admin')),
);
?>

<h1>View OrderCarrier #<?php echo $model->id_order_carrier; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_order_carrier',
		'id_order',
		'id_carrier',
		'id_order_invoice',
		'weight',
		'shipping_cost_tax_excl',
		'shipping_cost_tax_incl',
		'tracking_number',
		'date_add',
),
)); ?>
