<?php
$this->breadcrumbs=array(
	'Cities'=>array('index'),
	$model->name=>array('view','id'=>$model->id_city),
	'Update',
);

	$this->menu=array(
	array('label'=>'List City','url'=>array('index')),
	array('label'=>'Create City','url'=>array('create')),
	array('label'=>'View City','url'=>array('view','id'=>$model->id_city)),
	array('label'=>'Manage City','url'=>array('admin')),
	);
	?>

	<h1>Update City <?php echo $model->id_city; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>