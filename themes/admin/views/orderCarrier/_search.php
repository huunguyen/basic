<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_order_carrier',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'id_order',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_order_invoice',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'weight',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'shipping_cost_tax_excl',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'shipping_cost_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'tracking_number',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
