<?php
$this->breadcrumbs=array(
	'Packs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Pack','url'=>array('index')),
array('label'=>'Manage Pack','url'=>array('admin')),
);
?>

<h1>Create Pack</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>