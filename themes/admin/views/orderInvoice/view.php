<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Chi tiết hóa đơn #<?php echo $model->id_order_invoice; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'delivery_date',
        'total_paid_tax_excl',
        array(
            'name' => 'Tổng tiền trả bằng chữ',
            'type' => 'html',
            'value' => FinanceHelper::changeNumberToString($model->total_paid_tax_excl)
        ),
        'total_shipping_tax_excl',
        array(
            'name' => 'Tổng vận chuyển bằng chữ',
            'type' => 'html',
            'value' => FinanceHelper::changeNumberToString($model->total_shipping_tax_excl)
        ),
        'total_wrapping_tax_excl',
        array(
            'name' => 'Tổng cộng thêm bằng chữ',
            'type' => 'html',
            'value' => FinanceHelper::changeNumberToString($model->total_wrapping_tax_excl)
        ),
        'note',
    ),
));
?>


<h1>Đơn hàng #[<?php echo $order->id_order; ?>] Mã Hàng [<?php echo $order->secure_key; ?>]</h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $order,
    'attributes' => array(
        'id_order',
        'idCarrier.name',
        'id_address_delivery',
        'id_address_invoice',
        'current_state',
        'reference',
        'secure_key',
        'gift',
        'gift_message',
        array(
            'name' => 'total_paid',
            'type' => 'number',
            'value' => $order->total_paid
        ),
        array(
            'name' => 'Tổng tiền trả bằng chữ',
            'type' => 'html',
            'value' => FinanceHelper::changeNumberToString($order->total_paid)
        ),
//		'total_paid_tax_incl',
//		'total_paid_tax_excl',
        array(
            'name' => 'total_paid_real',
            'type' => 'number',
            'value' => $order->total_paid_real
        ),
        array(
            'name' => 'Tổng thực trả bằng chữ',
            'type' => 'html',
            'value' => FinanceHelper::changeNumberToString($order->total_paid_real)
        ),
        array(
            'name' => 'total_shipping',
            'type' => 'number',
            'value' => $order->total_shipping
        ),
        array(
            'name' => 'Tổng vận chuyển bằng chữ',
            'type' => 'html',
            'value' => FinanceHelper::changeNumberToString($order->total_shipping)
        ),
        'invoice_date',
        'delivery_date',
    ),
));
?>
    <?php if (isset($order->id_address_delivery) && ($delivery = Address::model()->findByPk($order->id_address_delivery))): ?>
    <h1>Địa chỉ Giao Hàng [<?php echo $order->id_address_delivery; ?>]</h1>
    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $order->idAddressDelivery,
            'attributes' => array(
                'id_address',
                'idCity.name',
                'idZone.name',
                'address1',
                'phone'
            ),
        ));
        ?>
    </div>
    <?php endif; ?>

    <?php if (isset($order->id_address_invoice) && ($invoice = Address::model()->findByPk($order->id_address_invoice))): ?>
    <h1>Địa chỉ Viết Hóa Đơn [<?php echo $order->id_address_invoice; ?>]</h1>
    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $order->idAddressInvoice,
            'attributes' => array(
                'id_address',
                'idCity.name',
                'idZone.name',
                'address1',
                'phone'
            ),
        ));
        ?>
    </div>
    <?php endif; ?>
    <?php if (isset($order->id_carrier) && ($carrier = Carrier::model()->findByPk($order->id_carrier))): ?>
    <h1>Thông tin nhà vận chuyển [<?php echo $order->id_carrier; ?>]</h1>
    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $order->idCarrier,
            'attributes' => array(
                'id_carrier',
                'name',
                'range_behavior',
                'is_free',
                'shipping_external',
                'shipping_method',
                array(
                    'name' => 'Các Vùng Hổ Trợ',
                    'type' => 'html',
                    'value' => $order->idCarrier->getStringZones(),
                    'htmlOptions' => array('style' => 'width: 200px')
                ),
            ),
        ));
        ?>
    </div>
    <?php endif; ?>

<h1>Chi tiết Đơn hàng [<?php echo $order->secure_key; ?>]</h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbExtendedGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'invoice-grid',
        'ajaxUpdate' => true, // This is it.
        'dataProvider' => $detail->searchByOrder($order->id_order),
        'template' => '{summary}{items}{pager}{extendedSummary}',
        'enablePagination' => true,
        'summaryText' => 'Thống kê Tài chánh. Hổ Trợ Bộ Lọc Theo Ngày Tháng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'price', 'header' => 'Tổng sản phẩm'),
            array('name' => 'quantity', 'header' => 'Tổng sản phẩm'),
            array('name' => 'unit_price_tax_incl', 'header' => 'Gía mỗi sản phẩm'),
            array('name' => 'total_price_tax_incl', 'header' => 'Tổng giá'),
        ),
        'extendedSummary' => array(
            'title' => 'Tổng số tiền',
            'columns' => array(
                'total_price_tax_incl' => array(
                    'label' => 'Thành tiền',
                    'class' => 'TbSumOperation',
                ),
            )
        ),
        'extendedSummaryOptions' => array(
            'class' => 'well pull-right',
            'style' => 'width:300px'
        ),
    ));
    ?>
</div>