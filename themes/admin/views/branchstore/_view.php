<?php
/* @var $this BranchstoreController */
/* @var $data Branchstore */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('info')); ?>:</b>
	<?php echo $data->info; ?>
	<br />
        
<b><?php echo CHtml::encode($data->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->city_name); ?>
	<br />
        
<b><?php echo CHtml::encode($data->getAttributeLabel('address_store')); ?>:</b>
	<?php echo $data->address_store; ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_update')); ?>:</b>
	<?php echo CHtml::encode($data->last_update); ?>
	<br />


</div>