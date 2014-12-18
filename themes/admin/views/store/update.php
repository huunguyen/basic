<?php
$this->breadcrumbs=array(
	'Stores'=>array('index'),
	$model->name=>array('view','id'=>$model->id_store),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Store','url'=>array('index')),
	array('label'=>'Create Store','url'=>array('create')),
	array('label'=>'View Store','url'=>array('view','id'=>$model->id_store)),
	array('label'=>'Manage Store','url'=>array('admin')),
	);
	?>

	<h1>Update Store <?php echo $model->id_store; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>