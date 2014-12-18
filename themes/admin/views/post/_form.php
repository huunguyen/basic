<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'category-form',
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
<legend>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($model); ?>
    </legend>   
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>

    <?php echo $form->html5EditorRow($model, 'info', array('class' => 'span5', 'height' => '100px')); ?>

    <?php echo $form->ckEditorRow($model, 'content', array('class' => 'span5')); ?>   

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group ">
            <label class="control-label required" for="Post_img">Ảnh đại diện</label>
            <div class="controls">
                <?php
                if ((!empty($model->old_img) || $model->old_img != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . $model->old_img))) {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_img, Post::TYPE, "240x180"));
                } else {
                    $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
                }
                ?>            
                <div id="infoToggler">
                    <img src="<?= $model->thumbnail ?>" width="240px" height="180px"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php echo $form->fileFieldRow($model, 'img'); ?>
    
<?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_category', CHtml::listData(Category::model()->findAll($criteria), 'id_category', 'name'), array(
        'prompt' => 'Chọn Phân mục',
            )
    );
    ?>  
    
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
                'htmlOptions' => array('class' => 'span8', 'id' => 'Post_tags'),
                'attribute' => 'tags',
                'options' => array(
                    'source' => $data,
                    'items' => 4,
                    'matcher' => "js:function(item) {
     return ~item.toLowerCase().indexOf(this.query.toLowerCase());
      }",
            )
                )
                    );
            ?>
        </div>
    </div>
   
<?php echo $form->dropDownListRow($model, 'status', Lookup::items('StatusType'), array('prompt' => 'Chọn Trạng Thái')); ?>  
    
    <?php echo $form->dropDownListRow($model, 'categories', Lookup::items('CategoryType'), array('prompt' => 'Chọn Loại Tin Đăng')); ?>  
    

</fieldset>
<div class="form-actions">
   <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>