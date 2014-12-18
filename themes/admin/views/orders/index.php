<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>
<h1>Các Đơn hàng </h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $order->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Đơn hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
//            array('name' => 'id_order', 'header' => 'MDH'),
//            array('name' => 'id_cart', 'header' => 'MGH'),
            array('name' => 'secure_key', 'header' => 'Mã bảo mật'),
//            array('name' => 'total_paid', 'header' => 'Tổng tiền'),
             array(
                'name' => 'total_paid',
                'type' => 'number',
                'value'=> '$data["total_paid"]'
            ),
//            array('name' => 'total_products', 'header' => 'Tổng sản phẩm'),
           // array('name' => 'total_paid_real', 'header' => 'Tổng tiền thực trả'),
            array(
                'name' => 'total_paid_real',
                'type' => 'number',
                'value'=> '$data["total_paid_real"]'
            ),
//            array('name' => 'idCart.secure_key', 'header' => 'Mã Cart'),
            array('name' => 'idCarrier.name', 'header' => 'Nhà Vận chuyển'),
            array('name' => 'delivery_date', 'header' => 'Ngày Giao Hàng'),
            array('name' => 'currentState.name', 'header' => 'Trạng thái đơn hàng'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {invoice}{del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("orders/view", array("id"=>$data["id_order"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Đơn hàng',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("orders/update", array("id"=>$data["id_order"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'invoice' => array
                            (
                            'label' => 'Xuất thông tin đơn hàng',
                            'icon' => 'icon-briefcase',
                            'url' => 'Yii::app()->createUrl("orders/invoice", array("id"=>$data["id_order"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("orders/delete", array("id"=>$data["id_order"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
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
<h1>Các Giỏ Hàng </h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $cart->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà cung cấp. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
//            array('name' => 'id_cart', 'header' => 'MDH'),
            array('name' => 'secure_key', 'header' => 'Mã Cart'),
            array(
                'name' => 'idAddressDelivery.fulladdress', 
                'header' => 'Đ/c Chuyển hàng',
                'value' => '$data->idAddressDelivery["fulladdress"]',
                'type' => 'html'
                ),
            array(
                'name' => 'idAddressInvoice.fulladdress', 
                'header' => 'Đ/c Hóa đơn',
                'value' => '$data->idAddressInvoice["fulladdress"]',
                'type' => 'html'
                ),
            array('name' => 'date_add', 'header' => 'Ngày tạo'),
            array('name' => 'idCarrier.name', 'header' => 'Nhà Vận chuyển'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("cart/view", array("id"=>$data["id_cart"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
//                        'modify' => array
//                            (
//                            'label' => 'Cập nhật NCC',
//                            'icon' => 'icon-document',
//                            'url' => 'Yii::app()->createUrl("cart/update", array("id"=>$data["id_cart"]))',
//                            'options' => array(
//                                'class' => 'view',
//                            ),
//                            'encodeLabel' => false,
//                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("cart/delete", array("id"=>$data["id_cart"]))',
                            'click' => "function() {
                                if(!confirm('Bạn muốn xóa giỏ hàng này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
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
<?php
//$o = new Orders;
//$r = $o->setCart(134);
//dump($o);