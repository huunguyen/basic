<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'order-invoice-form',
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

    <?php echo $form->textFieldRow($model, 'delivery_number', array('class' => 'span5')); ?>
    
    <?php
    echo $form->datepickerRow($model, 'delivery_date', array('hint' => 'Chọn ngày gửi hóa đơn.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value' => date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>
    
    <?php echo $form->textFieldRow($model, 'total_paid_tax_excl', array('class' => 'span5', 'maxlength' => 17)); ?>

    <?php echo $form->textFieldRow($model, 'total_shipping_tax_excl', array('class' => 'span5', 'maxlength' => 17)); ?>

    <?php echo $form->textFieldRow($model, 'total_wrapping_tax_excl', array('class' => 'span5', 'maxlength' => 17)); ?>

   <?php echo $form->markdownEditorRow($model, 'note', array('class' => 'span8', 'height' => '100px')); ?>

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