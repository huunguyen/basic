<?php
/* @var $this EmailController */
/* @var $data Email */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailfrom')); ?>:</b>
	<?php echo CHtml::encode($data->emailfrom); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('emailto')); ?>:</b>
	<?php echo CHtml::encode($data->emailto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailcc')); ?>:</b>
	<?php echo CHtml::encode($data->emailcc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('emailbcc')); ?>:</b>
	<?php echo CHtml::encode($data->emailbcc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
        <?php echo CHtml::encode($data->content); ?>
        <br />
       

</div>
