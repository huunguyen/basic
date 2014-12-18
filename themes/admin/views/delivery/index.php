<?php
$this->breadcrumbs=array(
	'Deliveries',
);

$this->menu=array(
array('label'=>'Create Delivery','url'=>array('create')),
array('label'=>'Manage Delivery','url'=>array('admin')),
);
?>

<h1>Deliveries</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
