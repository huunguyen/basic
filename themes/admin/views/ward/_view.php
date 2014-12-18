<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_ward')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_ward),array('view','id'=>$data->id_ward)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('iso_code')); ?>:</b>
	<?php echo CHtml::encode($data->iso_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_district')); ?>:</b>
	<?php echo CHtml::encode($data->id_district); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />


</div>