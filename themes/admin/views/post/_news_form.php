<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'post-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'beforeValidate' => "js:function(form) {
            return true;
        }",
        'afterValidate' => "js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'Bạn đã nhập thông tin nhưng chưa lưu lại trên server. Nếu bạn rời khỏi trang này lúc này dữ liệu bạn mới nhập sẽ mất và không được lưu lại';
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
                if(confirm('Dữ liệu bạn nhập đã chính xác. Bạn có muốn lưu thông tin này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<fieldset>

    <legend>Create Post</legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->dropDownListRow($model, 'categories', Lookup::items('categories'), array('disabled' => true)); ?>    
    <?php echo $form->markdownEditorRow($model, 'info', array('class' => 'span5', 'height' => '100px')); ?>

    <?php echo $form->ckEditorRow($model, 'content', array('options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>

    <div class="control-group ">
        <label class="control-label" for="Post_tags">Tags</label>
        <div class="controls">
            <?php
            $objs = Tag::model()->findAll();
            $data = array();
            foreach ($objs as $obj)
                $data[] = $obj->name;

            $this->widget('bootstrap.widgets.TbTypeahead', array(
                'model' => $model,
                'htmlOptions' => array('class' => 'span5', 'id' => 'tags','autocomplete' => 'off'),
                'attribute' => 'tags',
                'options' => array(
                    'source' => $data,
                    'items' => 4,
                    'matcher' => "js:function(item) {
     return ~item.toLowerCase().indexOf(this.query.toLowerCase());
      }",
            )));
            ?>
        </div>
    </div>
    <?php echo $form->fileFieldRow($model, 'attach_file'); ?>


    <?php echo $form->dropDownListRow($model, 'status', Lookup::items('PostStatus'), array('hint' => 'apply new status! for News.')); ?>    

</fieldset>
<div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
    </div>
<?php $this->endWidget(); ?>