<?php
$this->breadcrumbs=array(
	'Specific Prices'=>array('index'),
	$model->id_specific_price=>array('view','id'=>$model->id_specific_price),
	'Update',
);

	$this->menu=array(
	array('label'=>'List SpecificPrice','url'=>array('index')),
	array('label'=>'Create SpecificPrice','url'=>array('create')),
	array('label'=>'View SpecificPrice','url'=>array('view','id'=>$model->id_specific_price)),
	array('label'=>'Manage SpecificPrice','url'=>array('admin')),
	);
	?>

	<h1>Update SpecificPrice <?php echo $model->id_specific_price; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>