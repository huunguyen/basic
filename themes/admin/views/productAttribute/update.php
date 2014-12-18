<?php
$this->breadcrumbs=array(
	'Product Attributes'=>array('index'),
	$model->id_product_attribute=>array('view','id'=>$model->id_product_attribute),
	'Update',
);

	$this->menu=array(
	array('label'=>'List ProductAttribute','url'=>array('index')),
	array('label'=>'Create ProductAttribute','url'=>array('create')),
	array('label'=>'View ProductAttribute','url'=>array('view','id'=>$model->id_product_attribute)),
	array('label'=>'Manage ProductAttribute','url'=>array('admin')),
	);
	?>

	<h1>Update ProductAttribute <?php echo $model->id_product_attribute; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>