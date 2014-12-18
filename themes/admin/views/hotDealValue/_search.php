<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_hot_deal_value',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_hot_deal',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'custom_name',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'custom_value',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
