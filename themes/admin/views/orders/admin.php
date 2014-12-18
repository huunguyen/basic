<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Orders','url'=>array('index')),
array('label'=>'Create Orders','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('orders-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Orders</h1>

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
'id'=>'orders-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_order',
		'id_carrier',
		'id_customer',
		'id_cart',
		'id_address_delivery',
		'id_address_invoice',
		/*
		'id_parent',
		'current_state',
		'valid',
		'reference',
		'secure_key',
		'payment',
		'gift',
		'gift_message',
		'shipping_number',
		'total_paid',
		'total_paid_tax_incl',
		'total_paid_tax_excl',
		'total_paid_real',
		'total_products',
		'total_products_wt',
		'total_shipping',
		'total_shipping_tax_incl',
		'total_shipping_tax_excl',
		'total_wrapping',
		'total_wrapping_tax_incl',
		'total_wrapping_tax_excl',
		'invoice_number',
		'invoice_date',
		'delivery_number',
		'delivery_date',
		'date_add',
		'date_upd',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
