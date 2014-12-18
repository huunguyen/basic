<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'hot-deal-value-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_hot_deal',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'custom_name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'custom_value',array('class'=>'span5','maxlength'=>45)); ?>

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
