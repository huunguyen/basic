<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_customer_message')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_customer_message),array('view','id'=>$data->id_customer_message)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_customer_thread')); ?>:</b>
	<?php echo CHtml::encode($data->id_customer_thread); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_user')); ?>:</b>
	<?php echo CHtml::encode($data->id_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_name')); ?>:</b>
	<?php echo CHtml::encode($data->file_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip_address')); ?>:</b>
	<?php echo CHtml::encode($data->ip_address); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_agent')); ?>:</b>
	<?php echo CHtml::encode($data->user_agent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('private')); ?>:</b>
	<?php echo CHtml::encode($data->private); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	*/ ?>

</div>