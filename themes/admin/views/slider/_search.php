<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_slider',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_supplier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_category',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_manufacturer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'height',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'width',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'fill',array('class'=>'span5','maxlength'=>7)); ?>

		<?php echo $form->textFieldRow($model,'duration',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'auto',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'continuous',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'controls',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
