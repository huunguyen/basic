<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_cart')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_cart),array('view','id'=>$data->id_cart)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_store')); ?>:</b>
	<?php echo CHtml::encode($data->id_store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_carrier')); ?>:</b>
	<?php echo CHtml::encode($data->id_carrier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_address_delivery')); ?>:</b>
	<?php echo CHtml::encode($data->id_address_delivery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_address_invoice')); ?>:</b>
	<?php echo CHtml::encode($data->id_address_invoice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_customer')); ?>:</b>
	<?php echo CHtml::encode($data->id_customer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_guest')); ?>:</b>
	<?php echo CHtml::encode($data->id_guest); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('secure_key')); ?>:</b>
	<?php echo CHtml::encode($data->secure_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_option')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_option); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recyclable')); ?>:</b>
	<?php echo CHtml::encode($data->recyclable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gift')); ?>:</b>
	<?php echo CHtml::encode($data->gift); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gift_message')); ?>:</b>
	<?php echo CHtml::encode($data->gift_message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allow_seperated_package')); ?>:</b>
	<?php echo CHtml::encode($data->allow_seperated_package); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	*/ ?>

</div>