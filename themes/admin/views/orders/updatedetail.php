<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Cập nhật đơn hàng [<?php echo $model->id_order; ?>] [<?php echo $order->secure_key; ?>]</h1>

<?php echo $this->renderPartial('_detail', array('model' => $model)); ?>
<h1>Chi tiết Đơn hàng [<?php echo $order->secure_key; ?>]</h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $detail->searchByOrder($model->id_order),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Trong Đơn hàng [' . $order->secure_key . ']. Hiển thị từ {start}-{end} của {count} kết quả.',
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
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Xem Các Đơn Hàng Trong Hệ Thống',
    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("orders/index"),
));
?>