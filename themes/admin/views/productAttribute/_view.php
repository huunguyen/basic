<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_product_attribute')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_product_attribute),array('view','id'=>$data->id_product_attribute)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference')); ?>:</b>
	<?php echo CHtml::encode($data->reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_reference')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_reference); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wholesale_price')); ?>:</b>
	<?php echo CHtml::encode($data->wholesale_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_price_impact')); ?>:</b>
	<?php echo CHtml::encode($data->unit_price_impact); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('default_on')); ?>:</b>
	<?php echo CHtml::encode($data->default_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('minimal_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->minimal_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('available_date')); ?>:</b>
	<?php echo CHtml::encode($data->available_date); ?>
	<br />

	*/ ?>

</div>