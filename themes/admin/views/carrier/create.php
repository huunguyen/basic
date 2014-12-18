<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà vận chuyển'),
        ));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>