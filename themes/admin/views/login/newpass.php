<?php echo $this->renderPartial('application.views.layouts.common'); ?>                
<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Tạo mật khẩu mới'),
        ));
?>

<div class="form">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'newpass-form',
        'enableClientValidation' => true,
        'type' => 'horizontal',
        'inlineErrors' => true,
        'htmlOptions' => array('class' => 'well'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
    
  <?php echo $form->textFieldRow($model, 'email', array('disabled' => true, 'prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Your email:".$model->email, 'class' => 'span3', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
<?php echo $form->hiddenField($model,'key',array('type'=>"hidden",'size'=>2,'maxlength'=>2)); ?>
        <?php echo $form->passwordFieldRow($model, 'pass', array('append' => '<i class="icon-certificate"></i>', 'placeholder' => "Enter your password in here", 'class' => 'span3', 'maxlength' => 128)); ?>
<?php echo $form->passwordFieldRow($model, 'confirm', array('append' => '<i class="icon-user"></i>', 'placeholder' => "Enter your again password", 'class' => 'span3', 'maxlength' => 128)); ?>
<?php if (CCaptcha::checkRequirements()): ?>
    <div class="control-group ">
        <label class="control-label" for="VerifyForm_email"></label>
        <div class="controls">
            <?php $this->widget('CCaptcha'); ?><br/>
            </div>        
    </div>
 <?php echo $form->textFieldRow($model, 'verifyCode', array('prepend' => '<i class="icon-barcode"></i>', 'placeholder' => "input above code", 'class' => 'span3', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
            
<?php endif; ?>

   <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu thông tin', 'icon' => 'ok')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Xóa nhập lại')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->