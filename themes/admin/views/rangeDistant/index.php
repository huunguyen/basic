<?php
$this->breadcrumbs=array(
	'Range Distants',
);

$this->menu=array(
array('label'=>'Create RangeDistant','url'=>array('create')),
array('label'=>'Manage RangeDistant','url'=>array('admin')),
);
?>

<h1>Range Distants</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
