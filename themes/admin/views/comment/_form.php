<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'comment-form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'inlineErrors'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>true,
        'beforeValidate'=>"js:function(form) {
            return true;
        }",
        'afterValidate'=>"js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'You have made changes on this page that you have not yet confirmed. If you navigate away from this page you will lose your unsaved changes';
                    return event.returnValue;
                });
                return false;
            }
            else {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = null;
                    return event.returnValue;
                });
                if(confirm('We have validated your input and we are ready to save your data. Please click Ok to save or Cancel to return to input.'))
                    return true;
                else
                    return false;
            }
        }"
    ),

)); ?>
<fieldset>

    <legend>Post a comment</legend>
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->html5EditorRow($model, 'content', array('class'=>'span9', 'rows'=>10, 'height'=>'200', 'options'=>array('color'=>true))); ?>

    <?php echo $form->toggleButtonRow($model, 'status'); ?>

</fieldset>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'reset',
            'label'=>' Reset '
        )); ?>
	</div>

<?php $this->endWidget(); ?>