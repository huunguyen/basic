<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'order-carrier-form',
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
    <legend>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
        <?php echo $form->errorSummary($model); ?>
    </legend>    

    <?php //echo $form->dropDownListRow($model, 'method', Lookup::items('MethodType'), array('hint' => 'Chọn Phương Pháp Tính','onchange'=>'setInput($("#OrderCarrier_method").val())')); ?>    
    <?php
    echo $form->dropDownListRow($model, 'method', Lookup::items('MethodType'), array(
        'prompt' => 'Chọn Phương pháp tính giá vận chuyển',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('carrier/updateRanges'),
            'dataType' => 'json',
            'data' => array('method' => 'js:this.value', 'id_carrier' => $model->id_carrier),
            'success' => 'function(data) {                
                          console.log(data);
                          setInput($("#OrderCarrier_method").val())
                          $("#OrderCarrier__id_range").html(data.dropDown); 
                            if(flag){
                                $("#OrderCarrier__id_range").change();                            
                            }
                            else {
                            flag =true;
                            $("#OrderCarrier__id_range").val(' . $model->_id_range . ');
                            }
                        }',
            'cache' => false
        )
            )
    );
    ?>    
    <?php
    echo $form->dropDownListRow($model, '_id_range');
    ?>
    <?php echo $form->textFieldRow($model, 'weight', array('class' => 'span5', 'maxlength' => 64)); ?>        
    <?php echo $form->textFieldRow($model, 'distant', array('class' => 'span5', 'maxlength' => 64)); ?>    
    <?php echo $form->textFieldRow($model, 'price', array('class' => 'span5', 'maxlength' => 64)); ?>    

    <div class="control-group ">
        <label class="control-label" for="OrderCarrier_cal"></label>
        <div class="controls">   
            <?php
            echo $form->hiddenField($model, 'id_order');
            echo $form->hiddenField($model, 'id_carrier');
            echo CHtml::ajaxSubmitButton('Tính Chi Phí Vận Chuyển Cho Đơn Hàng [' . $order->secure_key . ']', CHtml::normalizeUrl(array('carrier/calShipCost', 'id_order' => $model->id_order, 'id_carrier' => $model->id_carrier)), array(
                'error' => 'js:function(jqXHR, textStatus, errorThrown){
                                            alert(jqXHR.status + "" + textStatus + " - " + errorThrown);
                                        }',
                'beforeSend' => 'js:function( jqXHR, settings ){
                                        var method  = $("#OrderCarrier_method").val();
                                        var weight  = parseInt($("#OrderCarrier_weight").val());
                                        var distant = parseInt($("#OrderCarrier_distant").val());
                                        var price   = parseInt($("#OrderCarrier_price").val());
                                        var methods = ["weight", "distant", "price", "complex"];
                                        if( methods.indexOf(method)>=0 )  {                                              
                                            switch(methods.indexOf(method)) {
                                                case 0:
                                                    if(isNaN(weight)||(weight<=0)) { alert("Lỗi nhập liệu"); return false;} 
                                                    settings.url +=  "&value="+encodeURIComponent(weight);
                                                    break;
                                                case 1:
                                                    if(isNaN(distant)||(distant<=0)) { alert("Lỗi nhập liệu"); return false;} 
                                                    settings.url +=  "&value="+encodeURIComponent(distant);
                                                    break;
                                                case 2:
                                                    if(isNaN(price)||(price<=0)) { alert("Lỗi nhập liệu"); return false;} 
                                                    settings.url +=  "&value="+encodeURIComponent(price);
                                                    break;
                                                default:
                                                    if((isNaN(weight)&&isNaN(distant)&&isNaN(price))||(weight<=0)&&(distant<=0)&&(price<=0)) { alert("Lỗi nhập liệu"); return false;} 
                                                    settings.url +=  "&weight="+encodeURIComponent(weight);
                                                    settings.url +=  "&distant="+encodeURIComponent(distant);
                                                    settings.url +=  "&price="+encodeURIComponent(price);
                                                    break;
                                            }
                                            return true;
                                        }
                                        else { alert("Lỗi nhập liệu"); return false;}                                 
                                       }',
                'success' => 'js:function(data){  
                                        console.log(data);
                                        $("#OrderCarrier_shipping_cost_tax_excl").val(data["cost"]);
                                        }',
                'type' => 'post',
                // 'dataType' => 'json',
                'update' => '#data',
                'cache' => 'false'
                    ), array('class' => 'buttonS bLightBlue', 'id' => 'cal-' . uniqid()));
            ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($model, 'shipping_cost_tax_excl', array('class' => 'span5', 'maxlength' => 64)); ?>    

</fieldset>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ?  'Tạo mới' : 'Lưu lại',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    var flag = false;

    function setInput(method) {
        switch (method) {
            case "weight":
                $("#OrderCarrier_weight").prop('disabled', false);
                $("#OrderCarrier_distant").prop('disabled', true);
                $("#OrderCarrier_price").prop('disabled', true);
                break;
            case "distant":
                $("#OrderCarrier_weight").prop('disabled', true);
                $("#OrderCarrier_distant").prop('disabled', false);
                $("#OrderCarrier_price").prop('disabled', true);
                break;
            case "price":
                $("#OrderCarrier_weight").prop('disabled', true);
                $("#OrderCarrier_distant").prop('disabled', true);
                $("#OrderCarrier_price").prop('disabled', false);
                break;
            default:
                $("#OrderCarrier_weight").prop('disabled', false);
                $("#OrderCarrier_distant").prop('disabled', false);
                $("#OrderCarrier_price").prop('disabled', false);
                break;
        }
    }
</script>
<?php
Yii::app()->clientScript->registerScript(
        'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($model, 'method') . '").change();
    });'
);
?>