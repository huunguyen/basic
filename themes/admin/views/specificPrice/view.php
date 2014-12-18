<?php
$this->breadcrumbs=array(
	'Specific Prices'=>array('index'),
	$model->id_specific_price,
);

$this->menu=array(
array('label'=>'List SpecificPrice','url'=>array('index')),
array('label'=>'Create SpecificPrice','url'=>array('create')),
array('label'=>'Update SpecificPrice','url'=>array('update','id'=>$model->id_specific_price)),
array('label'=>'Delete SpecificPrice','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_specific_price),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage SpecificPrice','url'=>array('admin')),
);
?>

<h1>View SpecificPrice #<?php echo $model->id_specific_price; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_specific_price',
		'id_specific_price_rule',
		'id_cart',
		'id_product',
		'id_product_attribute',
		'id_customer',
		'price',
		'from_quantity',
		'reduction',
		'reduction_type',
		'from',
		'to',
),
)); ?>
