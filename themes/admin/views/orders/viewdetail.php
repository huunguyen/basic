<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Đơn hàng #[<?php echo $model->id_order; ?>] Mã Hàng [<?php echo $order->secure_key; ?>]</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_order_detail',
		'idOrder.secure_key',
		'idWarehouse.name',
		'idProduct.name',
		'idProductAttribute.fullname',
		'quantity',
//		'quantity_in_stock',
//		'quantity_refunded',
//		'quantity_return',
//		'quantity_reinjected',
		'price',
		'reduction_percent',
		'reduction_amount',
		'reduction_amount_tax_incl',
//		'reduction_amount_tax_excl',
		'reference',
		'supplier_reference',
		'weight',
		'total_price_tax_incl',
//		'total_price_tax_excl',
		'unit_price_tax_incl',
//		'unit_price_tax_excl',
		'total_shipping_price_tax_incl',
//		'total_shipping_price_tax_excl',
		'purchase_supplier_price',
		'original_product_price',
),
)); ?>
<h1>Chi tiết Đơn hàng [<?php echo $order->secure_key; ?>]</h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $detail->searchByOrder($model->id_order),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Trong Đơn hàng ['.$order->secure_key.']. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'id_order_detail', 'header' => 'MDH'),
            array('name' => 'secure_key', 'header' => 'Mã bảo mật'),
            array('name' => 'price', 'header' => 'Tổng sản phẩm'),
            array('name' => 'quantity', 'header' => 'Tổng sản phẩm'),            
            array('name' => 'unit_price_tax_incl', 'header' => 'Gía mỗi sản phẩm'),
            array('name' => 'total_price_tax_incl', 'header' => 'Tổng giá'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("orders/viewDetail", array("id"=>$data["id_order_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("orders/updateDetail", array("id"=>$data["id_order_detail"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("orders/deleteDetail", array("id"=>$data["id_order_detail"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn xóa thông tin này (Xóa trong đơn hàng và giỏ hàng)? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 120px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem Đơn Hàng Trong Hệ Thống',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("orders/index"),
)); ?>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Cập nhật đơn hàng ['.$order->secure_key.']',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("orders/update", array('id'=>$model->id_order)),
)); ?>