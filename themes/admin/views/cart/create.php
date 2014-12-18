<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giỏ hàng'),
        ));
?>

<h1>Create Cart</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>