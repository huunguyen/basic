<?php $this->pageTitle="Bán sĩ, lẻ online tất cả các loại hàng"; ?>
<style>
    .errorMessage{
        color: red;
    }
</style>
<div class="login_new_form">
    <div class="formRow fluid">
        <div class="grid4" style=" border-right:1px #dddddd solid;">
            <div class="createaccount ">Đăng nhập<div class="clear"></div></div>
            <?php
            $form1 = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
            <?php echo $form1->error($model, 'status'); ?>
            <div class="login_form">
                <span class="field-validation-valid" data-valmsg-for="IsValidUser" data-valmsg-replace="true"></span>
                <div class="row">
                    <span class="row_L">EMAIL<font class="other_color_star">*</font></span>
                    <?php echo $form1->textField($model, 'username', array("class" => "text", 'placeholder' => "Tên đăng nhập", 'autocomplete' => 'off', 'maxlength' => 128)); ?>
                    <?php echo $form1->error($model, 'username'); ?>
                    <br class="clean">
                </div>
                <div class="err_lo"><span class="field-validation-valid" data-valmsg-for="Email" data-valmsg-replace="true"></span></div>
                <div class="row">
                    <span class="row_L">MẬT KHẨU<font class="other_color_star">*</font></span>
                    <?php echo $form1->passwordField($model, 'password', array("class" => "text", 'placeholder' => "Mật khẩu", 'maxlength' => 128)); ?>
                    <?php echo $form1->error($model, 'password'); ?>
                </div>
                <div class="err_lo"><span class="field-validation-valid" data-valmsg-for="Password" data-valmsg-replace="true"></span></div>
                <div class="row">
                    <?php if (($model->scenario == 'captchaRequired') && (CCaptcha::checkRequirements())): ?>
                        <div style="width: 150px;float: left;margin-left: 80px">
                            <?php
                            $this->widget('CCaptcha', array(
                                'buttonType' => 'link',
                                'buttonLabel' => '',
                                'imageOptions' => array('alt' => 'Ảnh xác nhận',)
                            ));
                            ?><br/>
                        </div>        
                        <?php echo $form1->textField($model, 'verifyCode', array("class" => "text", 'placeholder' => "Mã bảo mật", 'autocomplete' => 'off', 'maxlength' => 128, 'style' => 'width:100px;height:50px')); ?>
                        <?php echo $form1->error($model, 'verifyCode'); ?>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <?php echo $form1->checkBox($model, 'rememberMe'); ?><span class="title_item_note2">&nbsp;Tự động đăng nhập vào lần sau</span>  
                </div>
                <div class="row">
                    <input class="btn_login" value="" type="submit">
                </div>
                <div class="row" style="margin-bottom:10px;">
                    <a href="<?= Yii::app()->createUrl("process/lostpass") ?>">Bạn quên mật khẩu</a>
                </div>
                <h4 class="style3">Hoặc đăng nhập bằng</h4>
                <div class="login_other">
                    <span style="float:left;"><a href="javascript:void()" onclick="facebook_login();" class="btn_face1 L"></a></span>
                    <span style="float:left;"><a href="javascript:void()" onclick="yahoo_login();" class="btn_yahoo1 L"></a></span>
                    <span style="float:left;"><a href="javascript:void()" onclick="google_login();" class="btn_google1 L"></a></span>
                </div>
            </div>
            <?php $this->endWidget(); ?>


        </div>





        <div class="grid8">

            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div style="background-color: yellowgreen;height: 25px;font-size:12px;color:red;text-align: center;box-shadow: 2px 2px 2px #003300;border-radius: 10px">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>

            <div class="createaccount">Tạo tài khoản mới<div class="clear"></div></div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'customer-form',
                'enableClientValidation' => true,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,
                ),
                'htmlOptions' => array('enctype' => 'multipart/form-data',),
            ));
            ?>
            <div class="re_form">

                <div>
                    <span class="field-validation-valid" data-valmsg-for="ErrorMessage" data-valmsg-replace="true"></span>
                </div>
                <div class="row">
                    <span class="row_L">EMAIL<font class="other_color_star">*</font></span>
                    <?php echo $form->textField($modelc, 'email', array("class" => "text", "id" => "RegisterEmail", 'placeholder' => "Vào địa chỉ email@qcdn.com", 'autocomplete' => 'off', 'maxlength' => 128)); ?><br class="clean">
                    <?php echo $form->error($modelc, 'email'); ?>
                </div>
                <div class="row">
                    <span class="row_L">MẬT KHẨU<font class="other_color_star">*</font></span>
                    <?php echo $form->passwordField($modelc, 'passwordSave', array("class" => "text", 'placeholder' => "Mật khẩu", 'maxlength' => 128)); ?>
                    <?php echo $form->error($modelc, 'passwordSave'); ?>
                </div>
                <div class="err_re">
                    <span class="field-validation-valid" data-valmsg-for="RegisterPassword" data-valmsg-replace="true"></span>
                </div>
                <div class="row">
                    <span class="row_L" style="padding-top: 0 !important;">MẬT KHẨU<font class="other_color_star">*</font><br>
                        <font style="font-size: 12px; color: #a9a9a9;">Nhập lại lần 2</font></span>
                    <?php echo $form->passwordField($modelc, 'repeatPassword', array("class" => "text", 'placeholder' => "Nhập lại mật khẩu", 'maxlength' => 128)); ?><br class="clean">
                    <?php echo $form->error($modelc, 'repeatPassword'); ?>
                </div>
                <div class="err_re">
                    <span class="field-validation-valid" data-valmsg-for="RetypePassword" data-valmsg-replace="true"></span>
                </div>
            </div>
            <div class="re_form_B">
                <p></p>
                <?php if ($modelc->isNewRecord): ?>
                    <?php echo $form->checkBox($modelc, 'term'); ?>
                    <span class="title_item_note2"  style="font-size: 12px">&nbsp;&nbsp;Tôi đã xem và đồng ý với<a target="_blank" href="<?= Yii::app()->createUrl("post/view_new", array('id' => 19)) ?>"> quy chế của sàn giao dịch</a> </span><span class="field-validation-valid" data-valmsg-for="AcceptTerms" data-valmsg-replace="true"></span>
                    <?php echo $form->error($modelc, 'term'); ?>
                <?php endif; ?>
            </div>
            <div>
                <p style="padding-top: 15px; text-align: left;">
                    <input class="btn_register" value="" type="submit">
                </p>
            </div>
            <?php
            $this->endWidget();
            ?>
        </div>
        <div class="clear"></div>
    </div>

</div>