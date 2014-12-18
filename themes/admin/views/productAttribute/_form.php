<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'product-attribute-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'supplier_reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'wholesale_price',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'weight',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'unit_price_impact',array('class'=>'span5','maxlength'=>17)); ?>

	<?php echo $form->textFieldRow($model,'default_on',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'minimal_quantity',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'available_date',array('class'=>'span5')); ?>

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
