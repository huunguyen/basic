<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id),array('view','id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passwordHint')); ?>:</b>
	<?php echo CHtml::encode($data->passwordHint); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isEmailVisible')); ?>:</b>
	<?php echo CHtml::encode($data->isEmailVisible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isScreenNameEditable')); ?>:</b>
	<?php echo CHtml::encode($data->isScreenNameEditable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deactivationTime')); ?>:</b>
	<?php echo CHtml::encode($data->deactivationTime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fullName')); ?>:</b>
	<?php echo CHtml::encode($data->fullName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('initials')); ?>:</b>
	<?php echo CHtml::encode($data->initials); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('occupation')); ?>:</b>
	<?php echo CHtml::encode($data->occupation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthDate')); ?>:</b>
	<?php echo CHtml::encode($data->birthDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textStatus')); ?>:</b>
	<?php echo CHtml::encode($data->textStatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secretQuestion')); ?>:</b>
	<?php echo CHtml::encode($data->secretQuestion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('secretAnswer')); ?>:</b>
	<?php echo CHtml::encode($data->secretAnswer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('administratorNote')); ?>:</b>
	<?php echo CHtml::encode($data->administratorNote); ?>
	<br />

	*/ ?>

</div>