<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Vùng & Khu Vực'),
        ));
?>

	<h1>Cập Nhật Khu Vực | Vùng [<?php echo $model->id_zone; ?>] <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'cmodel'=>$cmodel)); ?>