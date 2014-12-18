<?php
$this->breadcrumbs=array(
	'User Details',
);

$this->menu=array(
	array('label'=>'Create UserDetail','url'=>array('create')),
	array('label'=>'Manage UserDetail','url'=>array('admin')),
);
?>

<h1>User Details</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
