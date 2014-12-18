<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_pack_group',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'description_short',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'total_paid',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'total_paid_real',array('class'=>'span5','maxlength'=>17)); ?>

		<?php echo $form->textFieldRow($model,'available_for_order',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'available_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'reduction_type',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'reduction',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
