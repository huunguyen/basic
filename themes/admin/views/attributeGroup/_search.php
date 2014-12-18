<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_attribute_group',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'is_color_group',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'group_type',array('class'=>'span5','maxlength'=>6)); ?>

		<?php echo $form->textFieldRow($model,'position',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'public_name',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
