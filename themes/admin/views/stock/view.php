<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>

<h1>Xem #<?php echo $model->id_stock; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_stock',
		'idWarehouse.name',
		'idProduct.name',
		'idProductAttribute.fullname',
		'reference',
		'physical_quantity',
//		'usable_quantity',
		'price_te',
),
)); ?>
