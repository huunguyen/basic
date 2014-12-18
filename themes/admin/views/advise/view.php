<?php
$this->breadcrumbs=array(
	'Advises'=>array('index'),
	$model->id_advise,
);

$this->menu=array(
array('label'=>'List Advise','url'=>array('index')),
array('label'=>'Create Advise','url'=>array('create')),
array('label'=>'Update Advise','url'=>array('update','id'=>$model->id_advise)),
array('label'=>'Delete Advise','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_advise),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Advise','url'=>array('admin')),
);
?>

<h1>View Advise #<?php echo $model->id_advise; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_advise',
		'create_date',
		'id_customer',
		'id_guest',
),
)); ?>
