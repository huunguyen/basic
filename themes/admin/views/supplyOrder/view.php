<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhập hàng'),
        ));
?>

<h1>Xem đơn hàng #<?php echo $model->id_supply_order; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'idSupplier.name',
		'idWarehouse.name',
		'idSupplyOrderState.name',
		'reference',
    array(
                'name' => 'date_add',
                'type' => 'vndatetime',
                'value'=> $model->date_add
            ),
            array(
                'name' => 'date_upd',
                'type' => 'vndatetime',
                'value'=> $model->date_upd
            ),
		'date_delivery_expected',
    array('name' => 'total_te', 'header' => 'Tổng tiền chưa thuế',
                    'htmlOptions' => array('style' => 'width: auto'),
                    'type' => 'number',
                ),
    'total_te_string'
),
)); ?>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'product2-grid',
        'dataProvider' => $pro_order->searchByOrder($model->id_supply_order),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Mục Đã Thêm</b> thuộc Đơn Hàng [<b>???</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link(CHtml::image($data->idProduct->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("product/view", array("id"=>$data["id_product"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'idProduct.name', 'header' => 'Tên SPhẩm'),
            array('name' => 'idProductAttribute.fullname', 'header' => 'Loại SPhẩm'),
            //array('name' => 'unit_price_ratio_te', 'header' => 'Giá Mỗi SP'),
            array(
                'name' => 'unit_price_ratio_te',
                'type' => 'number',
                'value'=> '$data["unit_price_ratio_te"]'
            ),
            array('name' => 'quantity_expected', 'header' => 'Số lượng'),
            //array('name' => 'price_te', 'header' => 'Tổng Giá SP'),
            array(
                'name' => 'price_te',
                'type' => 'number',
                'value'=> '$data["price_te"]'
            ),
            array('name' => 'reference', 'header' => 'Tham khảo'),
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
                            'url' => 'Yii::app()->createUrl("supplyOrder/viewDetail", array("id"=>$data["id_supply_order_detail"], "id_supply_order" => '.$model->id_supply_order.'))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("supplyOrder/updateDetail", array("id"=>$data["id_supply_order_detail"], "id_supply_order" => '.$model->id_supply_order.'))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("supplyOrder/deleteDetail", array("id"=>$data["id_supply_order_detail"], "id_supply_order" => '.$model->id_supply_order.'))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
                        }",
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 120px; text-align: center;',
                    ),
                )
        )
    ));
    ?>
</div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Chỉnh sửa lại đơn hàng',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("supplyOrder/product", array("id"=>$model->id_supply_order)),
)); ?>
