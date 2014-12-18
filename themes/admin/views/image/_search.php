<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_image',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'position',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'cover',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'legend',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
