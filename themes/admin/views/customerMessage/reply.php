<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
        ));
?>

<h1>Chi tiết thông tin trao đổi #[<?php echo $parent->id_customer_message; ?>]</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$parent,
'attributes'=>array(		
		'title',
		'message',
		'file_name',
		'ip_address',
		'id_customer_thread',
		'idUser.email',
		'user_agent',
		'date_add',
		'private',
		'date_upd',
),
)); ?>

<?php echo $this->renderPartial('application.views.customerMessage._form', array('model'=>$model)); ?>