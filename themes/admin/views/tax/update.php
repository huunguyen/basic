<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuế & Áp Thuế'),
        ));
?>

	<h1>Cập nhật [<?php echo $model->id_tax; ?>] <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>