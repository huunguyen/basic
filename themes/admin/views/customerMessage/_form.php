<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'customer-message-form',
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
    
    <?php echo $form->textFieldRow($model,'user_agent',array('class'=>'span5','maxlength'=>128)); ?>
    
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>

    <?php echo $form->markdownEditorRow($model, 'message', array('class' => 'span8', 'height' => '100px')); ?>

    <?php
    echo $form->toggleButtonRow($model, 'private', array(
        'enabledLabel' => 'Công khai',
        'disabledLabel' => 'Riêng tư'
            )
    );
    ?>

</fieldset>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'icon' => 'ok white',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'icon' => 'email white',
        'label' => $model->isNewRecord ? 'Tạo mới & Gửi thông tin đến khách hàng' : 'Lưu lại & Gửi thông tin đến khách hàng',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>