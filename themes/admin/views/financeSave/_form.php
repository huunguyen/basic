<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'finance-save-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'finance_save_name',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'finance_save_value',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'finance_save_string',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textAreaRow($model,'finance_save_info',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'check_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'check_user_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
