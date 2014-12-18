<?php
$this->breadcrumbs=array(
	'Range Prices'=>array('index'),
	$model->id_range_price=>array('view','id'=>$model->id_range_price),
	'Update',
);

	$this->menu=array(
	array('label'=>'List RangePrice','url'=>array('index')),
	array('label'=>'Create RangePrice','url'=>array('create')),
	array('label'=>'View RangePrice','url'=>array('view','id'=>$model->id_range_price)),
	array('label'=>'Manage RangePrice','url'=>array('admin')),
	);
	?>

	<h1>Update RangePrice <?php echo $model->id_range_price; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>