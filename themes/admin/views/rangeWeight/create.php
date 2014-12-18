<?php
$this->breadcrumbs=array(
	'Range Weights'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List RangeWeight','url'=>array('index')),
array('label'=>'Manage RangeWeight','url'=>array('admin')),
);
?>

<h1>Create RangeWeight</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>