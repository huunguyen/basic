<?php
$this->breadcrumbs=array(
	'Comments',
);

$this->menu=array(
	array('label'=>'Create Comment','url'=>array('create')),
	array('label'=>'Manage Comment','url'=>array('admin')),
);
?>

<?php
    $this->widget('bootstrap.widgets.TbAlert', array('block'=>true, 'fade'=>true, 'closeText'=>'&times;',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'true'),
        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'true'),
        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>10),
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>30),
    ),));
?>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
