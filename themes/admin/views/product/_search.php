<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_product',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_supplier_default',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_manufacturer',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_category_default',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'id_tax',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'on_sale',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'minimal_quantity',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'wholesale_price',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'unity',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'unit_price_ratio',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'additional_shipping_cost',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'supplier_reference',array('class'=>'span5','maxlength'=>32)); ?>

		<?php echo $form->textFieldRow($model,'width',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'height',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'depth',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'weight',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'out_of_stock',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'customizable',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'text_fields',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'available_for_order',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'available_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'condition',array('class'=>'span5','maxlength'=>11)); ?>

		<?php echo $form->textFieldRow($model,'show_price',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'description_short',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'meta_keywords',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'meta_description',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
