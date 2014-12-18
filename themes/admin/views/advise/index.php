<?php
$this->breadcrumbs=array(
	'Advises',
);

$this->menu=array(
array('label'=>'Create Advise','url'=>array('create')),
array('label'=>'Manage Advise','url'=>array('admin')),
);
?>

<h1>Advises</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
