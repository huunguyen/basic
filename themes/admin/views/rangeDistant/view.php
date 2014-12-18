<?php
$this->breadcrumbs=array(
	'Range Distants'=>array('index'),
	$model->id_range_distant,
);

$this->menu=array(
array('label'=>'List RangeDistant','url'=>array('index')),
array('label'=>'Create RangeDistant','url'=>array('create')),
array('label'=>'Update RangeDistant','url'=>array('update','id'=>$model->id_range_distant)),
array('label'=>'Delete RangeDistant','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_range_distant),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage RangeDistant','url'=>array('admin')),
);
?>

<h1>View RangeDistant #<?php echo $model->id_range_distant; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_range_distant',
		'id_carrier',
		'delimiter1',
		'delimiter2',
),
)); ?>
