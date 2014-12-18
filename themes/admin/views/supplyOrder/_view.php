<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_supply_order')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_supply_order),array('view','id'=>$data->id_supply_order)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_supplier')); ?>:</b>
	<?php echo CHtml::encode($data->id_supplier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_name')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_warehouse')); ?>:</b>
	<?php echo CHtml::encode($data->id_warehouse); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_supply_order_state')); ?>:</b>
	<?php echo CHtml::encode($data->id_supply_order_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference')); ?>:</b>
	<?php echo CHtml::encode($data->reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_delivery_expected')); ?>:</b>
	<?php echo CHtml::encode($data->date_delivery_expected); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_te')); ?>:</b>
	<?php echo CHtml::encode($data->total_te); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_with_discount_te')); ?>:</b>
	<?php echo CHtml::encode($data->total_with_discount_te); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_tax')); ?>:</b>
	<?php echo CHtml::encode($data->total_tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_ti')); ?>:</b>
	<?php echo CHtml::encode($data->total_ti); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_rate')); ?>:</b>
	<?php echo CHtml::encode($data->discount_rate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_value_te')); ?>:</b>
	<?php echo CHtml::encode($data->discount_value_te); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_template')); ?>:</b>
	<?php echo CHtml::encode($data->is_template); ?>
	<br />

	*/ ?>

</div>