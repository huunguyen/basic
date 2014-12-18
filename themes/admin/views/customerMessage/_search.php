<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_customer_message',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_customer_thread',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_user',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textAreaRow($model,'message',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'file_name',array('class'=>'span5','maxlength'=>18)); ?>

		<?php echo $form->textFieldRow($model,'ip_address',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'user_agent',array('class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'private',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
