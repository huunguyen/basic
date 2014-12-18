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
                'value' => $model->idTax->name.' Mức thuế [<b>'.$model->idTax->rate.'</b>%]',
                'type' => 'html'),
            'on_sale',
            array('name' => 'min_quantity and quantity',
                'value' => $model->minimal_quantity . ' (' . $model->unity . ') và Tổng SL hiện tại ' . $model->quantity . ' (' . $model->unity . ')',
                'type' => 'html'),
            'price',
            'wholesale_price',
            'additional_shipping_cost',
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
            'out_of_stock',
            'customizable',
            'active',
            'show_price',
            'available_for_order',
            'available_date',
            array('name' => 'condition',
                'header' => $model->getAttributeLabel('condition'),
                'value' => Lookup::item("ConditionProduct", $model->condition),
                'type' => 'html'),
            array('name' => 'description_short',
                'header' => $model->getAttributeLabel('description_short'),
                'value' => $model->description_short,
                'type' => 'html'),
            array('name' => 'description',
                'header' => $model->getAttributeLabel('description'),
                'value' => $model->description,
                'type' => 'html'),
            'reference',
            'supplier_reference',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ),
    ));
    ?>
</div>
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $pro_att->searchByProduct($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả Sản phẩm [<b>'.$model->name.'</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idProduct.name', 'header' => 'Tên SP', 'value' => '$data["idProduct"]->name."[".$data["idProduct"]->id_product."]"'),
            array('name' => 'NameProduct', 'header' => 'Tên CT-SP', 'value' => '$data->getNameProduct()'),
            array('name' => 'price', 'header' => 'Giá cơ bản'),
            array('name' => 'wholesale_price', 'header' => 'Giá Sỉ'),
            array('name' => 'reference', 'header' => 'Tham khảo'),
            array('name' => 'supplier_reference', 'header' => 'Tham khảo NCC'),
            array('name' => 'id_product', 'header' => 'Tên SP'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("viewAttribute",array("id"=>$data["id_product_attribute"]))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("updateAttribute",array("id"=>$data["id_product_attribute"]))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("deleteAttribute",array("id"=>$data["id_product_attribute"]))',
                'htmlOptions' => array('style' => 'width: 20px; text-align: center; vertical-align: middle'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Mở rộng SP',
                'template' => '{combinations} {images} {features} {shipping} {suppliers} {warehouses} {quantities}',
                'buttons' => array
                    (
                    'combinations' => array
                        (
                        'label' => 'Nối Các thuộc tính',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/combinations", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'images' => array
                        (
                        'label' => 'Hình Ảnh',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/images", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'features' => array
                        (
                        'label' => 'Điểm nổi bật',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/features", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'shipping' => array
                        (
                        'label' => 'Phân phối',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/shipping", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'suppliers' => array
                        (
                        'label' => 'Nhà cung cấp',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/suppliers", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'warehouses' => array
                        (
                        'label' => 'Kho lưu trữ',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/warehouses", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                    'quantities' => array
                        (
                        'label' => 'Số lượng',
                        'icon' => 'user',
                        'url' => 'Yii::app()->createUrl("product/quantities", array("id"=>$data["id_product"]))',
                        'options' => array(
                            'class' => 'view',
                        ),
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: center; vertical-align: middle',
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
    'dataProvider' => $pro_att_com->searchByProduct($model->id_product),
    'pagerCssClass' => 'pagination pagination-right',
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Tất cả Sản phẩm. Hiển thị từ {start}-{end} của {count} kết quả.',
    'columns' => array(  
        array('name' => 'idProductAttribute.name', 'header' => 'Tên Sản Phẩm',
            'value' => '$data->idProductAttribute->getNameProduct()'
        ),
        array('name' => 'id_product_attribute', 'header' => 'Mã Thuộc Tính SP'),
        array('name' => 'id_attribute', 'header' => 'Mã Loại TT'),
        array('name' => 'idAttribute.name', 'header' => 'Tên Loại TT'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("view",array("id_attribute"=>$data["id_attribute"], "id_product_attribute"=>$data["id_product_attribute"]))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("update",array("id_attribute"=>$data["id_attribute"], "id_product_attribute"=>$data["id_product_attribute"]))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete",array("id_attribute"=>$data["id_attribute"], "id_product_attribute"=>$data["id_product_attribute"]))',
            'htmlOptions' => array('style' => 'width: 20px; text-align: center; vertical-align: middle'),
        ),
    ),
        )
);
?>
</div>
<span class="clear"></span>
    <?php
    // echo $this->renderPartial('_form_combinations', array('model' => $model,$com)); ?>