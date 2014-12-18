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
<span class="clear"></span>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => 'striped bordered condensed',
        'id' => 'product1-grid',
        'dataProvider' => $product1->searchByAccessory($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Phụ Kiện</b> cho Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("product/view", array("id"=>$data["id_product"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'name', 'header' => 'Tên NCC', 'value' => '$data["name"]."[".$data["id_product"]."]"'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo NCC'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{addAccessory}',
                'buttons' => array(
                    'addAccessory' => array(
                        'label' => 'Hủy Phụ Kiện với Sản phẩm',
                        'icon' => 'minus',
                        //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                        'url' => 'Yii::app()->createUrl("product/deleteAccessory", array("id_product_1"=>' . $model->id_product . ', "id_product_2"=>$data["id_product"]) )',
                        'click' => "function() {
                        if(!confirm('Bạn muốn xóa thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('product1-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);                                
                                $.fn.yiiGridView.update('product1-grid');
                                $.fn.yiiGridView.update('product2-grid');
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
    'id' => $autoid,
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
            'id' => 'product2-grid',
            'dataProvider' => $product2->searchByNoAccessory($model->id_product),
            'pagerCssClass' => 'pagination pagination-right',
            'template' => '{summary}{items}{pager}',
            'enablePagination' => true,
            'summaryText' => 'Tất cả <b>Nhà Kho Có Thể Thêm</b> thuộc Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
            'columns' => array(
                array(
                    'id' => 'p_autoId',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '50',
                ),
                array(
                    'name' => 'logo',
                    'header' => 'Ảnh',
                    'type' => 'html',
                    'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("product/view", array("id"=>$data["id_product"])), array("class"=>"highslide", "rel"=>"myrel"))',
                    'htmlOptions' => array('style' => 'width: 50px')
                ),
                array('name' => 'name', 'header' => 'Tên Kho Hàng', 'value' => '$data["name"]."[".$data["id_product"]."]"'),
                array('name' => 'date_add', 'header' => 'Ngày Tạo Kho Hàng'),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{addAccessory}',
                    'buttons' => array(
                        'addAccessory' => array(
                            'label' => 'Thêm Phụ Kiện Này Cho [Sản phẩm: ' . $model->name . ']',
                            'icon' => 'plus',
                            //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                            'url' => 'Yii::app()->createUrl("product/addAccessory", array("id_product_1"=>' . $model->id_product . ', "id_product_2"=>$data["id_product"]) )',
                            'click' => "function() {
                        if(!confirm('Bạn muốn thêm thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('product2-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('product1-grid');
                                $.fn.yiiGridView.update('product2-grid');
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
    <div class="form-actions">   
        <?php
        echo CHtml::ajaxSubmitButton('Thêm Phụ Kiện Cho Sản Phẩm', CHtml::normalizeUrl(array('product/addAccessory', 'id_product_1' => $model->id_product)), array(
            'error' => 'js:function(jqXHR, textStatus, errorThrown){
                                            alert(jqXHR.status + "" + textStatus + " - " + errorThrown);
                                        }',
            'beforeSend' => 'js:function( jqXHR, settings ){
                                        var $form = $("#"+autoid); 
                                        if(jQuery("input[name=\"p_autoId\[\]\"]:checked").length > 0) {                                            
                                            var p = jQuery("input[name=\"p_autoId\[\]\"]:checked");
                                            jQuery(p).each(function(){
                                                var name  = $(this).attr("id");
                                                var value = $(this).val();
                                                var type  = $(this).attr("type");
                                                if (type && type === "checkbox") {
                                                    if ($(this).prop("checked"))
                                                        plist.push($(this).val());
                                                    else
                                                        plist.splice(plist.indexOf($(this).val()), 1);
                                                }
                                            });
                                            
                                            plist.forEach(function(entry) {
                                                settings.url +=  "&p[]="+encodeURIComponent(entry); 
                                            });
                                            settings.url +=  "&rnd="+encodeURIComponent(Math.floor((Math.random() * 1000) + 1));  
                                            console.log(jqXHR);console.log(settings);
                                            return true;
                                        }
                                        else {
                                            alert("Thông Báo lúc:"+Math.floor((Math.random() * 1000) + 1)+"\nBạn chưa chọn dữ liệu chính xác!\nHãy chọn dữ liệu trong 2 bảng\n Sau đó mới Nhấn nút này một lần nữa");                                            
                                            return false;
                                        }                                      
                                       }',
            'success' => "js:function(data){    
                                        reloadGrid(data);
                                        }",
            'type' => 'post',
            //'dataType' => 'json',
            'cache' => 'false'
                ), array('class' => 'buttonS bLightBlue', 'id' => 'save-accessory-' . uniqid()));
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>  
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
                    array('name' => 'reference', 'header' => 'Tham khảo'),
                    array('name' => 'product_reference', 'header' => 'Tham khảo NCC'),
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
<span class="clear"></span>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Thêm loại cho sản phẩm',
    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("product/createAttribute", array("id" => $model->id_product)),
));
?>
<script type="text/javascript">
    var plist = [];
    function reloadGrid(data) {
        $.fn.yiiGridView.update('product1-grid');
        $.fn.yiiGridView.update('product2-grid');
    }
</script>