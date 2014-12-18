<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Sản phẩm'),
        ));
?>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>