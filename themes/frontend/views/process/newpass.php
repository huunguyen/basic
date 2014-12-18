<div class="login_new_form">
    <div class="formRow fluid">
        <div class="createaccount ">Lấy lại mật khẩu<div class="clear"></div></div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'newpass-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true
        )
    ));
    ?>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    
   <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?><br>
            <?php echo $form->textField($model, 'email',array('disabled' => true,'style'=>'width:300px;border-radius:3px;padding:5px 5px 5px')); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>
      <?php echo $form->hiddenField($model,'key',array('type'=>"hidden",'size'=>2,'maxlength'=>2)); ?>
    
        <div class="row">
            <?php echo $form->labelEx($model, 'pass'); ?><br>
            <?php echo $form->passwordField($model, 'pass',array('style'=>'width:300px;border-radius:3px;padding:5px 5px 5px','placeholder' => "Mật khẩu mới")); ?>
            <?php echo $form->error($model, 'pass'); ?>
        </div>
            
            <div class="row">
            <?php echo $form->labelEx($model, 'confirm'); ?><br>
            <?php echo $form->passwordField($model, 'confirm',array('style'=>'width:300px;border-radius:3px;padding:5px 5px 5px','placeholder' => "Nhập lại mật khẩu mới")); ?>
            <?php echo $form->error($model, 'confirm'); ?>
        </div>
                
 <?php if (CCaptcha::checkRequirements()): ?>
    <div class="control-group ">
            <?php $this->widget('CCaptcha'); ?><br>
        <?php echo $form->textField($model, 'verifyCode',array('style'=>'width:200px;border-radius:3px;padding:5px 5px 5px;margin-top:-5px;','placeholder' => "Mã bảo mật")); ?>
    </div>
            
<?php endif; ?>

    <div class="row submit">
        <?php echo CHtml::submitButton('Xác nhận'); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form --></div>
