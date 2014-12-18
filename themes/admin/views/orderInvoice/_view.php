<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_order_invoice')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_order_invoice),array('view','id'=>$data->id_order_invoice)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_order')); ?>:</b>
	<?php echo CHtml::encode($data->id_order); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_number')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_date')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_paid_tax_excl')); ?>:</b>
	<?php echo CHtml::encode($data->total_paid_tax_excl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_paid_tax_incl')); ?>:</b>
	<?php echo CHtml::encode($data->total_paid_tax_incl); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('total_products')); ?>:</b>
	<?php echo CHtml::encode($data->total_products); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_products_wt')); ?>:</b>
	<?php echo CHtml::encode($data->total_products_wt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_shipping_tax_excl')); ?>:</b>
	<?php echo CHtml::encode($data->total_shipping_tax_excl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_shipping_tax_incl')); ?>:</b>
	<?php echo CHtml::encode($data->total_shipping_tax_incl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_wrapping_tax_excl')); ?>:</b>
	<?php echo CHtml::encode($data->total_wrapping_tax_excl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_wrapping_tax_incl')); ?>:</b>
	<?php echo CHtml::encode($data->total_wrapping_tax_incl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	*/ ?>

</div>