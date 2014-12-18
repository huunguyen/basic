<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Diễn đàn khách hàng'),
        ));
?>

<h1>Tạo luồng thảo luận</h1>

<?php echo $this->renderPartial('application.views.customerThread._form', array('model'=>$model)); ?>