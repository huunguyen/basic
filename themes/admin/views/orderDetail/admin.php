<?php
$this->breadcrumbs=array(
	'Order Details'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List OrderDetail','url'=>array('index')),
array('label'=>'Create OrderDetail','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('order-detail-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Order Details</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'order-detail-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_order_detail',
		'id_order',
		'id_warehouse',
		'id_product',
		'id_product_attribute',
		'quantity',
		/*
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
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
