<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Vùng & Khu Vực'),
        ));
?>

<h1>Tạo Quận huyện</h1>

<?php echo $this->renderPartial('_dist', array('model'=>$model)); ?>