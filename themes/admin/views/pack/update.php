<?php
$this->breadcrumbs=array(
	'Packs'=>array('index'),
	$model->id_pack=>array('view','id'=>$model->id_pack),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Pack','url'=>array('index')),
	array('label'=>'Create Pack','url'=>array('create')),
	array('label'=>'View Pack','url'=>array('view','id'=>$model->id_pack)),
	array('label'=>'Manage Pack','url'=>array('admin')),
	);
	?>

	<h1>Update Pack <?php echo $model->id_pack; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>