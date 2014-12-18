<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuộc Tính Sản phẩm'),
        ));
?>

<h1>Update Group [<?php echo $model->id_attribute_group; ?>] <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('application.views.attributeGroup._form', array('model' => $model)); ?>