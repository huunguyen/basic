<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'customer-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'id_default_group',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_risk',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'company',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->passwordFieldRow($model,'passwd',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'last_passwd_gen',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'birthday',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'website',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'secure_key',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'is_guest',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'deleted',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
