<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
        ));
?>

	<h1>Cập nhật luồng thảo luận <?php echo $model->id_customer_thread; ?></h1>

<?php echo $this->renderPartial('application.views.customerThread._form',array('model'=>$model)); ?>