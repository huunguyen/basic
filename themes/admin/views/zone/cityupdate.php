<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Vùng & Khu Vực'),
        ));
?>

<h1>cập nhật Thành phố | Tỉnh Thành</h1>

<?php echo $this->renderPartial('_city', array('model'=>$model)); ?>