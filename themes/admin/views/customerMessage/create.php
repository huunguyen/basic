<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
        ));
?>

<h1>Tạo trả lời</h1>

<?php echo $this->renderPartial('application.views.customerMessage._form', array('model'=>$model)); ?>