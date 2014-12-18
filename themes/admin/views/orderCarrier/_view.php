<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_order_carrier')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_order_carrier),array('view','id'=>$data->id_order_carrier)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_order')); ?>:</b>
	<?php echo CHtml::encode($data->id_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_carrier')); ?>:</b>
	<?php echo CHtml::encode($data->id_carrier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_order_invoice')); ?>:</b>
	<?php echo CHtml::encode($data->id_order_invoice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_cost_tax_excl')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_cost_tax_excl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_cost_tax_incl')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_cost_tax_incl); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('tracking_number')); ?>:</b>
	<?php echo CHtml::encode($data->tracking_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	*/ ?>

</div>