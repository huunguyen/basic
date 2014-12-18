<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'image-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'position',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cover',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'legend',array('class'=>'span5','maxlength'=>45)); ?>

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
