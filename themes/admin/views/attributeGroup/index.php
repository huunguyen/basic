<?php
$this->breadcrumbs=array(
	'Attribute Groups',
);

$this->menu=array(
array('label'=>'Create AttributeGroup','url'=>array('create')),
array('label'=>'Manage AttributeGroup','url'=>array('admin')),
);
?>

<h1>Attribute Groups</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
