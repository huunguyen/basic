<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'zone-form',
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
<p class="help-block">Các trường có dấu <span class="required">*</span> phải được nhập.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20, 'disabled' => true)); ?>

	<?php echo $form->textFieldRow($model,'from_quantity',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'reduction',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->dropDownListRow($model, 'reduction_type', Lookup::items('ReductionType'), array('prompt' => 'Chọn một loại'));?>   
	
<?php
    echo $form->datepickerRow($model, 'from', array('hint' => 'Chọn ngày bắt đầu áp dụng.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value'=>date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>

<?php
    echo $form->datepickerRow($model, 'to', array('hint' => 'Chọn ngày Kết thúc áp dụng.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value'=>date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
