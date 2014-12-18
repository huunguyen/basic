<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_image')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_image),array('view','id'=>$data->id_image)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_product')); ?>:</b>
	<?php echo CHtml::encode($data->id_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cover')); ?>:</b>
	<?php echo CHtml::encode($data->cover); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('legend')); ?>:</b>
	<?php echo CHtml::encode($data->legend); ?>
	<br />


</div>