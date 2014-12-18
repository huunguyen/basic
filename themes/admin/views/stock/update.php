<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Lô Hàng'),
        ));
?>

	<h1>Cập nhật <?php echo $model->id_stock; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>