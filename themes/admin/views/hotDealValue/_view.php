<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_hot_deal_value')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_hot_deal_value),array('view','id'=>$data->id_hot_deal_value)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_hot_deal')); ?>:</b>
	<?php echo CHtml::encode($data->id_hot_deal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('custom_name')); ?>:</b>
	<?php echo CHtml::encode($data->custom_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('custom_value')); ?>:</b>
	<?php echo CHtml::encode($data->custom_value); ?>
	<br />


</div>