<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thành viên'),
        ));
?>

<h1>Tạo thành viên</h1>

<?php echo $this->renderPartial('_user', array('model'=>$model, 'mmodel'=>$mmodel)); ?>
