<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_attribute_group')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_attribute_group),array('view','id'=>$data->id_attribute_group)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_color_group')); ?>:</b>
	<?php echo CHtml::encode($data->is_color_group); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('group_type')); ?>:</b>
	<?php echo CHtml::encode($data->group_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('public_name')); ?>:</b>
	<?php echo CHtml::encode($data->public_name); ?>
	<br />


</div>