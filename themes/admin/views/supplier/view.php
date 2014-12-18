<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà cung cấp'),
        ));
?>

<h1>Thông tin nhà cung cấp #<?php echo $model->id_supplier; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'name',
    array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => CHtml::link( CHtml::image($model->thumbnail,'',array('class'=>'img-rounded', 'style'=>'width:50px;height:50px;')), Yii::app()->createUrl('supplier/view', array('id'=>$model->id_supplier)), array('class'=>'highslide', 'rel'=>'myrel')),
                'htmlOptions' => array('style' => 'width: 50px')
            ),
		'address1',
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
array(
                'name' => 'certificate',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => CHtml::link( CHtml::image($model->cer_thumbnail,'',array('class'=>'img-rounded', 'style'=>'width:50px;height:50px;')), Yii::app()->createUrl('supplier/view', array('id'=>$model->id_supplier)), array('class'=>'highslide', 'rel'=>'myrel')),
                'htmlOptions' => array('style' => 'width: 50px')
            ),
		'phone',
		'fax',
		'email',
    array(
                'name' => 'note',
                'header' => 'Chú thích về sản phẩm!',
                'type' => 'html',
                'value' => $model->note,
            ),
    		'meta_title',
		'meta_keywords',
		'meta_description',
),
)); ?>