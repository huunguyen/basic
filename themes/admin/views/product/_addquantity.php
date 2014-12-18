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
    <legend>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
        <?php echo $form->errorSummary($model); ?>
    </legend>    
    <?php echo $form->textFieldRow($model, 'old_quantity', array('disabled' => true, 'append' => '<i class="icon-tasks"></i>', 'class' => 'span5', 'autocomplete' => 'off')); ?>

    <?php echo $form->textFieldRow($model, 'quantity', array('disabled' => false, 'prepend' => '<i class="icon-asterisk"></i>', 'placeholder' => "Nhập vào số lượng SP muốn thêm vào", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php echo $form->textFieldRow($model, 'minimal_quantity', array('disabled' => false, 'prepend' => '<i class="icon-glass"></i>', 'placeholder' => "Nhập vào số lượng SP tối thiểu", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
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