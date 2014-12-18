<?php
$this->breadcrumbs=array(
	'Order Carriers'=>array('index'),
	$model->id_order_carrier=>array('view','id'=>$model->id_order_carrier),
	'Update',
);

	$this->menu=array(
	array('label'=>'List OrderCarrier','url'=>array('index')),
	array('label'=>'Create OrderCarrier','url'=>array('create')),
	array('label'=>'View OrderCarrier','url'=>array('view','id'=>$model->id_order_carrier)),
	array('label'=>'Manage OrderCarrier','url'=>array('admin')),
	);
	?>

	<h1>Update OrderCarrier <?php echo $model->id_order_carrier; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>