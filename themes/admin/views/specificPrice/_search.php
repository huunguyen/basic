<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_specific_price',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_specific_price_rule',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_cart',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_product_attribute',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_customer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'from_quantity',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'reduction',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'reduction_type',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'from',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'to',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
