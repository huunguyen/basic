<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin nhắn'),
        ));
?>

<h1>Xem thư #<?php echo $model->id_message; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'idOrder.secure_key',
		'title',
		'message',
		'date_add',
		'private'
	),
)); ?>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Soạn thư mới và gửi đến khách hàng',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("message/create"),
)); ?>