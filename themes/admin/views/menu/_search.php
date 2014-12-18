<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_menu',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_store',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_supplier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_manufacturer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'menu_type',array('class'=>'span5','maxlength'=>9)); ?>

		<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
