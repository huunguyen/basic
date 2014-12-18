<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_order_invoice',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_order',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'number',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'delivery_number',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'delivery_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'total_paid_tax_excl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_paid_tax_incl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_products',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_products_wt',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_shipping_tax_excl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_shipping_tax_incl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_wrapping_tax_excl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_wrapping_tax_incl',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

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
