<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_delivery',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_carrier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'range_price',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'range_weight',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'range_distant',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
