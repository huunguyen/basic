<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'order-detail-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'id_order',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_warehouse',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'id_product_attribute',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'quantity_in_stock',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'quantity_refunded',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'quantity_return',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'quantity_reinjected',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'reduction_percent',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'reduction_amount',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'reduction_amount_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'reduction_amount_tax_excl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'supplier_reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'weight',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'total_price_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'total_price_tax_excl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'unit_price_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'unit_price_tax_excl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'total_shipping_price_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'total_shipping_price_tax_excl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'purchase_supplier_price',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'original_product_price',array('class'=>'span5','maxlength'=>20)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
