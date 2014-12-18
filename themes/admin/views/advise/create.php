<?php
$this->breadcrumbs=array(
	'Advises'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Advise','url'=>array('index')),
array('label'=>'Manage Advise','url'=>array('admin')),
);
?>

<h1>Create Advise</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>