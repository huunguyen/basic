<?php
$this->breadcrumbs=array(
	'Order Carriers'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List OrderCarrier','url'=>array('index')),
array('label'=>'Manage OrderCarrier','url'=>array('admin')),
);
?>

<h1>Create OrderCarrier</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>