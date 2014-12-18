<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_menu')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_menu),array('view','id'=>$data->id_menu)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_store')); ?>:</b>
	<?php echo CHtml::encode($data->id_store); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_supplier')); ?>:</b>
	<?php echo CHtml::encode($data->id_supplier); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_manufacturer')); ?>:</b>
	<?php echo CHtml::encode($data->id_manufacturer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('menu_type')); ?>:</b>
	<?php echo CHtml::encode($data->menu_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	*/ ?>

</div>