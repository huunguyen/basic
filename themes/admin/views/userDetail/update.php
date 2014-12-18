<?php
$this->breadcrumbs=array(
	'User Details'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserDetail','url'=>array('index')),
	array('label'=>'Create UserDetail','url'=>array('create')),
	array('label'=>'View UserDetail','url'=>array('view','id'=>$model->user_id)),
	array('label'=>'Manage UserDetail','url'=>array('admin')),
);
?>

<h1>Update UserDetail <?php echo $model->user_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>