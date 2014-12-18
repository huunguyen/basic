<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_employee')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_employee),array('view','id'=>$data->id_employee)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_profile')); ?>:</b>
	<?php echo CHtml::encode($data->id_profile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passwd')); ?>:</b>
	<?php echo CHtml::encode($data->passwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_passwd_gen')); ?>:</b>
	<?php echo CHtml::encode($data->last_passwd_gen); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('stats_date_from')); ?>:</b>
	<?php echo CHtml::encode($data->stats_date_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stats_date_to')); ?>:</b>
	<?php echo CHtml::encode($data->stats_date_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_tab')); ?>:</b>
	<?php echo CHtml::encode($data->default_tab); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_last_order')); ?>:</b>
	<?php echo CHtml::encode($data->id_last_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_last_customer_message')); ?>:</b>
	<?php echo CHtml::encode($data->id_last_customer_message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_last_customer')); ?>:</b>
	<?php echo CHtml::encode($data->id_last_customer); ?>
	<br />

	*/ ?>

</div>