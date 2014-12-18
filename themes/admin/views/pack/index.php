<?php
$this->breadcrumbs=array(
	'Packs',
);

$this->menu=array(
array('label'=>'Create Pack','url'=>array('create')),
array('label'=>'Manage Pack','url'=>array('admin')),
);
?>

<h1>Packs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
