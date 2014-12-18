<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_carrier')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_carrier),array('view','id'=>$data->id_carrier)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deleted')); ?>:</b>
	<?php echo CHtml::encode($data->deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_handling')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_handling); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('range_behavior')); ?>:</b>
	<?php echo CHtml::encode($data->range_behavior); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('is_free')); ?>:</b>
	<?php echo CHtml::encode($data->is_free); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_external')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_external); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('need_range')); ?>:</b>
	<?php echo CHtml::encode($data->need_range); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shipping_method')); ?>:</b>
	<?php echo CHtml::encode($data->shipping_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_width')); ?>:</b>
	<?php echo CHtml::encode($data->max_width); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_height')); ?>:</b>
	<?php echo CHtml::encode($data->max_height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_depth')); ?>:</b>
	<?php echo CHtml::encode($data->max_depth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_weight')); ?>:</b>
	<?php echo CHtml::encode($data->max_weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade')); ?>:</b>
	<?php echo CHtml::encode($data->grade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delay')); ?>:</b>
	<?php echo CHtml::encode($data->delay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />

	*/ ?>

</div>