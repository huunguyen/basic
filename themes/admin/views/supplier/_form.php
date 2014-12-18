<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id' => 'supplier-form',
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

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64)); ?>

    <?php
    echo $form->toggleButtonRow($model, 'active', array(
    'enabledLabel' => 'Cho phép xuất bản',
    'disabledLabel' => 'Không cho phép xuất bản'
    )
    );
    ?>

    <?php echo $form->markdownEditorRow($model, 'description_short', array('class' => 'span8', 'height' => '100px')); ?>

    <?php echo $form->ckEditorRow($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>    
    
    <?php if(!$model->isNewRecord): ?>
    <div class="control-group ">
        <label class="control-label required" for="Supplier_logo">Logo cũ</label>
        <div class="controls">
            <?php
            try {
                if ((!empty($model->old_logo) || $model->old_logo!="") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . $model->old_logo))) {
                $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_logo, Supplier::TYPE, "240x180"));
                } else {
                $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
                }
            } catch (Exception $ex) {
                $model->thumbnail = $ex->getMessage();
            }
            
            ?>            
            <div id="infoToggler">
                <img src="<?=$model->thumbnail?>" width="240px" height="180px"/>
            </div>
        </div>
    </div>
    <?php endif;?>
    
    <?php echo $form->fileFieldRow($model, 'logo'); ?>
    
    <?php if(!$model->isNewRecord): ?>
    <div class="control-group ">
        <label class="control-label required" for="Supplier_certificate">Giấy chứng nhận cũ</label>
        <div class="controls">
            <?php
            try {
                if ((!empty($model->old_certificate) || $model->old_certificate!="") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . $model->old_certificate))) {
                    $model->cer_thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Supplier::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_certificate, Supplier::TYPE, "240x180"));
                } else {
                    $model->cer_thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'cer.png');
                }
            } catch (Exception $ex) {
                $model->cer_thumbnail = $ex->getMessage();
            }            
            ?>            
            <div id="infoToggler">
                <img src="<?=$model->cer_thumbnail?>" width="240px" height="180px"/>
            </div>
        </div>
    </div>
    <?php endif;?>
    
    <?php echo $form->fileFieldRow($model, 'certificate'); ?>

    <?php echo $form->textFieldRow($model, 'address1', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'address2', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'fax', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->ckEditorRow($model, 'note', array('rows' => 3, 'cols' => 50, 'class' => 'span8')); ?>

    <?php echo $form->textFieldRow($model, 'meta_title', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'meta_keywords', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'meta_description', array('class' => 'span5', 'maxlength' => 45)); ?>
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
