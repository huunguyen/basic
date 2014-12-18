<?php
/* @var $this BranchstoreController */
/* @var $model Branchstore */

$this->breadcrumbs=array(
	'Branchstores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Branchstore', 'url'=>array('index')),
	array('label'=>'Create Branchstore', 'url'=>array('create')),
	array('label'=>'Update Branchstore', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Branchstore', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Branchstore', 'url'=>array('admin')),
);
?>

<h1>View Branchstore #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'manager_id',
		'address_id',
		'last_update',
	),
)); ?>
