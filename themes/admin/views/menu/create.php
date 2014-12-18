<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Menu'),
        ));
?>

<h1>Tạo Menu</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>