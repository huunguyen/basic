<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
        ));
?>

	<h1>Cập nhật trả lời [<?php echo $model->id_customer_message; ?>]</h1>

<?php echo $this->renderPartial('application.views.customerMessage._form',array('model'=>$model)); ?>