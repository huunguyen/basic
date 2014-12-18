<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Liên lạc'),
        ));
?>

<h1>Cập nhật liên lạc <?php echo $model->id_contact; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>