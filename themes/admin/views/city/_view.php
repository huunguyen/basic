<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_city')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_city),array('view','id'=>$data->id_city)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_country')); ?>:</b>
	<?php echo CHtml::encode($data->id_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('style')); ?>:</b>
	<?php echo CHtml::encode($data->style); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iso_code')); ?>:</b>
	<?php echo CHtml::encode($data->iso_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('call_prefix')); ?>:</b>
	<?php echo CHtml::encode($data->call_prefix); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />

	*/ ?>

</div>