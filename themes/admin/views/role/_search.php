<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'salt',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'level',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'type',array('class'=>'span5')); ?>

		<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'bizrule',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'data',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
