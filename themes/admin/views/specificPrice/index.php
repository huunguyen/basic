<?php
$this->breadcrumbs=array(
	'Specific Prices',
);

$this->menu=array(
array('label'=>'Create SpecificPrice','url'=>array('create')),
array('label'=>'Manage SpecificPrice','url'=>array('admin')),
);
?>

<h1>Specific Prices</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
