<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'detail-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_detail',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_user',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'question',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'answer',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'share_state',array('class'=>'span5','maxlength'=>7)); ?>

	<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'company',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'birthday',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'site',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>6)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
