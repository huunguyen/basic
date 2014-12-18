<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
        ));
?>

<h1>Xem luồng thảo luận #<?php echo $model->id_customer_thread; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'idStore.name',
		'idContact.name',
		'idCustomer.email',
		'idOrder.secure_key',
		'id_product',
		array('name' => 'status', 'header' => 'Trạng thái',
                    'value' => Lookup::item("ThreadStatus", $model->status)
                ), 
		'email',
		'date_add',
		'date_upd',
),
)); ?>
