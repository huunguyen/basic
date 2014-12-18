<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id_supplier',array('class'=>'span5','maxlength'=>10)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>64)); ?>

		<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'date_upd',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'active',array('class'=>'span5')); ?>

		<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'description_short',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'meta_title',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'meta_keywords',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textAreaRow($model,'meta_description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'slug',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'logo',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'address1',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'address2',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'latitude',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'longitude',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'fax',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'note',array('class'=>'span5','maxlength'=>45)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
