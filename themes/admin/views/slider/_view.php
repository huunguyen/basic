<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_slider')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_slider),array('view','id'=>$data->id_slider)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_supplier')); ?>:</b>
	<?php echo CHtml::encode($data->id_supplier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_category')); ?>:</b>
	<?php echo CHtml::encode($data->id_category); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->id_manufacturer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('height')); ?>:</b>
	<?php echo CHtml::encode($data->height); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('width')); ?>:</b>
	<?php echo CHtml::encode($data->width); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fill')); ?>:</b>
	<?php echo CHtml::encode($data->fill); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auto')); ?>:</b>
	<?php echo CHtml::encode($data->auto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('continuous')); ?>:</b>
	<?php echo CHtml::encode($data->continuous); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('controls')); ?>:</b>
	<?php echo CHtml::encode($data->controls); ?>
	<br />

	*/ ?>

</div>