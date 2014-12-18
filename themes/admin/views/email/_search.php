<?php
/* @var $this EmailController */
/* @var $model Email */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emailto'); ?>
		<?php echo $form->textField($model,'emailto',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emailfrom'); ?>
		<?php echo $form->textField($model,'emailfrom',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emailcc'); ?>
		<?php echo $form->textField($model,'emailcc',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'emailbcc'); ?>
		<?php echo $form->textField($model,'emailbcc',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attachfile'); ?>
		<?php echo $form->textField($model,'attachfile',array('size'=>60,'maxlength'=>256)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branchstore_id'); ?>
		<?php echo $form->textField($model,'branchstore_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'receiver_date'); ?>
		<?php echo $form->textField($model,'receiver_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'check_date'); ?>
		<?php echo $form->textField($model,'check_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_update'); ?>
		<?php echo $form->textField($model,'last_update'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->