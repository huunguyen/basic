<?php
$this->breadcrumbs=array(
	'Range Distants'=>array('index'),
	$model->id_range_distant=>array('view','id'=>$model->id_range_distant),
	'Update',
);

	$this->menu=array(
	array('label'=>'List RangeDistant','url'=>array('index')),
	array('label'=>'Create RangeDistant','url'=>array('create')),
	array('label'=>'View RangeDistant','url'=>array('view','id'=>$model->id_range_distant)),
	array('label'=>'Manage RangeDistant','url'=>array('admin')),
	);
	?>

	<h1>Update RangeDistant <?php echo $model->id_range_distant; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>