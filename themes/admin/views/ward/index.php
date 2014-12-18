<?php
$this->breadcrumbs=array(
	'Wards',
);

$this->menu=array(
array('label'=>'Create Ward','url'=>array('create')),
array('label'=>'Manage Ward','url'=>array('admin')),
);
?>

<h1>Wards</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
