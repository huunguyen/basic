<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin Tức'),
        ));
?>
<div class="grid12">
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
