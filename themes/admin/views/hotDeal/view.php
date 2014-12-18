<?php
$this->pageTitle = Yii::app()->name;
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Giá Rẻ Mỗi Ngày'),
        ));
?>
<div class="widget">
    <?php
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            //'id_hot_deal',
            'name',
            'description',
            'date_add',
            'pp_giao_sp',
            'dc_giao_sp',
            array('name' => 'Thông Tin Bổ Sung',
                'value' => $model->getStringInfo(),
                'type' => 'html'),
        ),
    ));
    ?>
</div>
<br/>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Thêm Chương Trình Khuyến Mãi Mỗi Ngày',
    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => Yii::app()->createUrl("hotDeal/create", array("id" => $model->id_hot_deal)),
));
?>
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
    <div id='AjFlash' class="flash-success" style="display:none"></div>
    <div class="widget">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'type' => 'striped bordered condensed',
            'id' => 'product-grid',
            'dataProvider' => $product->search(),
            'pagerCssClass' => 'pagination pagination-right',
            'template' => '{summary}{items}{pager}',
            'enablePagination' => true,
            'summaryText' => 'Tất cả Sản phẩm. Hiển thị từ {start}-{end} của {count} kết quả.',
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
                array('name' => 'price', 'header' => 'Giá cơ bản'),
                array('name' => 'wholesale_price', 'header' => 'Giá Sỉ'),
                array('name' => 'unit_price_ratio', 'header' => 'Gía/DVT'),
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
                    'header' => 'Chi Tiết SP',
                    'template' => '{attributes}',
                    'buttons' => array
                        (
                        'attributes' => array(
                'label' => 'Chọn [Sản Phẩm] để thêm đến CT Khuyến Mãi',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/mainnav/list.png',
                'url' => 'Yii::app()->createUrl("hotDeal/product", array("id"=>"'.$model->id_hot_deal.'", "id_product"=>$data["id_product"]))',
                'click' => "function(){
                                    $.fn.yiiGridView.update('product-grid', {
                                        type:'POST',
                                        url:$(this).attr('href'),
                                        success:function(data) {
                                              console.log(data);
                                              $('#attributes').html(data).fadeIn(2000);
                                              $.fn.yiiGridView.update('product-grid');
                                        }
                                    });
                                    return false;
                              }
                     ",
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
<?php
    $criteria = new CDbCriteria();
    $today = new DateTime('now');
    $current = $today->format('Y-m-d H:i:s');
    $criteria->compare('t.to','>='. $current, true);
    $criteria->order = 't.to DESC';
    echo $form->dropDownListRow($model, 'rule', CHtml::listData(SpecificPriceRule::model()->findAll($criteria), 'id_specific_price_rule', 'fullname'), array(
        'prompt' => 'Chọn Qui Luật Áp Giá Cho SP Giá Rẻ Mỗi Ngày',
            )
    );
    ?>   
    <div class="form-actions">   
        <?php
        echo $form->hiddenField($model, 'id_hot_deal');
        ?>
        <?php
        echo CHtml::ajaxSubmitButton('Thêm Các [Sản Phẩm Chính] Đến CTKM', CHtml::normalizeUrl(array('hotDeal/products', 'id' => $model->id_hot_deal, 'act' => 'parent')), array(
            'error' => 'js:function(jqXHR, textStatus, errorThrown){
                                            alert(jqXHR.status + "" + textStatus + " - " + errorThrown);
                                        }',
            'beforeSend' => 'js:function( jqXHR, settings ){
                                        var rule = $("#HotDeal_rule").val();
                                        if( (jQuery("input[name=\"p_autoId\[\]\"]:checked").length > 0) && (rule!="") )  {                                            
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
                                            settings.url +=  "&rule="+encodeURIComponent(rule); 
                                            settings.url +=  "&rnd="+encodeURIComponent(Math.floor((Math.random() * 1000) + 1));  
                                            console.log(jqXHR);console.log(settings);
                                            return true;
                                        }
                                        else {
                                            if(flag){
                                                alert("Thông Báo lúc:"+Math.floor((Math.random() * 1000) + 1)+"\nBạn chưa chọn dữ liệu chính xác!\nHãy chọn dữ liệu trong 2 bảng\n Sau đó mới Nhấn nút này một lần nữa");    
                                                //flag = false;
                                            }
                                                     
                                            return false;
                                        }                                      
                                       }',
            'success' => "js:function(data){  
                                        reloadGrid(data);
                                        }",
            'type' => 'post',
            //'dataType' => 'json',
            'update' => '#data',
            'cache' => 'false'
                ), array('class' => 'buttonS bLightBlue', 'id' => 'save-' . uniqid()));
        ?>
        <?php
        echo CHtml::ajaxSubmitButton('Thêm Các Sản Phẩm [Bao Gồm SP Cùng Loại] Đến CTKM', CHtml::normalizeUrl(array('hotDeal/products', 'id' => $model->id_hot_deal, 'act' => 'childs')), array(
            'error' => 'js:function(jqXHR, textStatus, errorThrown){
                                            alert(jqXHR.status + "" + textStatus + " - " + errorThrown);
                                        }',
            'beforeSend' => 'js:function( jqXHR, settings ){
                                        var rule = $("#HotDeal_rule").val();
                                        if( (jQuery("input[name=\"p_autoId\[\]\"]:checked").length > 0) && (rule!="") )  {                                            
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
                                            settings.url +=  "&rule="+encodeURIComponent(rule); 
                                            settings.url +=  "&rnd="+encodeURIComponent(Math.floor((Math.random() * 1000) + 1));  
                                            console.log(jqXHR);console.log(settings);
                                            return true;
                                        }
                                        else {
                                            if(flag){
                                                alert("Thông Báo lúc:"+Math.floor((Math.random() * 1000) + 1)+"\nBạn chưa chọn dữ liệu chính xác!\nHãy chọn dữ liệu trong 2 bảng\n Sau đó mới Nhấn nút này một lần nữa");    
                                                //flag = false;
                                            }
                                                     
                                            return false;
                                        }                                      
                                       }',
            'success' => "js:function(data){    
                                        reloadGrid(data);
                                        }",
            'type' => 'post',
            //'dataType' => 'json',
            'update' => '#data',
            'cache' => 'false'
                ), array('class' => 'buttonS bLightBlue', 'id' => 'save-' . uniqid()));
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>  
<script type="text/javascript">
    var flag = true;
    var plist = [];
    function reloadGrid(data) {
        $.fn.yiiGridView.update('product-grid');
        $.fn.yiiGridView.update('product-hot-deal-grid');
    }
</script>
<div id="attributes">
    
</div>
<div id="data">
    <?php echo $this->renderPartial('_progrid', array('model'=>$model, 'pro_hot_deal'=>$pro_hot_deal)); ?>
</div>