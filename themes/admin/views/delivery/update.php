<?php
$this->breadcrumbs=array(
	'Deliveries'=>array('index'),
	$model->id_delivery=>array('view','id'=>$model->id_delivery),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Delivery','url'=>array('index')),
	array('label'=>'Create Delivery','url'=>array('create')),
	array('label'=>'View Delivery','url'=>array('view','id'=>$model->id_delivery)),
	array('label'=>'Manage Delivery','url'=>array('admin')),
	);
	?>

	<h1>Update Delivery <?php echo $model->id_delivery; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>