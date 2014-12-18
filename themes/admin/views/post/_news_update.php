<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'post-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange' => true,
        ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<fieldset>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->dropDownListRow($model, 'categories', Lookup::items('categories'), array('disabled' => true)); ?>    
          
    <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData(Category::model()->findAll(array('condition' => 'parent_id="' . $category_id . '"', 'order' => 'name ASC')), 'id', 'name'), array('empty' => 'Chọn danh mục')) ?>
   
        <?php echo $form->html5EditorRow($model, 'info', array('class' => 'span5', 'rows' => 5, 'height' => '200', 'options' => array('color' => true))); ?>
<?php echo $form->ckEditorRow($model, 'content', array('options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>
<?php // echo $form->textFieldRow($model,'tags',array('class'=>'span5','maxlength'=>128));  ?>
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
<?php echo $form->textFieldRow($model, 'attach_file', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->fileFieldRow($model, 'attachfile'); ?>
    <?php echo $form->dropDownListRow($model, 'status', Lookup::items('PostStatus'), array('hint' => 'Trạng thái bản tin')); ?>    

</fieldset>
<div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
    </div>
<?php $this->endWidget(); ?>