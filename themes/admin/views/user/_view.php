<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_user')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_user),array('view','id'=>$data->id_user)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passwd')); ?>:</b>
	<?php echo CHtml::encode($data->passwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password_strategy')); ?>:</b>
	<?php echo CHtml::encode($data->password_strategy); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('password_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->password_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_passwd_gen')); ?>:</b>
	<?php echo CHtml::encode($data->last_passwd_gen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stats_date_from')); ?>:</b>
	<?php echo CHtml::encode($data->stats_date_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stats_date_to')); ?>:</b>
	<?php echo CHtml::encode($data->stats_date_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_role')); ?>:</b>
	<?php echo CHtml::encode($data->default_role); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('roles')); ?>:</b>
	<?php echo CHtml::encode($data->roles); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_level')); ?>:</b>
	<?php echo CHtml::encode($data->max_level); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('salt')); ?>:</b>
	<?php echo CHtml::encode($data->salt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requires_new_password')); ?>:</b>
	<?php echo CHtml::encode($data->requires_new_password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_attempts')); ?>:</b>
	<?php echo CHtml::encode($data->login_attempts); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_time')); ?>:</b>
	<?php echo CHtml::encode($data->login_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_ip')); ?>:</b>
	<?php echo CHtml::encode($data->login_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('validation_key')); ?>:</b>
	<?php echo CHtml::encode($data->validation_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('verified')); ?>:</b>
	<?php echo CHtml::encode($data->verified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	*/ ?>

</div>