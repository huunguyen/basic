<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Đơn hàng'),
        ));
?>

<h1>Các hóa đơn đã xuất</h1>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Đơn hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idOrder.secure_key', 'header' => 'Mã Đơn hàng'),
             array(
                'name' => 'total_paid_tax_excl',
                'type' => 'number',
                'value'=> '$data["total_paid_tax_excl"]'
            ),
            array(
                'name' => 'total_shipping_tax_excl',
                'type' => 'number',
                'value'=> '$data["total_shipping_tax_excl"]'
            ),
            array(
                'name' => 'total_wrapping_tax_excl',
                'type' => 'number',
                'value'=> '$data["total_wrapping_tax_excl"]'
            ),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {email} {del}',
                    'buttons' => array
                        (
                        'show' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-eye-open',
                            'url' => 'Yii::app()->createUrl("invoice/view", array("id"=>$data["id_order_invoice"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật Đơn hàng',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("invoice/update", array("id"=>$data["id_order_invoice"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'email' => array
                            (
                            'label' => 'Gửi đến khách hàng',
                            'icon' => 'icon-email',
                            'url' => 'Yii::app()->createUrl("invoice/sentEmail", array("id"=>$data["id_order_invoice"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("invoice/delete", array("id"=>$data["id_order_invoice"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 80px; text-align: center;',
                    ),
                )
        ),
    ));
    ?>
</div>