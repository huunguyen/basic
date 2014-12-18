<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id_detail')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_detail),array('view','id'=>$data->id_detail)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_user')); ?>:</b>
	<?php echo CHtml::encode($data->id_user); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_customer')); ?>:</b>
	<?php echo CHtml::encode($data->id_customer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('question')); ?>:</b>
	<?php echo CHtml::encode($data->question); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('share_state')); ?>:</b>
	<?php echo CHtml::encode($data->share_state); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_upd')); ?>:</b>
	<?php echo CHtml::encode($data->date_upd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company')); ?>:</b>
	<?php echo CHtml::encode($data->company); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthday')); ?>:</b>
	<?php echo CHtml::encode($data->birthday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site')); ?>:</b>
	<?php echo CHtml::encode($data->site); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	*/ ?>

</div>