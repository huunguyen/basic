<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhập hàng'),
        ));
?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary} {items} {pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Nhà sản xuất. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(            
            array('name' => 'reference', 'header' => 'Tham khảo'),
            array('name' => 'idSupplier.name', 'header' => 'Nhà cung cấp'),
            array('name' => 'idWarehouse.name', 'header' => 'Kho hàng'),   
            array('name' => 'idSupplyOrderState.name', 'header' => 'Trạng thái'), 
            //array('name' => 'date_add', 'header' => 'Ngày tạo'), 
            array(
                'name' => 'date_add',
                'type' => 'vndatetime',
                'value'=> '$data["date_add"]'
            ),
            //array('name' => 'date_upd', 'header' => 'Ngày thay đổi'), 
            array(
                'name' => 'date_upd',
                'type' => 'vndatetime',
                'value'=> '$data["date_upd"]'
            ),
            array('name' => 'date_delivery_expected', 'header' => 'Ngày giao hàng'), 
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{show} {modify} {product} {del}',
                'buttons' => array
                    (
                    'show' => array
                        (
                        'label' => 'Xem chi tiết',
                        'icon' => 'icon-eye-open',
                        'url' => 'Yii::app()->createUrl("supplyOrder/view", array("id"=>$data["id_supply_order"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'modify' => array
                        (
                        'label' => 'Cập nhật Đơn Hàng',
                        'icon' => 'icon-document',
                        'url' => 'Yii::app()->createUrl("supplyOrder/update", array("id"=>$data["id_supply_order"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),  
                    'product' => array
                        (
                        'label' => 'Cập nhật Hàng',
                        'icon' => 'icon-tasks',
                        'url' => 'Yii::app()->createUrl("supplyOrder/product", array("id"=>$data["id_supply_order"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                        'encodeLabel' => false,
                    ),  
                    'del' => array(
                        'label' => 'Xóa Đơn Hàng',
                        'icon' => 'icon-trash',
                        'url' => 'Yii::app()->createUrl("supplyOrder/delete", array("id"=>$data["id_supply_order"]))',
                        'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: center;',
                ),
            ),
        ),
    ));
    ?>
</div>