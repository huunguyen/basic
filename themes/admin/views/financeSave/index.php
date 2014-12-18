<?php
$this->breadcrumbs=array(
	'Finance Saves',
);

$this->menu=array(
	array('label'=>'Create FinanceSave','url'=>array('create')),
	array('label'=>'Manage FinanceSave','url'=>array('admin')),
);
?>

<h1>Finance Saves</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
