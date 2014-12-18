<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_attribute')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_attribute),array('view','id'=>$data->id_attribute)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_attribute_group')); ?>:</b>
	<?php echo CHtml::encode($data->id_attribute_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php echo CHtml::encode($data->color); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>