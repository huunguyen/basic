<?php
$this->breadcrumbs=array(
	'Hot Deal Values'=>array('index'),
	$model->id_hot_deal_value,
);

$this->menu=array(
array('label'=>'List HotDealValue','url'=>array('index')),
array('label'=>'Create HotDealValue','url'=>array('create')),
array('label'=>'Update HotDealValue','url'=>array('update','id'=>$model->id_hot_deal_value)),
array('label'=>'Delete HotDealValue','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_hot_deal_value),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage HotDealValue','url'=>array('admin')),
);
?>

<h1>View HotDealValue #<?php echo $model->id_hot_deal_value; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_hot_deal_value',
		'id_hot_deal',
		'custom_name',
		'custom_value',
),
)); ?>
