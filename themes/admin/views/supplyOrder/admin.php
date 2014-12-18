<?php
$this->breadcrumbs=array(
	'Supply Orders'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List SupplyOrder','url'=>array('index')),
array('label'=>'Create SupplyOrder','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('supply-order-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Supply Orders</h1>

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
'id'=>'supply-order-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_supply_order',
		'id_supplier',
		'supplier_name',
		'id_warehouse',
		'id_supply_order_state',
		'reference',
		/*
		'date_add',
		'date_upd',
		'date_delivery_expected',
		'total_te',
		'total_with_discount_te',
		'total_tax',
		'total_ti',
		'discount_rate',
		'discount_value_te',
		'is_template',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
