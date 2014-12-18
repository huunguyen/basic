<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_slider_detail')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_slider_detail),array('view','id'=>$data->id_slider_detail)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_slider')); ?>:</b>
	<?php echo CHtml::encode($data->id_slider); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />


</div>