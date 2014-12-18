<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Comment','url'=>array('index')),
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
if(isset($_GET['pid'])){
    $obj = Post::model()->findByPk($_GET['pid']);
    if(!isset($obj)){
        Yii::app()->user->setFlash('error', '<strong>Oh snap!</strong> Change a few things up and try submitting again.');
        $this->redirect(array('site/index'));
    }
}
else
{
    Yii::app()->user->setFlash('warning', '<strong>Warning!</strong> Best check yo self, you\'re not looking too good.');
    $this->redirect(array('post/index'));
}
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>