<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'sản phẩm'),
        ));
?>

<?php echo $this->renderPartial('_combination', array('model' => $model, 'pro_att' => $pro_att, 'files' => $files)); ?>
