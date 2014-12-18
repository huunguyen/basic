<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuế & Áp Thuế'),
        ));
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>