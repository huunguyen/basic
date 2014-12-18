<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'deleted',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'shipping_handling',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'range_behavior',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'is_free',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'shipping_external',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'need_range',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'shipping_method',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'position',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'max_width',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'max_height',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'max_depth',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'max_weight',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'grade',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'delay',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
