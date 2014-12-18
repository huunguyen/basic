<?php
$this->breadcrumbs=array(
	'Details'=>array('index'),
	$model->id_detail,
);

$this->menu=array(
array('label'=>'List Detail','url'=>array('index')),
array('label'=>'Create Detail','url'=>array('create')),
array('label'=>'Update Detail','url'=>array('update','id'=>$model->id_detail)),
array('label'=>'Delete Detail','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_detail),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Detail','url'=>array('admin')),
);
?>

<h1>View Detail #<?php echo $model->id_detail; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_detail',
		'id_user',
		'id_customer',
		'lastname',
		'firstname',
		'question',
		'answer',
		'share_state',
		'date_add',
		'date_upd',
		'company',
		'birthday',
		'note',
		'site',
		'gender',
),
)); ?>
