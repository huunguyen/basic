<?php
$this->breadcrumbs=array(
	'Order Carriers',
);

$this->menu=array(
array('label'=>'Create OrderCarrier','url'=>array('create')),
array('label'=>'Manage OrderCarrier','url'=>array('admin')),
);
?>

<h1>Order Carriers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
