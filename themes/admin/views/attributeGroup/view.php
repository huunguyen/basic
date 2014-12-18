<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuộc Tính Sản phẩm'),
        ));
?>

<h1>View AttributeGroup #<?php echo $model->id_attribute_group; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_attribute_group',
		'is_color_group',
		'group_type',
		'position',
		'name',
		'public_name',
),
)); ?>
