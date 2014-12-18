<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'comment-form',
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
    <legend></legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->ckEditorRow($model, 'content', array('options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>
    <?php echo $form->dropDownListRow($model, 'status', Lookup::items('StatusType'), array('prompt' => 'Chọn Trạng Thái')); ?>  

    <div class="form-actions">
        <?php echo $form->hiddenField($model, 'id_parent'); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>

