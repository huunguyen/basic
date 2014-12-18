<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_district')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_district),array('view','id'=>$data->id_district)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_city')); ?>:</b>
	<?php echo CHtml::encode($data->id_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iso_code')); ?>:</b>
	<?php echo CHtml::encode($data->iso_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />


</div>