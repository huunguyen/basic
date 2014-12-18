<?php
$this->breadcrumbs=array(
	'Advises'=>array('index'),
	$model->id_advise=>array('view','id'=>$model->id_advise),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Advise','url'=>array('index')),
	array('label'=>'Create Advise','url'=>array('create')),
	array('label'=>'View Advise','url'=>array('view','id'=>$model->id_advise)),
	array('label'=>'Manage Advise','url'=>array('admin')),
	);
	?>

	<h1>Update Advise <?php echo $model->id_advise; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>