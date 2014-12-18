<?php
$this->breadcrumbs=array(
	'Auth Items',
);

$this->menu=array(
array('label'=>'Create AuthItem','url'=>array('create')),
array('label'=>'Manage AuthItem','url'=>array('admin')),
);
?>

<h1>Auth Items</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
