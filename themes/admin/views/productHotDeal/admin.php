<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>
<div class="widget">

<h1>Manage Product Hot Deals</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'product-hot-deal-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_product_hot_deal',
		'id_product',
		'id_product_attribute',
		'id_hot_deal',
		'id_specific_price_rule',
		'quantity',
		/*
		'price',
		'remain_quantity',
		'state',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
    
</div>