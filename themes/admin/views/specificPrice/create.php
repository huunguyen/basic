<?php
$this->breadcrumbs=array(
	'Specific Prices'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List SpecificPrice','url'=>array('index')),
array('label'=>'Manage SpecificPrice','url'=>array('admin')),
);
?>

<h1>Create SpecificPrice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>