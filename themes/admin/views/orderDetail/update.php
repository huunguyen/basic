<?php
$this->breadcrumbs=array(
	'Order Details'=>array('index'),
	$model->id_order_detail=>array('view','id'=>$model->id_order_detail),
	'Update',
);

	$this->menu=array(
	array('label'=>'List OrderDetail','url'=>array('index')),
	array('label'=>'Create OrderDetail','url'=>array('create')),
	array('label'=>'View OrderDetail','url'=>array('view','id'=>$model->id_order_detail)),
	array('label'=>'Manage OrderDetail','url'=>array('admin')),
	);
	?>

	<h1>Update OrderDetail <?php echo $model->id_order_detail; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>