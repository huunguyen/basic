<?php
$this->breadcrumbs=array(
	'Order Details'=>array('index'),
	$model->id_order_detail,
);

$this->menu=array(
array('label'=>'List OrderDetail','url'=>array('index')),
array('label'=>'Create OrderDetail','url'=>array('create')),
array('label'=>'Update OrderDetail','url'=>array('update','id'=>$model->id_order_detail)),
array('label'=>'Delete OrderDetail','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_order_detail),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage OrderDetail','url'=>array('admin')),
);
?>

<h1>View OrderDetail #<?php echo $model->id_order_detail; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_order_detail',
		'id_order',
		'id_warehouse',
		'id_product',
		'id_product_attribute',
		'quantity',
		'quantity_in_stock',
		'quantity_refunded',
		'quantity_return',
		'quantity_reinjected',
		'price',
		'reduction_percent',
		'reduction_amount',
		'reduction_amount_tax_incl',
		'reduction_amount_tax_excl',
		'reference',
		'supplier_reference',
		'weight',
		'total_price_tax_incl',
		'total_price_tax_excl',
		'unit_price_tax_incl',
		'unit_price_tax_excl',
		'total_shipping_price_tax_incl',
		'total_shipping_price_tax_excl',
		'purchase_supplier_price',
		'original_product_price',
),
)); ?>
