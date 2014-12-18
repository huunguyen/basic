<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_product_hot_deal',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_product_attribute',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_hot_deal',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_specific_price_rule',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'remain_quantity',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'state',array('class'=>'span5','maxlength'=>9)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
