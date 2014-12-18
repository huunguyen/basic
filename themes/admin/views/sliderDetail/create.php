<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Trình chiếu'),
        ));
?>

<h1>Tạo ảnh cho trình diễn</h1>

<?php echo $this->renderPartial('application.views.sliderDetail._form', array('model'=>$model)); ?>