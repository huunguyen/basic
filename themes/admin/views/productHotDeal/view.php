<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>

<h1>Xem chi tiết sản phẩm giá rẻ mỗi ngày #<?php echo $model->id_product_hot_deal; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_product_hot_deal',
		'id_product',
		'id_product_attribute',
		'id_hot_deal',
		'id_specific_price_rule',
		'quantity',
		'price',
		'remain_quantity',
		'state',
),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Cập nhật lại thông tin',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("productHotDeal/update", array("id"=>$model->id_product_hot_deal)),
)); ?>