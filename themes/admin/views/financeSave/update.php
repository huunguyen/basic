<?php
$this->breadcrumbs=array(
	'Finance Saves'=>array('index'),
	$model->finance_save_name=>array('view','id'=>$model->finance_save_name),
	'Update',
);

$this->menu=array(
	array('label'=>'List FinanceSave','url'=>array('index')),
	array('label'=>'Create FinanceSave','url'=>array('create')),
	array('label'=>'View FinanceSave','url'=>array('view','id'=>$model->finance_save_name)),
	array('label'=>'Manage FinanceSave','url'=>array('admin')),
);
?>

<h1>Update FinanceSave <?php echo $model->finance_save_name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>