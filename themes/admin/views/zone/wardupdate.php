<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Vùng & Khu Vực'),
        ));
?>

<h1>Cập nhật Phường xã</h1>

<?php echo $this->renderPartial('_ward', array('model'=>$model)); ?>