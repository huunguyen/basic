<?php
/* @var $this EmailController */
/* @var $model Email */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'emailto'); ?>
		<?php echo $form->textField($model,'emailto',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'emailto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emailfrom'); ?>
		<?php echo $form->textField($model,'emailfrom',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'emailfrom'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emailcc'); ?>
		<?php echo $form->textField($model,'emailcc',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'emailcc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'emailbcc'); ?>
		<?php echo $form->textField($model,'emailbcc',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'emailbcc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attachfile'); ?>
		<?php echo $form->textField($model,'attachfile',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'attachfile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'branchstore_id'); ?>
		<?php echo $form->textField($model,'branchstore_id'); ?>
		<?php echo $form->error($model,'branchstore_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receiver_date'); ?>
		<?php echo $form->textField($model,'receiver_date'); ?>
		<?php echo $form->error($model,'receiver_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'check_date'); ?>
		<?php echo $form->textField($model,'check_date'); ?>
		<?php echo $form->error($model,'check_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_update'); ?>
		<?php echo $form->textField($model,'last_update'); ?>
		<?php echo $form->error($model,'last_update'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->