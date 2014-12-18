<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_employee',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_profile',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->passwordFieldRow($model,'passwd',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'last_passwd_gen',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'stats_date_from',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'stats_date_to',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'default_tab',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'id_last_order',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_last_customer_message',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_last_customer',array('class'=>'span5','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
