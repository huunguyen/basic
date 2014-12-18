<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tin Tức'),
        ));
?>
<div class="view widget">
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
        'heading'=>CHtml::encode($model->title),
        'headingOptions' => array('style' => 'font-size: 14px; font-weight: bold;'),   
    )); ?>
    <p><?php echo $model->content; ?></p>
    <p>
        Post date: <?php echo CHtml::encode($model->date_add);?>
        By: <?php echo $model->idUserAdd->username;?>
    </p>

    <?php $this->endWidget(); ?>
</div>
<span class="clear"><br/></span>

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Thêm tin tức',
    'type' => 'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("post/create"),
));
?>