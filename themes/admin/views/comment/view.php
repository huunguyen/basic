<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Comment','url'=>array('index')),
	array('label'=>'Create Comment','url'=>array('create')),
	array('label'=>'Update Comment','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Comment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Comment','url'=>array('admin')),
);
?>
<?php
$this->widget('bootstrap.widgets.TbAlert', array('block'=>true, 'fade'=>true, 'closeText'=>'×',
    'alerts'=>array(
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
    ),));
?>
<?php
/*$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		'issue_id',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
		'post_id',
	),
)); */
?>
<div class="view">
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit', array('heading'=>CHtml::encode($model->post->title),)); ?>
    <p><?php echo CHtml::encode($model->content); ?></p>
    <p>
        Post date: <?php echo $model->create_time;?> By <?php echo $model->author->username; ?>
    </p>
    <?php $this->endWidget(); ?>
</div>