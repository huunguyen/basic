<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'contact-form',
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
    <legend></legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($model); ?>
     <?php echo $form->textFieldRow($model, 'name', array('append' => '<i class="icon-globe"></i>', 'placeholder' => "Tên dịch vụ hổ trợ", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
     
        <?php echo $form->html5EditorRow($model, 'description', array('class' => 'span5', 'height' => '100px')); ?>
    
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
    
    <?php echo $form->textFieldRow($model, 'position', array('append' => '<i class="icon-retweet"></i>', 'placeholder' => "Vị trí", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your email in here email@qcdn.com", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    
    <div class="form-actions">        
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>

