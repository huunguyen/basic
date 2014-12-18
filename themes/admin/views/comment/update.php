<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Comment','url'=>array('index')),
	array('label'=>'Create Comment','url'=>array('create')),
	array('label'=>'View Comment','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Comment','url'=>array('admin')),
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
<h1>Update Comment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>