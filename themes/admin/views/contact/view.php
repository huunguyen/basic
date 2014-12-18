<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Liên lạc'),
        ));
?>

<h1>Thông tin dịch vụ #<?php echo $model->id_contact; ?></h1>
 <?php
                if ((!empty($model->old_img) || $model->old_img != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . $model->old_img))) {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_img, Post::TYPE, "240x180"));
                } else {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
                }                
                ?>  
<div class="widget">
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            array(
                'name' => 'img',
                'type' => 'html',
                'value'=>  "<img src=\"$model->thumbnail\" />"
            ),
		'name',
		'email',
		'description'
	),
)); ?>
</div>

<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Quản lý liên lạc',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("contact/index"),
)); ?>