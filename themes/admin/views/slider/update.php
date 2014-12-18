<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Trình chiếu'),
        ));
?>

	<h1>Cập nhật trình diễn <?php echo $model->id_slider; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>