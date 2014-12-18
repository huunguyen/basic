<?php
$this->breadcrumbs=array(
	'Guests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Guest','url'=>array('index')),
	array('label'=>'Manage Guest','url'=>array('admin')),
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
<h1>Create Guest</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>