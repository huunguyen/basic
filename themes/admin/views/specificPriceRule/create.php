<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Cả & Qui Luật Áp Giá'),
        ));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>