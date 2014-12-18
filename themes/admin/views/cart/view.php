<?php 
$this->pageTitle = Yii::app()->name; 
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giỏ hàng'),
        ));
?>
<h1>View Cart #<?php echo $model->id_cart; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id_cart',
		'id_store',
		'id_carrier',
		'id_address_delivery',
		'id_address_invoice',
		'id_customer',
		'id_guest',
		'secure_key',
		'delivery_option',
		'recyclable',
		'gift',
		'gift_message',
		'allow_seperated_package',
		'date_add',
		'date_upd',
),
)); ?>

<h1>Chi tiết Giỏ hàng </h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $price->searchByCart($model->id_cart),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản Phẩm Trong Đơn hàng ['.$model->secure_key.']. Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'id_specific_price', 'header' => 'MDH'),
            array('name' => 'idSpecificPriceRule.name', 'header' => 'Mã AG'),
            array('name' => 'price', 'header' => 'Giá'),
            array('name' => 'idProduct.name', 'header' => 'Sản phẩm'),            
            array('name' => 'idProductAttribute.fullname', 'header' => 'Sản phẩm chi tiết'),
            array('name' => 'reduction', 'header' => 'Lượng giảm'),
            array('name' => 'reduction_type', 'header' => 'Loại'),
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
                            'url' => 'Yii::app()->createUrl("cart/viewPrice", array("id"=>$data["id_specific_price"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'del' => array(
                            'label' => 'Xóa NCC',
                            'icon' => 'icon-trash',
                            'url' => 'Yii::app()->createUrl("cart/deletePrice", array("id"=>$data["id_specific_price"]))',
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

<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Xem Các Đơn Hàng Trong Hệ Thống',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("orders/index"),
)); ?>