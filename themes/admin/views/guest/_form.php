<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'guest-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'salt',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'password_strategy',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'requires_new_password',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'login_attempts',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'login_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'login_ip',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'validation_key',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'create_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
