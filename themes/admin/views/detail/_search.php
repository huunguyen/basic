<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_detail',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_user',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'question',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'answer',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'share_state',array('class'=>'span5','maxlength'=>7)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'company',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'birthday',array('class'=>'span5')); ?>

		<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'site',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>6)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
