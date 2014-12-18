<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuộc Tính Sản phẩm'),
        ));
?>

	<h1>Update Attribute <?php echo $model->id_attribute; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>