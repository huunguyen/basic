<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'customer-form',
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
<div class="widget">
<fieldset>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($model); ?>
</fieldset>

    <?php echo $form->textFieldRow($model, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Vào địa chỉ email@qcdn.com", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    <?php echo $form->passwordFieldRow($model, 'passwordSave', array('append' => '<i class="icon-certificate"></i>', 'placeholder' => "Vào mật khẩu", 'class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->passwordFieldRow($model, 'repeatPassword', array('append' => '<i class="icon-barcode"></i>', 'placeholder' => "Vào mật khẩu một lần nữa", 'class' => 'span5', 'maxlength' => 128)); ?>
    
<?php if (!$model->isNewRecord): ?>
    <div class="control-group ">
        <label class="control-label required" for="User_avatar">Old Avatar</label>
        <div class="controls">
            <?php
            if ((!empty($model->old_avatar) || $model->old_avatar != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Customer::TYPE . DIRECTORY_SEPARATOR . $model->old_avatar))) {
                $model->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . Customer::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($model->old_avatar, Customer::TYPE, "240x180"));
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
<?php echo $form->fileFieldRow($model, 'avatar'); ?>
<?php
echo $form->toggleButtonRow($model, 'active', array(
    'enabledLabel' => 'Cho phép xuất bản',
    'disabledLabel' => 'Không cho phép xuất bản'
        )
);
?>
    </div>
<div class="widget">
    <fieldset>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    <?php echo $form->errorSummary($mmodel); ?>
</fieldset>
    	<?php echo $form->textFieldRow($mmodel,'lastname',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->textFieldRow($mmodel,'firstname',array('class'=>'span5','maxlength'=>64)); ?>

	 <?php 
                  $items = Lookup::items('SecretQuestion');
                  $item = $mmodel->answer;
                  if(isset($mmodel->answer) && !isset($items[$item]) && !in_array($item, $items)) $items["$item"] = $item;
                  echo $form->dropDownListRow($mmodel, 'question', $items, array('append' => '<i class="icon-question-sign"></i>', 'hint' => 'Chọn câu hỏi bảo mật.')); 
                  ?>    
	
	<?php echo $form->passwordFieldRow($mmodel,'answer',array('class'=>'span5','maxlength'=>45)); ?>

    <?php echo $form->dropDownListRow($mmodel, 'share_state', Lookup::items('ShareState'), 
            array('hint' => 'Chọn tầm vực chia sẽ thông tin.',
        'prompt' => 'Chọn loại thông tin chia sẽ',
//        'ajax' => array(
//            'type' => 'POST',
//            'url' => CController::createUrl('checkRole'),
//            'dataType' => 'json',
//            'data' => array('style' => 'js:this.value'),
//            'success' => 'function(data) {                            
//                          console.log(data);
//                          $("#User_id_user").html(data.dropDown);
//                        }',
//            'cache' => false
//        )
                )
            ); ?>    

	<?php echo $form->textFieldRow($mmodel,'company',array('class'=>'span5','maxlength'=>45)); ?>

<?php
    echo $form->datepickerRow($mmodel, 'birthday', array('hint' => 'Chọn ngày sinh.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value'=>date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>
    
	<?php echo $form->markdownEditorRow($mmodel, 'note', array('class' => 'span8', 'height' => '100px')); ?>

	<?php echo $form->textFieldRow($mmodel,'site',array('class'=>'span5','maxlength'=>255)); ?>
<?php echo $form->dropDownListRow($mmodel, 'gender', Lookup::items('Gender'), 
            array('hint' => 'Chọn giới tính.',
        'prompt' => 'Loại giới tính'
                )
            ); ?>  
    <?php if ($model->isNewRecord): ?>
<?php echo $form->checkBoxRow($model, 'term', array('hint' => 'Bạn phải đồng ý với điều khoản của chúng tôi như bên dưới để sử dụng hệ thông của chúng tôi.<u>
    <li>điều khoản 1</li>
    <li>điều khoản 2</li>
    <li>điều khoản 3</li>
    <li>điều khoản 4</li>
    <li>điều khoản 5</li>
    </u>')); ?>
    <?php endif; ?>
    

    
</div>
<div class="form-actions">    
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
</div>
<?php $this->endWidget(); ?>