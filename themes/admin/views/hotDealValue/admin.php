<?php
$this->breadcrumbs=array(
	'Hot Deal Values'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List HotDealValue','url'=>array('index')),
array('label'=>'Create HotDealValue','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('hot-deal-value-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Hot Deal Values</h1>

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
'id'=>'hot-deal-value-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_hot_deal_value',
		'id_hot_deal',
		'custom_name',
		'custom_value',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
