<?php
$this->breadcrumbs=array(
	'Range Distants'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List RangeDistant','url'=>array('index')),
array('label'=>'Manage RangeDistant','url'=>array('admin')),
);
?>

<h1>Create RangeDistant</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>