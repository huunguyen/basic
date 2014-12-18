<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_supply_order',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_supplier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'supplier_name',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'id_warehouse',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_supply_order_state',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_delivery_expected',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'total_te',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'total_with_discount_te',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'total_tax',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'total_ti',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'discount_rate',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'discount_value_te',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'is_template',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
