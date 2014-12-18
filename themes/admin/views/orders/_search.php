<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_order',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_cart',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_address_delivery',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_address_invoice',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_parent',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'current_state',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'valid',array('class'=>'span5','maxlength'=>1)); ?>

		<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>9)); ?>

		<?php echo $form->textFieldRow($model,'secure_key',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'payment',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'gift',array('class'=>'span5')); ?>

		<?php echo $form->textAreaRow($model,'gift_message',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'shipping_number',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'total_paid',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_paid_tax_incl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_paid_tax_excl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_paid_real',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_products',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_products_wt',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_shipping',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_shipping_tax_incl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_shipping_tax_excl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_wrapping',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_wrapping_tax_incl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_wrapping_tax_excl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'invoice_number',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'invoice_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'delivery_number',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'delivery_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
