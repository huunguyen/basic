<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'reduction',array('class'=>'span5','maxlength'=>17)); ?>

	<?php echo $form->textFieldRow($model,'price_display_method',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'show_prices',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
