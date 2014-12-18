<?php
$this->breadcrumbs=array(
	'Details'=>array('index'),
	$model->id_detail=>array('view','id'=>$model->id_detail),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Detail','url'=>array('index')),
	array('label'=>'Create Detail','url'=>array('create')),
	array('label'=>'View Detail','url'=>array('view','id'=>$model->id_detail)),
	array('label'=>'Manage Detail','url'=>array('admin')),
	);
	?>

	<h1>Update Detail <?php echo $model->id_detail; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>