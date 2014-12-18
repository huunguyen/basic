<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin nhắn'),
        ));
?>

<h1>Tạo thư và gửi đến khách hàng</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>