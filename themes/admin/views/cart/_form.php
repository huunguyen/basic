<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'cart-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_store',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_address_delivery',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_address_invoice',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_guest',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'secure_key',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'delivery_option',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'recyclable',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'gift',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'gift_message',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'allow_seperated_package',array('class'=>'span5')); ?>

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
