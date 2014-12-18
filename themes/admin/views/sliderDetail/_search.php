<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_slider_detail',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_slider',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'image',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'position',array('class'=>'span5','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
