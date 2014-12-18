<?php
$this->breadcrumbs=array(
	'Range Prices',
);

$this->menu=array(
array('label'=>'Create RangePrice','url'=>array('create')),
array('label'=>'Manage RangePrice','url'=>array('admin')),
);
?>

<h1>Range Prices</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
