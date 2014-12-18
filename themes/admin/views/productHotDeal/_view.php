<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_product_hot_deal')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_product_hot_deal),array('view','id'=>$data->id_product_hot_deal)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product_attribute')); ?>:</b>
	<?php echo CHtml::encode($data->id_product_attribute); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_hot_deal')); ?>:</b>
	<?php echo CHtml::encode($data->id_hot_deal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_specific_price_rule')); ?>:</b>
	<?php echo CHtml::encode($data->id_specific_price_rule); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('remain_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->remain_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	*/ ?>

</div>