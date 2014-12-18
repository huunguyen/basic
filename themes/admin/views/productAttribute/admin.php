<?php
$this->breadcrumbs=array(
	'Product Attributes'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List ProductAttribute','url'=>array('index')),
array('label'=>'Create ProductAttribute','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('product-attribute-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Product Attributes</h1>

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
'id'=>'product-attribute-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_product_attribute',
		'id_product',
		'reference',
		'supplier_reference',
		'wholesale_price',
		'price',
		/*
		'quantity',
		'weight',
		'unit_price_impact',
		'default_on',
		'minimal_quantity',
		'available_date',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
