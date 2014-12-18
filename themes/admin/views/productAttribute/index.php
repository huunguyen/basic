<?php
$this->breadcrumbs=array(
	'Product Attributes',
);

$this->menu=array(
array('label'=>'Create ProductAttribute','url'=>array('create')),
array('label'=>'Manage ProductAttribute','url'=>array('admin')),
);
?>

<h1>Product Attributes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
