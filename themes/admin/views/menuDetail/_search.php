<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_menu_detail',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_menu',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_parent',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'link',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'img',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'type',array('class'=>'span5','maxlength'=>8)); ?>

		<?php echo $form->textFieldRow($model,'position',array('class'=>'span5','maxlength'=>10)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
