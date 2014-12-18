<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_feature')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_feature),array('view','id'=>$data->id_feature)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />


</div>