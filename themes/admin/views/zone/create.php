<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Vùng & Khu Vực'),
        ));
?>

<h1>Tạo Khu Vực | Vùng</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'cmodel'=>$cmodel)); ?>