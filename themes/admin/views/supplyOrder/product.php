<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Nhập hàng'),
        ));
?>

<h1>Xem đơn hàng #<?php echo $model->id_supply_order; ?></h1>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            'idSupplier.name',
            'idWarehouse.name',
            'idSupplyOrderState.name',
            'reference',
            'date_add',
            'date_upd',
            'date_delivery_expected',
            array('name' => 'total_te', 'header' => 'Tổng tiền chưa thuế',
                    'htmlOptions' => array('style' => 'width: auto'),
                    'type' => 'number',
                ),
            'total_te_string',
            'total_tax',
            'total_ti',
    
        ),
    ));
    ?>
</div>
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
            array(
                'name' => 'unit_price_ratio_te',
                'type' => 'number',
                'value'=> '$data["unit_price_ratio_te"]'
            ),
            array('name' => 'quantity_expected', 'header' => 'Số lượng'),
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
    )
        )
        );
?>
<fieldset>   

    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'type' => 'striped bordered condensed',
            'id' => 'product1-grid',
            'dataProvider' => $product->searchBySupplier($model->id_supplier),
            'pagerCssClass' => 'pagination pagination-right',
            'template' => '{summary}{items}{pager}',
            'enablePagination' => true,
            'summaryText' => 'Sản phẩm Của Nhà Cung Cấp [<b>' . $model->idSupplier->name . '</b>]. Hiển thị từ {start}-{end} của {count} kết quả.',
            'columns' => array(
                array(
                    'id' => 'p_autoId',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '50',
                ),
                array(
                    'name' => 'img',
                    'header' => 'Ảnh',
                    'type' => 'html',
                    'value' => 'CHtml::link( CHtml::image($data->thumbnail,"",array("class"=>"img-rounded", "style"=>"width:50px;height:50px;")), Yii::app()->createUrl("product/view", array("id"=>$data["id_product"])), array("class"=>"highslide", "rel"=>"myrel"))',
                    'htmlOptions' => array('style' => 'width: 50px')
                ),
                array('name' => 'name', 'header' => 'Tên SP'),
                array('name' => 'idCategoryDefault.name', 'header' => 'Danh Mục'),                
                array(
                'name' => 'price',
                'type' => 'number',
                'value'=> '$data["price"]'
            ),
                array(
                'name' => 'wholesale_price',
                'type' => 'number',
                'value'=> '$data["wholesale_price"]'
            ),
               array(
                'name' => 'unit_price_ratio',
                'type' => 'number',
                'value'=> '$data["unit_price_ratio"]'
            ),
                array('name' => 'idTax.name', 'header' => 'Thuế',
                    'value' => '$data["idTax"]->name."<br/><b>". $data["idTax"]->rate. "%</b>"',
                    'type' => 'html'
                ),
                array('name' => 'condition', 'header' => 'Loại Hàng',
                    'value' => 'Lookup::item("ConditionProduct", $data["condition"])'
                ),
                array('name' => 'active',
                    'header' => 'Trạng Thái',
                    'value' => 'Lookup::item("ActiveStatus", $data->active)',
                    'type' => 'html'),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Xử lý',
                    'template' => '{show} {add}',
                    'buttons' => array
                        (
                        'show' => array(
                            'label' => 'Xem chi tiết sản phẩm',
                            'icon' => 'plus-sign',
                            //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                            'url' => 'Yii::app()->createUrl("supplyOrder/loadAttributes", array("id_supply_order"=>' . $model->id_supply_order . ', "id_product"=>$data["id_product"]) )',
                            'click' => "function() {                       
                        $.fn.yiiGridView.update('product2-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(data) {
                                console.log(data);
                                $.fn.yiiGridView.update('product1-grid');
                                $.fn.yiiGridView.update('product2-grid');
                                $('#load').html(data);
                            },
                            error:function(data) {
                                console.log(data);                                
                            }
                        });
                        return false;
                        }",
                        ),
                        'add' => array(
                            'label' => 'Thêm Sản phẩm vào đơn hàng',
                            'icon' => 'shopping-cart',
                            //'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-dialog.png',
                            'url' => 'Yii::app()->createUrl("supplyOrder/addProduct", array("id_supply_order"=>' . $model->id_supply_order . ', "id_product"=>$data["id_product"]) )',
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
                        'style' => 'width: 20px; text-align: center; vertical-align: middle',
                    ),
                ),
            ),
        ));
        ?>
    </div>


    <div class="form-actions">   
        <?php
        echo CHtml::ajaxSubmitButton('Thêm Sản Phẩm Vào Đơn Hàng', CHtml::normalizeUrl(array('supplyOrder/addProduct', 'id_supply_order' => $model->id_supply_order)), array(
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
                console.log(data);
                                        reloadGrid(data);
                                        }",
            'type' => 'post',
            //'dataType' => 'json',
            'cache' => 'false'
                ), array('class' => 'buttonS bLightBlue', 'id' => 'save-order-' . uniqid()));
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>  
<script type="text/javascript">
    var plist = [];
    function reloadGrid(data) {
        $.fn.yiiGridView.update('product1-grid');
        $.fn.yiiGridView.update('product2-grid');
    }
</script>
<div class="widget" id="load">
    
</div>