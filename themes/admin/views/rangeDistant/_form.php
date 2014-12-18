<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'range-distant-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'delimiter1',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'delimiter2',array('class'=>'span5','maxlength'=>20)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
