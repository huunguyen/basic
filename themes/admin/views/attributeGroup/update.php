<?php
$this->breadcrumbs=array(
	'Attribute Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id_attribute_group),
	'Update',
);

	$this->menu=array(
	array('label'=>'List AttributeGroup','url'=>array('index')),
	array('label'=>'Create AttributeGroup','url'=>array('create')),
	array('label'=>'View AttributeGroup','url'=>array('view','id'=>$model->id_attribute_group)),
	array('label'=>'Manage AttributeGroup','url'=>array('admin')),
	);
	?>

	<h1>Update AttributeGroup <?php echo $model->id_attribute_group; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>