<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'isEmailVisible',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'isScreenNameEditable',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'deactivationTime',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fullName',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'initials',array('class'=>'span5','maxlength'=>16)); ?>

	<?php echo $form->textFieldRow($model,'occupation',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'birthDate',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'textStatus',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textAreaRow($model,'secretQuestion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'secretAnswer',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'administratorNote',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
