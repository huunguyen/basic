             <?php $this->pageTitle = Yii::app()->name; ?>
<?php

$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs, array(
            array('name' => 'Mất mật khẩu', 'url' => array('process/lostpass')),
            array('name' => 'đăng nhập'),
        ));
?>
    <div class="widget">
            <?php
            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'type' => 'horizontal',
                'inlineErrors' => false,
                'htmlOptions' => array('class' => 'well'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

            <?php echo $form->textFieldRow($model, 'username', array('append' => '<i class="icon-user"></i>', 'placeholder' => "Enter your username in here", 'class' => 'span3', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

            <?php echo $form->passwordFieldRow($model, 'password', array('append' => '<i class="icon-certificate"></i>', 'placeholder' => "Enter your password in here", 'class' => 'span3', 'maxlength' => 128)); ?>
            <?php if (($model->scenario == 'captchaRequired') && (CCaptcha::checkRequirements())): ?>
                <div class="control-group ">
                    <label class="control-label" for="VerifyForm_username"></label>
                    <div class="controls">
                        <?php
                        $this->widget('CCaptcha', array(
                            'buttonType' => 'link',
                            'buttonLabel' => 'lấy ảnh khác',
                            'imageOptions' => array('alt' => 'Ảnh xác nhận',)
                        ));
                        ?><br/>
                    </div>        
                </div>
                <?php echo $form->textFieldRow($model, 'verifyCode', array('prepend' => '<i class="icon-barcode"></i>', 'placeholder' => "input above code", 'class' => 'span3', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
            <?php endif; ?>
            <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

            <div class="form-actions">
                <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Đăng nhập', 'icon' => 'ok')); ?>
                <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Xóa nhập lại')); ?>
            </div>

            <?php $this->endWidget(); ?>
    </div>

