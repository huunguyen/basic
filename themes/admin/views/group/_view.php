<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_group')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_group),array('view','id'=>$data->id_group)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reduction')); ?>:</b>
	<?php echo CHtml::encode($data->reduction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_display_method')); ?>:</b>
	<?php echo CHtml::encode($data->price_display_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('show_prices')); ?>:</b>
	<?php echo CHtml::encode($data->show_prices); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


</div>