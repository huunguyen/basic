<?php
$this->breadcrumbs=array(
	'Finance Saves'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FinanceSave','url'=>array('index')),
	array('label'=>'Manage FinanceSave','url'=>array('admin')),
);
?>

<h1>Create FinanceSave</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>