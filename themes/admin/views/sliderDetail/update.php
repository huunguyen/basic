<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Trình chiếu'),
        ));
?>

	<h1>Cập nhật ảnh cho trình diễn <?php echo $model->id_slider_detail; ?></h1>

<?php echo $this->renderPartial('application.views.sliderDetail._form',array('model'=>$model)); ?>