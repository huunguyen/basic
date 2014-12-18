<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'advise-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'create_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_guest',array('class'=>'span5','maxlength'=>10)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
