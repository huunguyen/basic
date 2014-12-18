<?php
$this->breadcrumbs=array(
	'Pack Groups'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List PackGroup','url'=>array('index')),
array('label'=>'Create PackGroup','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pack-group-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Pack Groups</h1>

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
'id'=>'pack-group-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_pack_group',
		'name',
		'description',
		'description_short',
		'date_add',
		'date_upd',
		/*
		'total_paid',
		'total_paid_real',
		'available_for_order',
		'available_date',
		'active',
		'reduction_type',
		'reduction',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
