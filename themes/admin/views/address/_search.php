<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_address',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_city',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_manufacturer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_supplier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_warehouse',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_store',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'company',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'lastname',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'firstname',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'address1',array('class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->textFieldRow($model,'address2',array('class'=>'span5','maxlength'=>128)); ?>

		<?php echo $form->textAreaRow($model,'other',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>16)); ?>

		<?php echo $form->textFieldRow($model,'phone_mobile',array('class'=>'span5','maxlength'=>16)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'deleted',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
