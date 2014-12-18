<?php

$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuộc Tính Sản phẩm'),
        ));
?>
<?php echo $this->renderPartial('application.views.attributeGroup._form', array('model' => $model)); ?>