<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'custommer_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'manager_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'books_id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'transaction_info',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'amount_string',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'methodsofpayment',array('class'=>'span5','maxlength'=>13)); ?>

	<?php echo $form->textFieldRow($model,'extraofpayments',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'extraofpayments_string',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'payment_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'extrapayment_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>14)); ?>

	<?php echo $form->textFieldRow($model,'last_update',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'log_update',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
