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
        'id' => 'product-supplier-grid',
        'dataProvider' => $supplier->searchByProduct($model->id_product),
        'pagerCssClass' => 'pagination pagination-right',
        'template' => '{summary}{items}{pager}',
        'enablePagination' => true,
        'summaryText' => 'Tất cả <b>Nhà Cung Cấp</b> cho Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
        'columns' => array(
            array(
                'name' => 'logo',
                'header' => 'Ảnh',
                'type' => 'html',
                'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("supplier/view", array("id"=>$data["id_supplier"])), array("class"=>"highslide", "rel"=>"myrel"))',
                'htmlOptions' => array('style' => 'width: 50px')
            ),
            array('name' => 'name', 'header' => 'Tên NCC', 'value' => '$data["name"]."[".$data["id_supplier"]."]"'),
            array('name' => 'date_add', 'header' => 'Ngày Tạo NCC'),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'header' => 'Quản trị',
                'template' => '{addSupplier}',
                'buttons' => array(
                    'addSupplier' => array(
                        'label' => 'Hủy Nhà Cung Cấp với Sản phẩm',
                        'icon' => 'minus',
                        //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                        'url' => 'Yii::app()->createUrl("product/deleteSupplier", array("id_product"=>' . $model->id_product . ', "id_supplier"=>$data["id_supplier"]) )',
                        'click' => "function() {
                        if(!confirm('Bạn muốn xóa thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('supplier-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);                                
                                $.fn.yiiGridView.update('product-supplier-grid');
                                $.fn.yiiGridView.update('supplier-grid');
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
            'id' => 'supplier-grid',
            'dataProvider' => $supplier->searchByNoProduct($model->id_product),
            'pagerCssClass' => 'pagination pagination-right',
            'template' => '{summary}{items}{pager}',
            'enablePagination' => true,
            'summaryText' => 'Tất cả <b>Nhà Cung Cấp Có Thể Thêm</b> thuộc Sản phẩm [<b>' . $model->name . '</b>] Hiển thị từ {start}-{end} của {count} kết quả.',
            'columns' => array(
                array(
                    'id' => 'sg_autoId',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '50',
                ),
                array(
                    'name' => 'logo',
                    'header' => 'Ảnh',
                    'type' => 'html',
                    'value' => 'CHtml::link(CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("supplier/view", array("id"=>$data["id_supplier"])), array("class"=>"highslide", "rel"=>"myrel"))',
                    'htmlOptions' => array('style' => 'width: 50px')
                ),
                array('name' => 'name', 'header' => 'Tên NCC', 'value' => '$data["name"]."[".$data["id_supplier"]."]"'),
                array('name' => 'date_add', 'header' => 'Ngày Tạo NCC'),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{addSupplier}',
                    'buttons' => array(
                        'addSupplier' => array(
                            'label' => 'Thêm NCC đến Tất Cả [Sản phẩm: ' . $model->name . ']',
                            'icon' => 'plus',
                            //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                            'url' => 'Yii::app()->createUrl("product/addSupplier", array("id_product"=>' . $model->id_product . ', "id_supplier"=>$data["id_supplier"]) )',
                            'click' => "function() {
                        if(!confirm('Bạn muốn thêm thuộc tính này?')) return false;
                        $.fn.yiiGridView.update('supplier-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('supplier-grid');
                                $.fn.yiiGridView.update('product-supplier-grid');
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
                    array(
                        'id' => 'pag_autoId',
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '50',
                    ),
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
                )
            ));
        }
        ?>
    </div>
<span class="clear"></span>
    <div class="form-actions">   
        <?php
        echo CHtml::ajaxSubmitButton('Thêm Nhà Cung Cấp Cho Các Mặc Hàng', CHtml::normalizeUrl(array('product/addSupplier', 'id_product' => $model->id_product)), array(
            'error' => 'js:function(jqXHR, textStatus, errorThrown){
                                            alert(jqXHR.status + "" + textStatus + " - " + errorThrown);
                                        }',
            'beforeSend' => 'js:function( jqXHR, settings ){
                                        var $form = $("#"+autoid); 
                                        if( (jQuery("input[name=\"sg_autoId\[\]\"]:checked").length > 0) && (jQuery("input[name=\"pag_autoId\[\]\"]:checked").length > 0) ) {                                            
                                            var sg = jQuery("input[name=\"sg_autoId\[\]\"]:checked");
                                            var pag = jQuery("input[name=\"pag_autoId\[\]\"]:checked");
                                            jQuery(sg).each(function(){
                                                var name  = $(this).attr("id");
                                                var value = $(this).val();
                                                var type  = $(this).attr("type");
                                                if (type && type === "checkbox") {
                                                    if ($(this).prop("checked"))
                                                        sglist.push($(this).val());
                                                    else
                                                        sglist.splice(sglist.indexOf($(this).val()), 1);
                                                }
                                            });
                                            jQuery(pag).each(function(){
                                                var name  = $(this).attr("id");
                                                var value = $(this).val();
                                                var type  = $(this).attr("type");
                                                if (type && type === "checkbox") {
                                                    if ($(this).prop("checked"))
                                                        paglist.push($(this).val());
                                                    else
                                                        paglist.splice(paglist.indexOf($(this).val()), 1);
                                                }
                                            });
                                            sglist.forEach(function(entry) {
                                                settings.url +=  "&sg[]="+encodeURIComponent(entry); 
                                            });
                                            paglist.forEach(function(entry) {
                                                settings.url +=  "&pag[]="+encodeURIComponent(entry); 
                                            });
                                            settings.url +=  "&rnd="+encodeURIComponent(Math.floor((Math.random() * 1000) + 1));  
                                            console.log(jqXHR);console.log(settings);
                                            return true;
                                        }
                                        else {
                                            alert("Thông Báo lúc:"+Math.floor((Math.random() * 1000) + 1)+"\nBạn chưa chọn dữ liệu chính xác!\nHãy chọn dữ liệu trong 2 bảng\n Sau đó mới Nhấn nút này một lần nữa");
                                            if( jQuery("input[name=\"sg_autoId\[\]\"]:checked").length > 0 ) {                                            
                                                var sg = jQuery("input[name=\"sg_autoId\[\]\"]:checked");
                                                sglist = [];
                                                jQuery(sg).each(function(){
                                                    var name  = $(this).attr("id");
                                                    var value = $(this).val();
                                                    var type  = $(this).attr("type");
                                                    if (type && type === "checkbox") {
                                                        if ($(this).prop("checked"))
                                                            sglist.push($(this).val());
                                                        else
                                                            sglist.splice(sglist.indexOf($(this).val()), 1);
                                                    }
                                                });
                                                console.log(sglist);
                                            }
                                            if( jQuery("input[name=\"pag_autoId\[\]\"]:checked").length > 0 ) {                                            
                                                var pag = jQuery("input[name=\"pag_autoId\[\]\"]:checked");  
                                                paglist = [];
                                                jQuery(pag).each(function(){
                                                    var name  = $(this).attr("id");
                                                    var value = $(this).val();
                                                    var type  = $(this).attr("type");
                                                    if (type && type === "checkbox") {
                                                        if ($(this).prop("checked"))
                                                            paglist.push($(this).val());
                                                        else
                                                            paglist.splice(paglist.indexOf($(this).val()), 1);
                                                    }
                                                });
                                                console.log(paglist);
                                            }
                                            return false;
                                        }                                      
                                       }',
            'success' => "js:function(data){    
                                        reloadGrid(data);
                                        }",
            'type' => 'post',
            //'dataType' => 'json',
            'cache' => 'false'
                ), array('class' => 'buttonS bLightBlue', 'id' => 'save-supplier' . uniqid()));
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
        $.fn.yiiGridView.update('supplier-grid');
        $.fn.yiiGridView.update('product-supplier-grid');
        $.fn.yiiGridView.update('product-attribute-grid');
    }
</script>