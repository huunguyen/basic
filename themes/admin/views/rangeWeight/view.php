<?php
$this->breadcrumbs=array(
	'Range Weights'=>array('index'),
	$model->id_range_weight,
);

$this->menu=array(
array('label'=>'List RangeWeight','url'=>array('index')),
array('label'=>'Create RangeWeight','url'=>array('create')),
array('label'=>'Update RangeWeight','url'=>array('update','id'=>$model->id_range_weight)),
array('label'=>'Delete RangeWeight','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_range_weight),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage RangeWeight','url'=>array('admin')),
);
?>

<h1>View RangeWeight #<?php echo $model->id_range_weight; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_range_weight',
		'id_carrier',
		'delimiter1',
		'delimiter2',
),
)); ?>
