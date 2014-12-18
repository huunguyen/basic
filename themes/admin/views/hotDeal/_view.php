<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'product-attribute-grid',
        'dataProvider' => $pro_att->searchByProduct($product->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Loại</b> thuộc Sản phẩm [<b>' . $product->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array('name' => 'idProduct.name', 'header' => 'Tên SP', 'value' => '$data["idProduct"]->name."[".$data["idProduct"]->id_product."]"'),
            array('name' => 'NameProduct', 'header' => 'Tên CT-SP', 'value' => '$data->getNameProduct()'),
            array('name' => 'price', 'header' => 'Giá cơ bản'),
            array('name' => 'wholesale_price', 'header' => 'Giá Sỉ'),
            array('name' => 'reference', 'header' => 'Tham khảo'),
            array('name' => 'supplier_reference', 'header' => 'Tham khảo NCC'),
            array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{add}',
                    'buttons' => array
                        (
                        'add' => array
                            (
                            'label' => 'Xem chi tiết',
                            'icon' => 'icon-document',
                            'url' => 'Yii::app()->createUrl("productHotDeal/addProductAttribute", array("id_hot_deal"=>"' . $model->id_hot_deal . '", "id_product"=>"' . $product->id_product . '", "id_product_attribute"=>$data["id_product_attribute"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        )
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 20px; text-align: center;',
                    ),
                )
        )
    ));
    ?>
</div>