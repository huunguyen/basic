<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Phân mục'),
        ));
?>
	<h1>Cập nhật danh mục <?php echo $model->id_category; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>