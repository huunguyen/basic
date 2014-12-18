<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array('class' => 'login-form'),
    ));
    ?>

    <h3 class="form-title">Thông tin đăng nhập</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>Vào tên đăng nhập & Mật khẩu đăng nhập. </span>
    </div>
    <div class="form-group">
        <?php echo $form->label($model, 'username', array('class' => 'control-label visible-ie8 visible-ie9')); ?>
        <?php
        echo $form->textField($model, 'username', array('class' => 'form-control form-control-solid placeholder-no-fix',
            'autocomplete' => "off",
            'placeholder' => "Tên đăng nhập")
        );
        ?>		
    </div>
    <div class="form-group">
        <?php echo $form->label($model, 'password', array('class' => 'control-label visible-ie8 visible-ie9')); ?>
<?php
echo $form->passwordField($model, 'password', array('class' => 'form-control form-control-solid placeholder-no-fix',
    'autocomplete' => "off",
    'placeholder' => "Mã đăng nhập")
);
?>		
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success uppercase">Đăng nhập</button>
        <label class="rememberme check">
            <input type="checkbox" name="remember" value="1"/>Nhớ T.Tin </label>
        <a href="javascript:;" id="forget-password" class="forget-password">Quên mật khẩu?</a>
    </div>
    <div class="login-options">
        <h4>Hoặc đăng nhập với:</h4>
        <ul class="social-icons">
            <li>
                <a class="social-icon-color facebook" data-original-title="facebook" href="#"></a>
            </li>
            <li>
                <a class="social-icon-color twitter" data-original-title="Twitter" href="#"></a>
            </li>
            <li>
                <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="#"></a>
            </li>
            <li>
                <a class="social-icon-color linkedin" data-original-title="Linkedin" href="#"></a>
            </li>
        </ul>
    </div>
    <div class="create-account">
        <p>
            <a href="javascript:;" id="register-btn" class="uppercase">Tạo tài khoản</a>
        </p>
    </div>
<?php $this->endWidget(); ?>
    <!-- END LOGIN FORM -->

    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="index.html" method="post">
        <h3>Quên mật khẩu ?</h3>
        <p>
            Vào thông tin bên dưới để lấy lại mật khẩu.
        </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email"/>
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn btn-default">Quay lại</button>
            <button type="submit" class="btn btn-success uppercase pull-right">Gửi thông tin</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" action="index.html" method="post">
        <h3>Đăng ký tài khoản</h3>
        <p class="hint">
            Vào thông tin của bạn để hoàn tất đăng ký:
        </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Tên đầy đủ</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Tên đầy đủ" name="fullname"/>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Thư điện tử</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Thư điện tử" name="email"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Địa chỉ</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Địa chỉ" name="address"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Thành phố/Tỉnh thành</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="Thành phố/Tỉnh thành" name="city"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Nước</label>
            <select name="country" class="form-control">
                <option value="">Nước</option>			
                <option value="AU">Australia</option>
                <option value="CA">Canada</option>
                <option value="DE">Germany</option>
                <option value="GB">United Kingdom</option>
                <option value="US">United States</option>
                <option value="VN">Viet Nam</option>
            </select>
        </div>
        <p class="hint">
            Enter your account details below:
        </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password"/>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword"/>
        </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="check">
                <input type="checkbox" name="tnc"/> I agree to the <a href="#">
                    Terms of Service </a>
                & <a href="#">
                    Privacy Policy </a>
            </label>
            <div id="register_tnc_error">
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="register-back-btn" class="btn btn-default">Back</button>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>
<!-- END LOGIN -->