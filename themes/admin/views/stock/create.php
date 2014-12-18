<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>

<h1>Tạo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>