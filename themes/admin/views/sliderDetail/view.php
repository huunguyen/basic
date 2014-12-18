<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Trình chiếu'),
        ));
?>

<h1>Ảnh trong trình diễn #<?php echo $model->id_slider_detail; ?></h1>
<?php
try {
    if ((!empty($model->old_image) || $model->old_image != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . $model->old_image))) {
        $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_image, SliderDetail::TYPE, "850x275"));
    } else {
        $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
    }
} catch (Exception $ex) {
    $model->thumbnail = $ex->getMessage();
}
?>   
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		array(
                'name' => 'image',
                'header' => 'Ảnh',
                'type' => 'raw',
                'value' => CHtml::link( CHtml::image($model->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:850px;height:275px;")), Yii::app()->createUrl("slider/viewDetail", array("id"=>$model->id_slider_detail)), array("class"=>"highslide", "rel"=>"myrel"))
            ),
		'url',
		'title',
		'description',
),
)); ?>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm ảnh cho trình diễn',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("slider/createDetail", array("id"=>$model->id_slider)),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Sửa ảnh cho trình diễn',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("slider/updateDetail", array("id"=>$model->id_slider_detail)),
)); ?>
