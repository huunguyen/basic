<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Khách hàng'),
        ));
?>

<h1>Tạo khách hàng</h1>

<?php echo $this->renderPartial('_customer', array('model'=>$model, 'mmodel'=>$mmodel)); ?>