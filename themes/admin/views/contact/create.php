<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Liên lạc'),
        ));
?>

<h1>Tạo liên lạc</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>