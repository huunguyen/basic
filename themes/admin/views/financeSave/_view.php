<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('finance_save_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->finance_save_name),array('view','id'=>$data->finance_save_name)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finance_save_value')); ?>:</b>
	<?php echo CHtml::encode($data->finance_save_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finance_save_string')); ?>:</b>
	<?php echo CHtml::encode($data->finance_save_string); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('finance_save_info')); ?>:</b>
	<?php echo CHtml::encode($data->finance_save_info); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('check_time')); ?>:</b>
	<?php echo CHtml::encode($data->check_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('check_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->check_user_id); ?>
	<br />

	*/ ?>

</div>