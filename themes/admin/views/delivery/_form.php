<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'delivery-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'range_price',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'range_weight',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'range_distant',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
