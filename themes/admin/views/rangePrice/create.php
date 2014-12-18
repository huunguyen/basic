<?php
$this->breadcrumbs=array(
	'Range Prices'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List RangePrice','url'=>array('index')),
array('label'=>'Manage RangePrice','url'=>array('admin')),
);
?>

<h1>Create RangePrice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>