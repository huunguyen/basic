<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhà vận chuyển'),
        ));
?>

<h1>Thông tin nhà vận chuyển #<?php echo $model->id_carrier; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'name',
    array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => CHtml::link( CHtml::image($model->thumbnail,'',array('class'=>'img-rounded', 'style'=>'width:50px;height:50px;')), Yii::app()->createUrl('carrier/view', array('id'=>$model->id_carrier)), array('class'=>'highslide', 'rel'=>'myrel')),
                'htmlOptions' => array('style' => 'width: 50px')
            ),
		'url',
		'shipping_handling',
		'range_behavior',
		'is_free',
		'shipping_external',
		'need_range',
		'shipping_method',
    array(
                'name' => 'Các Vùng Hổ Trợ',
                'type' => 'raw',
                'value'=> $model->getStringZones()
            ),
		'max_width',
		'max_height',
		'max_depth',
		'max_weight'
),
)); ?>
<h1>Các Đơn hàng </h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $order->searchByCarrier($model->id_carrier),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Đơn hàng. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'id_order', 'header' => 'MDH'),
            array('name' => 'id_cart', 'header' => 'MGH'),
            array('name' => 'secure_key', 'header' => 'Mã bảo mật'),
            array('name' => 'total_paid', 'header' => 'Tổng tiền'),
            array('name' => 'total_products', 'header' => 'Tổng sản phẩm'),
            array('name' => 'total_paid_real', 'header' => 'Tổng tiền thực trả'),
            array('name' => 'idCart.secure_key', 'header' => 'Mã Cart'),
            array('name' => 'idCarrier.name', 'header' => 'Nhà phân phối'),
            array('name' => 'delivery_date', 'header' => 'Ngày Giao Hàng'),
            array('name' => 'currentState.name', 'header' => 'Trạng thái đơn hàng'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{show} {modify} {delivery}',
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
                            'label' => 'Cập nhật NCC',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("carrier/uDelivery", array("id"=>$data["id_order"],"id_carrier"=>$data["id_carrier"]))',
                            'options' => array(
                                'class' => 'view',
                                'visible'=>  false,
                            ),                            
                            'encodeLabel' => false,
                        ),
                        'delivery' => array(
                            'label' => 'Giao hàng',
                            'icon' => 'icon-gift',
                            'url' => 'Yii::app()->createUrl("carrier/delivery", array("id"=>$data["id_order"],"id_carrier"=>$data["id_carrier"]))',
                            'click' => "function() {
                        if(!confirm('Bạn muốn xử lý giao hàng cho đang hàng này? rnd=' + Math.floor((Math.random()*100)+1))) return false;
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
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem Nhà phân phối - Nhà Vận chuyển Có Trong Hệ Thống',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("carrier/index"),
)); ?>