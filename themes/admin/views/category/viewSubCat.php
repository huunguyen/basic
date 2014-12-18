<?php echo $this->renderPartial('application.views.layouts.common'); ?>

<?php
/* @var $this MenuController */
/* @var $model Menu */

$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Trang chủ menu', 'url' => array('category/index')),
    array('name' => 'xem chi tiết danh mục cha', 'url' => array('category/view', 'id' => $model->parent_id)),
    array('name' => 'xem chi tiết danh mục con'),
  ));

?>

<h1>Xem danh mục con #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'last_update',
		'ordering',
		'status',
		'info',
	),
)); ?>