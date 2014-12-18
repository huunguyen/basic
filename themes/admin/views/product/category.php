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
                'value' => 'Giá Bán Lẻ: [' . $model->price . '] Giá Bán Sỉ: [' . $model->wholesale_price . '] Phát Sinh Thêm: [' . $model->additional_shipping_cost . ']',
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
                'value' => 'Hiện Tại Đang: [' . Lookup::item("OnSaleStatus", $model->on_sale) . '] Bán Vượt Kho: [' . Lookup::item("OutofStockStatus", $model->out_of_stock) . '] Hiện Giá: [' . Lookup::item("PriceStatus", $model->show_price) . '] Trạng Thái: [' . Lookup::item("ActiveStatus", $model->active) . '] ',
                'type' => 'html'),
            array('name' => 'condition',
                'header' => $model->getAttributeLabel('condition'),
                'value' => Lookup::item("ConditionProduct", $model->condition),
                'type' => 'html'),
        ),
    ));
    ?>
</div>

<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'product-category-grid',
        'dataProvider' => $category->searchByProduct($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Danh mục</b> cho Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("category/view", array("id"=>$data["id_category"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'name', 'header' => 'Tên Danh mục', 'value' => '$data["name"]."[".$data["id_category"]."]"'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo Danh mục'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{addCategory}',
                'buttons' => array(
                    'addCategory' => array(
                        'label' => 'Hủy Danh mục với Sản phẩm',
                        'icon' => 'minus',
                        //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                        'url' => 'Yii::app()->createUrl("product/deleteCategory", array("id_product"=>' . $model->id_product . ', "id_category"=>$data["id_category"]) )',
                        'click' => "function() {
                        if(!confirm('Bạn muốn xóa thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('category-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);                                
                                $.fn.yiiGridView.update('product-category-grid');
                                $.fn.yiiGridView.update('category-grid');
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
<?php $autoid = uniqid(); ?>
<script type="text/javascript">
    var baseUrl = "<?= Yii::app()->request->baseUrl ?>";
    var autoid = "<?= $autoid; ?>";
</script>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'product-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'beforeValidate' => "js:function(form) {
            return true;
        }",
        'afterValidate' => "js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'Bạn đã nhập thông tin nhưng chưa lưu lại trên server. Nếu bạn rời khỏi trang này lúc này dữ liệu bạn mới nhập sẽ mất và không được lưu lại';
                    return event.returnValue;
                });
                return false;
            }
            else {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = null;
                    return event.returnValue;
                });
                if(confirm('Dữ liệu bạn nhập đã chính xác. Bạn có muốn lưu thông tin này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<fieldset>    

    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'type' => 'striped bordered condensed',
            'id' => 'category-grid',
            'dataProvider' => $category->searchByNoProduct($model->id_product),
            'pagerCssClass' => 'pagination pagination-right',
            'template' => '{summary}{items}{pager}',
            'enablePagination' => true,
            'summaryText' => 'Tất cả <b>Danh mục Có Thể Thêm</b> thuộc Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
            'columns' => array(
                array(
                    'name' => 'logo',
                    'header' => 'Ảnh',
                    'type' => 'html',
                    'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("category/view", array("id"=>$data["id_category"])), array("class"=>"highslide", "rel"=>"myrel"))',
                    'htmlOptions' => array('style' => 'width: 50px')
                ),
                array('name' => 'name', 'header' => 'Tên Danh mục', 'value' => '$data["name"]."[".$data["id_category"]."]"'),
                array('name' => 'date_add', 'header' => 'Ngày Tạo Danh mục'),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{addCategory}',
                    'buttons' => array(
                        'addCategory' => array(
                            'label' => 'Thêm Danh mục đến Tất Cả [Sản phẩm: ' . $model->name . ']',
                            'icon' => 'plus',
                            //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                            'url' => 'Yii::app()->createUrl("product/addCategory", array("id_product"=>' . $model->id_product . ', "id_category"=>$data["id_category"]) )',
                            'click' => "function() {
                        if(!confirm('Bạn muốn thêm thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('category-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('category-grid');
                                $.fn.yiiGridView.update('product-category-grid');
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
                        'encodeLabel' => false,
                    ),
                ),
            )
        ));
        ?>
    </div>
<span class="clear"></span>
    <div class="widget">
        <?php
        if (isset($model->productAttributes) && count($model->productAttributes) > 0) {
            $this->widget('bootstrap.widgets.TbGridView', array(
                'type' => 'striped bordered condensed',
                'id' => 'product-attribute-grid',
                'dataProvider' => $pro_att->searchByProduct($model->id_product),
                'pagerCssClass' => 'pagination pagination-right',
                'template' => '{summary}{items}{pager}',
                'enablePagination' => true,
                'summaryText' => 'Tất cả <b>Loại</b> thuộc Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
                'columns' => array(
                    array('name' => 'idProduct.name', 'header' => 'Tên SP', 'value' => '$data["idProduct"]->name."[".$data["idProduct"]->id_product."]"'),
                    array('name' => 'NameProduct', 'header' => 'Tên CT-SP', 'value' => '$data->getNameProduct()'),
                    array('name' => 'price', 'header' => 'Giá cơ bản'),
                    array('name' => 'wholesale_price', 'header' => 'Giá Sỉ'),
                    array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
                        'header' => 'Quản lý',
                        'viewButtonUrl' => 'Yii::app()->controller->createUrl("viewAttribute",array("id"=>$data["id_product_attribute"]))',
                        'updateButtonUrl' => 'Yii::app()->controller->createUrl("updateAttribute",array("id"=>$data["id_product_attribute"]))',
                        'deleteButtonUrl' => 'Yii::app()->controller->createUrl("deleteAttribute",array("id"=>$data["id_product_attribute"]))',
                        'htmlOptions' => array('style' => 'width: 80px; text-align: center; vertical-align: middle'),
                    )
                )
            ));
        }
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>  
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Thêm loại cho sản phẩm',
    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("product/createAttribute", array("id" => $model->id_product)),
));
?>
<script type="text/javascript">
    var sglist = [];
    var paglist = [];
    function reloadGrid(data) {
        $.fn.yiiGridView.update('category-grid');
        $.fn.yiiGridView.update('product-category-grid');
        $.fn.yiiGridView.update('product-attribute-grid');
    }
</script>