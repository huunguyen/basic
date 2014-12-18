<?php
$this->breadcrumbs=array(
	'User Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserDetail','url'=>array('index')),
	array('label'=>'Manage UserDetail','url'=>array('admin')),
);
?>

<h1>Create UserDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>