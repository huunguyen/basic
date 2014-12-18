<?php
$this->breadcrumbs=array(
	'Lookups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lookup','url'=>array('index')),
	array('label'=>'Manage Lookup','url'=>array('admin')),
);
?>
<?php
$this->widget('bootstrap.widgets.TbAlert', array('block'=>true, 'fade'=>true, 'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),));
?>
<h1>Create Lookup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>