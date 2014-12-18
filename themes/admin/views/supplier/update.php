<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà cung cấp'),
        ));
?>
<h1>Cập nhật Nhà cung cấp <?php echo $model->id_supplier; ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
