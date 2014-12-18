<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginFormCustomer extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;
    public $recovery;
    public $autoLogin = false;
    public $verifyCode;
    public $status;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required', 'message' => "<b>{attribute}</b> yêu cầu phải được nhập."),
            //array('username', 'match', 'pattern' => '/^[A-Za-z0-9_-.@]+$/u', 'message' => '{attribute} không đúng'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            // add these lines below                    
            array('verifyCode', 'required', 'on' => 'captchaRequired', 'message' => "<b>{attribute}</b> yêu cầu phải được nhập."),
            array('recovery', 'required', 'on' => 'recovery', 'message' => "<b>{attribute}</b> yêu cầu phải được nhập."),
            array('recovery', 'length', 'max' => 100, 'message' => "<b>{attribute}</b> quá dài( tối đa {max} ký tự )."),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Nhớ thông tin cho lần sau',
            'username' => 'Tên đăng nhập',
            'password' => 'Mã đăng nhập',
            'verifyCode' => 'Mã bảo mật'
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
            switch ($this->_identity->errorCode) {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($this->_identity, $duration);
                    break;
                case UserIdentity::ERROR_STATUS_INACTIVE:
                    $this->addError("status", 'Tài khoản này chưa được kích hoạt.');
                    break;
                case UserIdentity::ERROR_STATUS_USER_DOES_NOT_EXIST:
                    $this->addError('status', 'Tài khoản này không tồn tại.');
                    break;
                case UserIdentity::ERROR_UNKNOWN_IDENTITY:
                    $this->addError('status', 'Không xác định lỗi trong khi đăng nhập.');
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:                    
                    if (!$this->hasErrors())
                        $this->addError("status", 'Tên tài khoản hoặc mật khẩu không chính xác');
                    break;
            }
        }         
    }

    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function getUserHostAddress() {
        switch (true) {
            case isset($_SERVER["HTTP_X_FORWARDED_FOR"]):
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                break;
            case isset($_SERVER["HTTP_CLIENT_IP"]):
                $ip = $_SERVER["HTTP_CLIENT_IP"];
                break;
            default:
                $ip = $_SERVER["REMOTE_ADDR"] ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1';
        }
        if (strpos($ip, ', ') > 0) {
            $ips = explode(', ', $ip);
            $ip = $ips[0];
        }
        return $ip;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password, $this->autoLogin);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            $user = Customer::model()->findByPk($this->_identity->id);
            $user->updateByPk($this->_identity->id, array('secure_key' => md5(mt_rand() . mt_rand() . mt_rand())));
            return true;
        }
        else
            return false;
    }

}