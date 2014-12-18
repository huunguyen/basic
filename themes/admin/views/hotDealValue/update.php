<?php
$this->breadcrumbs=array(
	'Hot Deal Values'=>array('index'),
	$model->id_hot_deal_value=>array('view','id'=>$model->id_hot_deal_value),
	'Update',
);

	$this->menu=array(
	array('label'=>'List HotDealValue','url'=>array('index')),
	array('label'=>'Create HotDealValue','url'=>array('create')),
	array('label'=>'View HotDealValue','url'=>array('view','id'=>$model->id_hot_deal_value)),
	array('label'=>'Manage HotDealValue','url'=>array('admin')),
	);
	?>

	<h1>Update HotDealValue <?php echo $model->id_hot_deal_value; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>