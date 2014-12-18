<?php
$this->breadcrumbs=array(
	'Specific Prices'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List SpecificPrice','url'=>array('index')),
array('label'=>'Create SpecificPrice','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('specific-price-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Specific Prices</h1>

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
'id'=>'specific-price-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_specific_price',
		'id_specific_price_rule',
		'id_cart',
		'id_product',
		'id_product_attribute',
		'id_customer',
		/*
		'price',
		'from_quantity',
		'reduction',
		'reduction_type',
		'from',
		'to',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
