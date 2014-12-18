<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin nhắn'),
        ));
?>

<h1>Cập nhật lại thư gửi khách hàng <?php echo $model->id_message; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>