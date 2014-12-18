<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Tạo hóa đơn</h1>

<?php echo $this->renderPartial('application.views.orderInvoice._form', array('model'=>$model)); ?>