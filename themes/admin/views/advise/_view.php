<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_advise')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_advise),array('view','id'=>$data->id_advise)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_customer')); ?>:</b>
	<?php echo CHtml::encode($data->id_customer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_guest')); ?>:</b>
	<?php echo CHtml::encode($data->id_guest); ?>
	<br />


</div>