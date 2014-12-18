<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_pack')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_pack),array('view','id'=>$data->id_pack)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pack_group')); ?>:</b>
	<?php echo CHtml::encode($data->id_pack_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product_attribute')); ?>:</b>
	<?php echo CHtml::encode($data->id_product_attribute); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />


</div>