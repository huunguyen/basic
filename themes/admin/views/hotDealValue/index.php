<?php
$this->breadcrumbs=array(
	'Hot Deal Values',
);

$this->menu=array(
array('label'=>'Create HotDealValue','url'=>array('create')),
array('label'=>'Manage HotDealValue','url'=>array('admin')),
);
?>

<h1>Hot Deal Values</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
