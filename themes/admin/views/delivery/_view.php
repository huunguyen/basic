<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_delivery')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_delivery),array('view','id'=>$data->id_delivery)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_carrier')); ?>:</b>
	<?php echo CHtml::encode($data->id_carrier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_price')); ?>:</b>
	<?php echo CHtml::encode($data->range_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_weight')); ?>:</b>
	<?php echo CHtml::encode($data->range_weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_distant')); ?>:</b>
	<?php echo CHtml::encode($data->range_distant); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />


</div>