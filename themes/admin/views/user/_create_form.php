<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
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

    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

    <?php echo $form->errorSummary($model); ?>
</fieldset>
<?php echo $form->textFieldRow($model, 'username', array('prepend' => '<i class="icon-user"></i>', 'placeholder' => "Vào tên đăng nhập", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('append' => '<i class="icon-certificate"></i>', 'placeholder' => "Vào mật khẩu", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->passwordFieldRow($model, 'passwordConfirm', array('append' => '<i class="icon-barcode"></i>', 'placeholder' => "Vào mật khẩu một lần nữa", 'class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Vào địa chỉ email@qcdn.com", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
<?php echo $form->dropDownListRow($mmodel, 'isEmailVisible', Lookup::items('EmailVisible'), array('hint' => 'Cho phép người khác thấy email của bạn.')); ?>    

<?php if (Yii::app()->user->checkAccess('supper')): ?>     
    <?php echo $form->dropDownListRow($model, 'role', Lookup::items('AccessRole'), array('hint' => 'Thêm quyền truy cập cho người dùng mới.')); ?>    
<?php else: ?>
<?php echo $form->dropDownListRow($model, 'role', Lookup::items('AccessRole'), array('disabled' => true, 'hint' => 'Chỉ có Quản Trị cấp cao mới thay đổi được Quyền Cơ Bản.') ); ?>    
        <?php endif; ?>
<?php if (Yii::app()->user->checkAccess('admin')): ?>     
    <?php echo $form->textFieldRow($model, 'salt', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($model, 'validation_key', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($model, 'password_strategy', array('disabled' => true, 'class' => 'span5', 'maxlength' => 128)); ?>

<?php endif; ?>


<?php echo $form->textFieldRow($mmodel, 'fullName', array('append' => '<i class="icon-circle-arrow-left"></i>', 'placeholder' => "Vào tên đầy đủ của bạn tại đây", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($mmodel, 'initials', array('append' => '<i class="icon-circle-arrow-left"></i>', 'placeholder' => "Vào tên đầy đủ của bạn tại đây", 'class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->dropDownListRow($mmodel, 'isScreenNameEditable', Lookup::items('ScreenNameEditable'), array('hint' => 'Cho  phép thay đổi tên đầy đủ.')); ?>    

<?php if ($model->isNewRecord != '1') { ?>
    <div class="row">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/avatar/' . $mmodel->avatar, "avatar", array("width" => 200, "class" => "img-rounded")); ?>  
    </div>
<?php } ?>
<?php echo $form->fileFieldRow($mmodel, 'image'); ?>
<?php echo $form->dropDownListRow($mmodel, 'occupation', Lookup::items('job'), array('append' => '<i class="icon-question-sign"></i>', 'hint' => 'Cho phép người khác thấy email của bạn.')); ?>    
<?php
echo $form->datepickerRow($mmodel, 'birthDate', array('hint' => 'Chọn ngày sinh của bạn.',
    'prepend' => '<i class="icon-calendar"></i>', 'options' => array('format' => 'dd/mm/yyyy', 'viewMode' => 2, 'minViewMode' => 2)));
?>
<?php echo $form->dropDownListRow($mmodel, 'gender', Lookup::items('gender'), array('hint' => 'Chọn giới tính của bạn ở đây.')); ?>    

<?php echo $form->dropDownListRow($mmodel, 'secretQuestion', Lookup::items('SecretQuestion'), array('append' => '<i class="icon-question-sign"></i>', 'hint' => 'Cho phép người khác thấy email của bạn.')); ?>    
<?php echo $form->textFieldRow($mmodel, 'secretAnswer', array('prepend' => '<i class="icon-heart"></i>', 'placeholder' => "Nhập vào câu trả lời.", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->textFieldRow($mmodel, 'passwordHint', array('append' => '<i class="icon-question-sign"></i>', 'placeholder' => "Nhập vào câu gợi ý mật khẩu.", 'class' => 'span5', 'maxlength' => 128)); ?>
<?php echo $form->markdownEditorRow($mmodel, 'administratorNote', array('class' => 'span5', 'height' => '100px')); ?>
<?php echo $form->checkBoxRow($model, 'term', array('hint' => 'Bạn phải đồng ý với điều khoản của chúng tôi như bên dưới để sử dụng hệ thông của chúng tôi.<u>
    <li>điều khoản 1</li>
    <li>điều khoản 2</li>
    <li>điều khoản 3</li>
    <li>điều khoản 4</li>
    <li>điều khoản 5</li>
    </u>')); ?>
<?php echo $form->dropDownListRow($model, 'status', Lookup::items('UserStatus'), array('hint' => 'Thiết lập trạng thái cho tài khoản này.')); ?>  
<?php echo $form->dropDownListRow($mmodel, 'textStatus', Lookup::items('textStatus'), array('hint' => 'Tầm vực chia sẽ thông tin.')); ?>    
<div class="form-actions">    
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
</div>
<?php $this->endWidget(); ?>
