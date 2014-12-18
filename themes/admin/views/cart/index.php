<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giỏ hàng'),
        ));
?>

<h1>Carts</h1>

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
            array('name' => 'id_cart', 'header' => 'MDH'),
            array('name' => 'secure_key', 'header' => 'Mã Cart'),
            array('name' => 'id_address_delivery', 'header' => 'Đ/c Chuyển hàng'),
            array('name' => 'id_address_invoice', 'header' => 'Đ/c Hóa đơn'),
            array('name' => 'date_add', 'header' => 'Ngày tạo'),
            array('name' => 'idCarrier.name', 'header' => 'Nhà phân phối'),
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