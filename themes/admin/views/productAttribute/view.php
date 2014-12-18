<?php
$this->breadcrumbs=array(
	'Product Attributes'=>array('index'),
	$model->id_product_attribute,
);

$this->menu=array(
array('label'=>'List ProductAttribute','url'=>array('index')),
array('label'=>'Create ProductAttribute','url'=>array('create')),
array('label'=>'Update ProductAttribute','url'=>array('update','id'=>$model->id_product_attribute)),
array('label'=>'Delete ProductAttribute','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_product_attribute),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage ProductAttribute','url'=>array('admin')),
);
?>

<h1>View ProductAttribute #<?php echo $model->id_product_attribute; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_product_attribute',
		'id_product',
		'reference',
		'supplier_reference',
		'wholesale_price',
		'price',
		'quantity',
		'weight',
		'unit_price_impact',
		'default_on',
		'minimal_quantity',
		'available_date',
),
)); ?>
