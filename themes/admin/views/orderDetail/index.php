<?php
$this->breadcrumbs=array(
	'Order Details',
);

$this->menu=array(
array('label'=>'Create OrderDetail','url'=>array('create')),
array('label'=>'Manage OrderDetail','url'=>array('admin')),
);
?>

<h1>Order Details</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
