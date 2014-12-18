<?php
$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Category','url'=>array('index')),
array('label'=>'Create Category','url'=>array('create')),
array('label'=>'Update Category','url'=>array('update','id'=>$model->id_category)),
array('label'=>'Delete Category','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_category),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Category','url'=>array('admin')),
);
?>

<h1>Xem chi tiết danh mục #<?php echo $model->id_category; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_category',
		'id_parent',
		'level_depth',
		'active',
		'date_add',
		'date_upd',
		'position',
		'is_root_category',
		'name',
		'description',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'alias',
),
)); ?>
