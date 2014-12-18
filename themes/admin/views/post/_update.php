<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'post-form',
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

    <legend>Update Post</legend>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span9','maxlength'=>128)); ?>

    <?php echo $form->html5EditorRow($model, 'info', array('class'=>'span9', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true))); ?>

    <?php echo $form->html5EditorRow($model, 'content', array('class'=>'span9', 'rows'=>20, 'height'=>'400', 'options'=>array('color'=>true))); ?>

    <?php // echo $form->textFieldRow($model,'tags',array('class'=>'span5','maxlength'=>128)); ?>
    <div class="control-group ">
        <label class="control-label" for="Post_tags">Tags</label>
        <div class="controls">
            <?php
            $objs = Tag::model()->findAll();
            $data = array();
            foreach ($objs as $obj) $data[] = $obj->name;

            $this->widget('bootstrap.widgets.TbTypeahead', array(
                'model'=>$model,
                'htmlOptions'=>array('class'=>'span9','id'=>'tags'),
                'attribute'=>'tags',
                'options'=>array(
                    'source'=>$data,
                    'items'=>4,
                    'matcher'=>"js:function(item) {
     return ~item.toLowerCase().indexOf(this.query.toLowerCase());
      }",
                )));
            ?>
        </div>
    </div>

    <?php echo $form->toggleButtonRow($model, 'status'); ?>

</fieldset>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'label'=>$model->isNewRecord ? '  Create  ' : '  Save  ',
    )); ?>
</div>
<?php $this->endWidget(); ?>