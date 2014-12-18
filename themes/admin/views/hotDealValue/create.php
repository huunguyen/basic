<?php
$this->breadcrumbs=array(
	'Hot Deal Values'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List HotDealValue','url'=>array('index')),
array('label'=>'Manage HotDealValue','url'=>array('admin')),
);
?>

<h1>Create HotDealValue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>