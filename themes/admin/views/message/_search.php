<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'content',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'attach_file',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'zone',array('class'=>'span5','maxlength'=>6)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>9)); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
