<?php
$this->breadcrumbs=array(
	'Range Prices'=>array('index'),
	$model->id_range_price,
);

$this->menu=array(
array('label'=>'List RangePrice','url'=>array('index')),
array('label'=>'Create RangePrice','url'=>array('create')),
array('label'=>'Update RangePrice','url'=>array('update','id'=>$model->id_range_price)),
array('label'=>'Delete RangePrice','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_range_price),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage RangePrice','url'=>array('admin')),
);
?>

<h1>View RangePrice #<?php echo $model->id_range_price; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_range_price',
		'id_carrier',
		'delimiter1',
		'delimiter2',
),
)); ?>
