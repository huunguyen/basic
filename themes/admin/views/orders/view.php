<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Đơn hàng #[<?php echo $model->id_order; ?>] Mã Hàng [<?php echo $model->secure_key; ?>]</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_order',
		'idCarrier.name',
//		'id_customer',
//		'id_cart',
		'id_address_delivery',
		'id_address_invoice',
//		'id_parent',
		'current_state',
		'valid',
		'reference',
		'secure_key',
//		'payment',
		'gift',
		'gift_message',
//		'shipping_number',
    array(
                'name' => 'total_paid',
                'type' => 'number',
                'value'=> $model->total_paid
            ),
    array(
                'name' => 'Tổng tiền trả bằng chữ',
                'type' => 'html',
                'value'=> FinanceHelper::changeNumberToString($model->total_paid)
            ),
//		'total_paid_tax_incl',
//		'total_paid_tax_excl',
    array(
                'name' => 'total_paid_real',
                'type' => 'number',
                'value'=> $model->total_paid_real
            ),
    array(
                'name' => 'Tổng thực trả bằng chữ',
                'type' => 'html',
                'value'=> FinanceHelper::changeNumberToString($model->total_paid_real)
            ),
		'total_products',
//		'total_products_wt',
    array(
                'name' => 'total_shipping',
                'type' => 'number',
                'value'=> $model->total_shipping
            ),
        array(
                'name' => 'Tổng vận chuyển bằng chữ',
                'type' => 'html',
                'value'=> FinanceHelper::changeNumberToString($model->total_shipping)
            ),
//		'total_shipping_tax_incl',
//		'total_shipping_tax_excl',
//		'total_wrapping',
//		'total_wrapping_tax_incl',
//		'total_wrapping_tax_excl',
//		'invoice_number',
		'invoice_date',
//		'delivery_number',
		'delivery_date',
//		'date_add',
//		'date_upd',
),
)); ?>
<?php if(isset($model->id_address_delivery) && ($delivery = Address::model()->findByPk($model->id_address_delivery))):?>
<h1>Địa chỉ Giao Hàng [<?php echo $model->id_address_delivery; ?>]</h1>
<div class="widget">
    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model->idAddressDelivery,
'attributes'=>array(
		'id_address',
		'idCity.name',
    		'idZone.name',
		'address1',
		'phone'
),
)); ?>
</div>
<?php endif;?>

<?php if(isset($model->id_address_invoice) && ($invoice = Address::model()->findByPk($model->id_address_invoice))):?>
<h1>Địa chỉ Viết Hóa Đơn [<?php echo $model->id_address_invoice; ?>]</h1>
<div class="widget">
    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model->idAddressInvoice,
'attributes'=>array(
		'id_address',
		'idCity.name',
    		'idZone.name',
		'address1',
		'phone'
),
)); ?>
</div>
<?php endif;?>
<?php if(isset($model->id_carrier) && ($carrier = Carrier::model()->findByPk($model->id_carrier))):?>
<h1>Thông tin nhà vận chuyển [<?php echo $model->id_carrier; ?>]</h1>
<div class="widget">
    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model->idCarrier,
'attributes'=>array(
		'id_carrier',
		'name',
		'range_behavior',
		'is_free',
		'shipping_external',
		'shipping_method',
    array(
                'name' => 'Các Vùng Hổ Trợ',
                'type' => 'html',
                'value'=>$model->idCarrier->getStringZones(),
                'htmlOptions' => array('style' => 'width: 200px')
            ),
),
)); ?>
</div>
<?php endif;?>
<h1>Chi tiết Đơn hàng [<?php echo $model->secure_key; ?>]</h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $detail->searchByOrder($model->id_order),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Trong Đơn hàng ['.$model->secure_key.']. Hiển thị từ {start}-{end} của {count} kết quả.',
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
    'label'=>'Cập nhật đơn hàng ['.$model->secure_key.']',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("orders/update", array('id'=>$model->id_order)),
)); ?>