<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_stock')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_stock),array('view','id'=>$data->id_stock)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_warehouse')); ?>:</b>
	<?php echo CHtml::encode($data->id_warehouse); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product_attribute')); ?>:</b>
	<?php echo CHtml::encode($data->id_product_attribute); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference')); ?>:</b>
	<?php echo CHtml::encode($data->reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('physical_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->physical_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usable_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->usable_quantity); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('price_te')); ?>:</b>
	<?php echo CHtml::encode($data->price_te); ?>
	<br />

	*/ ?>

</div>