<?php
$this->breadcrumbs=array(
	'Packs'=>array('index'),
	$model->id_pack,
);

$this->menu=array(
array('label'=>'List Pack','url'=>array('index')),
array('label'=>'Create Pack','url'=>array('create')),
array('label'=>'Update Pack','url'=>array('update','id'=>$model->id_pack)),
array('label'=>'Delete Pack','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_pack),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Pack','url'=>array('admin')),
);
?>

<h1>View Pack #<?php echo $model->id_pack; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_pack',
		'id_pack_group',
		'id_product',
		'id_product_attribute',
		'quantity',
),
)); ?>
