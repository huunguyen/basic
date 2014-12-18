<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_range_distant')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_range_distant),array('view','id'=>$data->id_range_distant)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_carrier')); ?>:</b>
	<?php echo CHtml::encode($data->id_carrier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delimiter1')); ?>:</b>
	<?php echo CHtml::encode($data->delimiter1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delimiter2')); ?>:</b>
	<?php echo CHtml::encode($data->delimiter2); ?>
	<br />


</div>