<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Kho Hàng'),
        ));
?>

<h1>Xem thông tin kho hàng #<?php echo $model->id_warehouse; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_warehouse',
		'id_currency',
		'id_address',
		'id_user',
		'reference',
		'name',
		'deleted',
),
)); ?>
