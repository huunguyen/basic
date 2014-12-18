<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà sản xuất'),
        ));
?>

<h1>Xem thông tin nhà sản xuất #<?php echo $model->id_manufacturer; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_manufacturer',
		'name',
    array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => CHtml::link( CHtml::image($model->thumbnail,'',array('class'=>'img-rounded', 'style'=>'width:50px;height:50px;')), Yii::app()->createUrl('manufacturer/view', array('id'=>$model->id_manufacturer)), array('class'=>'highslide', 'rel'=>'myrel')),
                'htmlOptions' => array('style' => 'width: 50px')
            ),
    array(
                'name' => 'description_short',
                'header' => 'Mô tả ngắn',
                'type' => 'html',
                'value' => $model->description_short,
            ),
    array(
                'name' => 'description',
                'header' => 'Mô tả',
                'type' => 'html',
                'value' => $model->description,
            ),
		'meta_title',
		'meta_keywords',
		'meta_description',
),
)); ?>
