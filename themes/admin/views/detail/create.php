<?php
$this->breadcrumbs=array(
	'Details'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Detail','url'=>array('index')),
array('label'=>'Manage Detail','url'=>array('admin')),
);
?>

<h1>Create Detail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>