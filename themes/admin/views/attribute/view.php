<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Thuộc Tính Sản phẩm'),
        ));
?>

<h1>View Attribute #<?php echo $model->id_attribute; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_attribute',
		'id_attribute_group',
		'color',
		'position',
		'name',
),
)); ?>
