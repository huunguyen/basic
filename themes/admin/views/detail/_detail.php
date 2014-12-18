
	<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($model,'question',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'answer',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'share_state',array('class'=>'span5','maxlength'=>7)); ?>


	<?php echo $form->textFieldRow($model,'company',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'birthday',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'site',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'gender',array('class'=>'span5','maxlength'=>6)); ?>
