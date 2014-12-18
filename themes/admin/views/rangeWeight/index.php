<?php
$this->breadcrumbs=array(
	'Range Weights',
);

$this->menu=array(
array('label'=>'Create RangeWeight','url'=>array('create')),
array('label'=>'Manage RangeWeight','url'=>array('admin')),
);
?>

<h1>Range Weights</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
