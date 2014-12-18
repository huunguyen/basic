<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_warehouse')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_warehouse),array('view','id'=>$data->id_warehouse)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_currency')); ?>:</b>
	<?php echo CHtml::encode($data->id_currency); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_address')); ?>:</b>
	<?php echo CHtml::encode($data->id_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_employee')); ?>:</b>
	<?php echo CHtml::encode($data->id_employee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference')); ?>:</b>
	<?php echo CHtml::encode($data->reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deleted')); ?>:</b>
	<?php echo CHtml::encode($data->deleted); ?>
	<br />


</div>