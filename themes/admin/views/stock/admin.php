<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('stock-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Stocks</h1>

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
'id'=>'stock-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_stock',
		'id_warehouse',
		'id_product',
		'id_product_attribute',
		'reference',
		'physical_quantity',
		/*
		'usable_quantity',
		'price_te',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
