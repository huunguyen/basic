<?php
$this->breadcrumbs = array(
    'Carriers' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Carrier', 'url' => array('index')),
    array('label' => 'Create Carrier', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('carrier-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Carriers</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
        &lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'carrier-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id_carrier',
        'name',
        'url',
        'active',
        'deleted',
        'shipping_handling',
        /*
          'range_behavior',
          'is_free',
          'shipping_external',
          'need_range',
          'shipping_method',
          'position',
          'max_width',
          'max_height',
          'max_depth',
          'max_weight',
          'grade',
          'delay',
          'slug',
         */
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
