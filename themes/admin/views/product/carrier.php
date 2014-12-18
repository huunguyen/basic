<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'sản phẩm'),
        ));
?>

<h5>Chi tiết Sản Phẩm [<?php echo $model->id_product; ?>] <b><?php echo $model->name; ?></b></h5>
<div class="widget">
<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'name',
        array('name' => 'Nhà cung cấp',
            'value' => $model->idSupplierDefault->name,
            'type' => 'html'),
        array('name' => 'Nhà sản xuất',
            'value' => $model->idManufacturer->name,
            'type' => 'html'),
        array('name' => 'Phân mục',
            'value' => $model->idCategoryDefault->name,
            'type' => 'html'),
        array('name' => 'Thuế',
            'value' => $model->idTax->name,
            'type' => 'html'),        
        array('name' => 'min_quantity and quantity',
            'value' => $model->minimal_quantity . ' (' . $model->unity . ') và Tổng SL hiện tại ' . $model->quantity . ' (' . $model->unity . ')',
            'type' => 'html'),
        array('name' => 'Thông Tin Về Giá',
            'value' => 'Giá Bán Lẻ: ['.$model->price.'] Giá Bán Sỉ: ['.$model->wholesale_price.'] Phát Sinh Thêm: ['.$model->additional_shipping_cost.']',
            'type' => 'html'),  
        array('name' => 'Giá cuối cùng',
            'value' => $model->price + $model->additional_shipping_cost . ' (' . $model->minimal_quantity . '/' . $model->unity . ')',
            'type' => 'html'),
        array('name' => 'unit_price_ratio',
            'value' => $model->unit_price_ratio . ' (' . $model->minimal_quantity . '/' . $model->unity . ')',
            'type' => 'html'),
        array('name' => 'WxHxD(cm) and W(cm)',
            'header' => $model->getAttributeLabel('WxHxDxW'),
            'value' => $model->width . 'x' . $model->height . 'x' . $model->depth . ' and ' . $model->weight,
            'type' => 'html'),
        array('name' => 'Thông Tin Trạng Thái',
            'value' => 'Hiện Tại Đang: ['.  Lookup::item("OnSaleStatus", $model->on_sale).'] Bán Vượt Kho: ['.Lookup::item("OutofStockStatus", $model->out_of_stock).'] Hiện Giá: ['.Lookup::item("PriceStatus", $model->show_price).'] Trạng Thái: ['.Lookup::item("ActiveStatus", $model->active).'] ',
            'type' => 'html'), 
        array('name' => 'condition',
            'header' => $model->getAttributeLabel('condition'),
            'value' => Lookup::item("ConditionProduct", $model->condition),
            'type' => 'html'),
    ),
));
?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'product-carrier-grid',
        'dataProvider' => $carrier->searchByProduct($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Nhà Phân Phối</b> cho Sản phẩm [<b>'.$model->name.'</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên NPP', 'value'=>'$data["name"]."[".$data["id_carrier"]."]"'),
            array('name' => 'is_free', 'header' => 'Miễn Phí'),
            array('name' => 'delay', 'header' => 'Thời Gian Chờ'),
            array(
                'name' => 'tblZones',
                'header' => 'Các Vùng Hổ Trợ',
                'type' => 'html',
                'value'=>array($this, 'getStringFromZones'),
                'htmlOptions' => array('style' => 'width: 200px')
            ),
            array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Quản trị',
        'template' => '{addCarrier}',
        'buttons' => array (
             'addCarrier' => array(
                'label' => 'Hủy Nhà Phân Phối với Sản phẩm',
                'icon' => 'minus',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("product/deleteCarrier", array("id_product"=>'.$model->id_product.', "id_carrier"=>$data["id_carrier"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn xóa thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('carrier-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);                                
                                $.fn.yiiGridView.update('product-carrier-grid');
                                $.fn.yiiGridView.update('carrier-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: 40px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));   
    ?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'carrier-grid',
        'dataProvider' => $carrier->searchByNoProduct($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Nhà Phân Phối Có Thể Thêm</b> thuộc Sản phẩm [<b>'.$model->name.'</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'name', 'header' => 'Tên NPP', 'value'=>'$data["name"]."[".$data["id_carrier"]."]"'),
            array('name' => 'is_free', 'header' => 'Miễn Phí'),
            array('name' => 'delay', 'header' => 'Thời Gian Chờ'),
            array(
                'name' => 'tblZones',
                'header' => 'Các Vùng Hổ Trợ',
                'type' => 'html',
                'value'=>array($this, 'getStringFromZones'),
                'htmlOptions' => array('style' => 'width: 200px')
            ),
            array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Quản trị',
        'template' => '{addCarrier}',
        'buttons' => array (
             'addCarrier' => array(
                'label' => 'Thêm đến sản phẩm',
                'icon' => 'plus',
                //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                'url' => 'Yii::app()->createUrl("product/addCarrier", array("id_product"=>'.$model->id_product.', "id_carrier"=>$data["id_carrier"]) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn thêm thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('carrier-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('carrier-grid');
                                $.fn.yiiGridView.update('product-carrier-grid');
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: 40px; text-align: center; vertical-align: middle',
        ),
    ),
        ),
    ));   
    ?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    if(isset($model->productAttributes) && count($model->productAttributes)>0){
        $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $pro_att->searchByProduct($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Loại</b> thuộc Sản phẩm [<b>'.$model->name.'</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idProduct.name', 'header' => 'Tên SP', 'value' => '$data["idProduct"]->name."[".$data["idProduct"]->id_product."]"'),
            array('name' => 'NameProduct', 'header' => 'Tên CT-SP', 'value' => '$data->getNameProduct()'),
            array('name' => 'price', 'header' => 'Giá cơ bản'),
            array('name' => 'wholesale_price', 'header' => 'Giá Sỉ'),
            array('name' => 'reference', 'header' => 'Tham khảo'),
            array('name' => 'supplier_reference', 'header' => 'Tham khảo NCC'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản lý',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("viewAttribute",array("id"=>$data["id_product_attribute"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("updateAttribute",array("id"=>$data["id_product_attribute"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("deleteAttribute",array("id"=>$data["id_product_attribute"]))',
                'htmlOptions' => array('style' => 'width: 80px; text-align: center; vertical-align: middle'),
            )
        ),
    ));
    }    
    ?>
</div>
<span class="clear"></span>
<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Thêm loại cho sản phẩm',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("product/createAttribute", array("id"=>$model->id_product)),
)); ?>