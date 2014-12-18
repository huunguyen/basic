<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà cung cấp'),
        ));
?>

<h1>Tạo Nhà cung cấp</h1>

<?php echo $this->renderPartial('_supplier', array('model'=>$model, 'mmodel'=>$mmodel)); ?>