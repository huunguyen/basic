<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'detail-form',
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
        ));
?>
<fieldset>
    <legend>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
        <?php echo $form->errorSummary($model); ?>
    </legend>


    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->textFieldRow($model, 'reference', array('append' => '<i class="icon-qrcode"></i>', 'placeholder' => "Vào số Chứng từ", 'class' => 'span5', 'maxlength' => 64)); ?>
    <?php echo $form->textFieldRow($model, 'name', array('append' => '<i class="icon-user"></i>', 'placeholder' => "Vào Tên hoặc Để Trống", 'class' => 'span5', 'maxlength' => 64)); ?>

    
    <?php echo $form->textFieldRow($model, 'unit_price_ratio_te', array('prepend' => '<i class="icon-hand-right"></i>', 'placeholder' => "Vào giá của một đơn vị sản phẩm", 'class' => 'span5', 'maxlength' => 64, 'onchange'=>'setprice()')); ?>
    <?php echo $form->textFieldRow($model, 'quantity_expected', array('append' => '<i class="icon-hand-left"></i>', 'placeholder' => "Vào số lượng sản phẩm", 'class' => 'span5', 'maxlength' => 64, 'onchange'=>'setprice()')); ?>
    <?php echo $form->textFieldRow($model, 'price_te', array('class' => 'span5', 'maxlength' => 64, 'disabled' => true)); ?>
    <?php echo $form->textFieldRow($model, 'wholesale_price_te', array('class' => 'span5', 'maxlength' => 64, 'disabled' => true)); ?>
</fieldset>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function setprice() {
        var ratio = $("#SupplyOrderDetail_unit_price_ratio_te").val();
        var quantity = $("#SupplyOrderDetail_quantity_expected").val();
        var total = quantity*ratio;
        $("#SupplyOrderDetail_price_te").val(total);
    }    
</script>