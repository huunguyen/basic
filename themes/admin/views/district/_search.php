<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_district',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'id_city',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'iso_code',array('class'=>'span5','maxlength'=>7)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
