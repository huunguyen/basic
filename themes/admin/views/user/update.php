<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thành viên'),
        ));
?>

<h1>Cập nhật thành viên [<?php echo $model->email; ?>][<?php echo $model->id_user; ?>]</h1>

<?php echo $this->renderPartial('_user', array('model' => $model, 'mmodel' => $mmodel)); ?>

