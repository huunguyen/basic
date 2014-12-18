<?php
$this->breadcrumbs=array(
	'Range Weights'=>array('index'),
	$model->id_range_weight=>array('view','id'=>$model->id_range_weight),
	'Update',
);

	$this->menu=array(
	array('label'=>'List RangeWeight','url'=>array('index')),
	array('label'=>'Create RangeWeight','url'=>array('create')),
	array('label'=>'View RangeWeight','url'=>array('view','id'=>$model->id_range_weight)),
	array('label'=>'Manage RangeWeight','url'=>array('admin')),
	);
	?>

	<h1>Update RangeWeight <?php echo $model->id_range_weight; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>