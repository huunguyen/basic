<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_specific_price')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_specific_price),array('view','id'=>$data->id_specific_price)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_specific_price_rule')); ?>:</b>
	<?php echo CHtml::encode($data->id_specific_price_rule); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cart')); ?>:</b>
	<?php echo CHtml::encode($data->id_cart); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product_attribute')); ?>:</b>
	<?php echo CHtml::encode($data->id_product_attribute); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_customer')); ?>:</b>
	<?php echo CHtml::encode($data->id_customer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('from_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->from_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reduction')); ?>:</b>
	<?php echo CHtml::encode($data->reduction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reduction_type')); ?>:</b>
	<?php echo CHtml::encode($data->reduction_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('from')); ?>:</b>
	<?php echo CHtml::encode($data->from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('to')); ?>:</b>
	<?php echo CHtml::encode($data->to); ?>
	<br />

	*/ ?>

</div>