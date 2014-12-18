<?php
$this->breadcrumbs=array(
	'Addresses',
);

$this->menu=array(
array('label'=>'Create Address','url'=>array('create')),
array('label'=>'Manage Address','url'=>array('admin')),
);
?>

<h1>Addresses</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
