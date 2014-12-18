<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class VerifyForm extends CFormModel {

    public $key;
    public $email;
    public $namekey;
    public $pass;
    public $confirm;
    public $verifyCode;
    // permittion number
    public $fail = 5;
    public $result = false;
    public $listemail;
    public $subject;
    public $body;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required            
            array('email', 'required'),
            array('key, email', 'length', 'max' => 255, 'on' => 'verify'),
            array('email', 'email', 'on' => 'verify', 'message' => "Địa chỉ email không đúng"),
            array('email', 'email', 'allowEmpty' => true, 'on' => 'lostpass', 'message' => "Địa chỉ email không đúng hoặc bị bỏ trống"),
            array('namekey', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'on' => 'lostpass', 'message' => 'Tên chỉ chứa các ký tự, số và không được có khoảng trắng'),
            // verifyCode needs to be entered correctly
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'newpass, lostpass'),
            //password and repeat password    
            array('email, key', 'length', 'max' => 256, 'on' => 'newpass'),
            array('pass, confirm', 'length', 'min' => 6, 'max' => 256, 'on' => 'newpass'),
            array('pass, confirm', 'required', 'on' => 'newpass'),
            array('pass', 'compare', 'compareAttribute' => 'confirm', 'on' => 'newpass'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'key' => 'Mã',
            'email' => 'Thư điện tử',
            'namekey' => 'Tên key',
            'pass' => 'Mã đăng nhập',
            'confirm' => 'Mã đăng nhập nhập lại',
            'verifyCode' => 'Mã xác nhận',
        );
    }

    public function verify() {
            $model = User::model()->findByAttributes(
                    array('validation_key' => $this->key, 'email' => $this->email), array('condition' => 'verified=:verified', 'params' => array(':verified' => Yii::t('verified', 'FALSE'),)
                    )
            );
            if (!empty($model)) {
                $this->key = md5(mt_rand() . mt_rand() . mt_rand());
                $model->updateByPk($model->id, array('verified' => Yii::t('verified', 'TRUE'), 'validation_key' => $this->key));
                Yii::app()->user->setFlash('success', '<strong>Success!</strong>This account is verified!');
                return true;
            }
 else { 
     Yii::app()->user->setFlash('error', '<strong>Fail!</strong>This account is verified fail!');
     return false;      
 }    
    }

    public function lostPassword() {
        $criteria = new CDbCriteria;
        if (isset($this->email)) {
            $model = Customer::model()->findByAttributes(array('email' => $this->email));
        }
        if (!empty($model)) {
            $this->key=$this->pass = md5(mt_rand() . mt_rand() . mt_rand());
            $model->secure_key=$this->key;
            $model->requires_new_password=1;
            $model->save(FALSE);
            $this->result =$model;
            //var_dump($this);exit();
        }
        return $this->result;
    }
    public function newPassword() {
       
        $user = Customer::model()->findByAttributes(
                array('email' => $this->email, 'secure_key' => $this->key,'requires_new_password'=>1)
        );
        if (!empty($user)) {
            //encrypt password and assign to password field
            $p = $this->pass;
            if(isset($this->pass)&&isset($this->confirm)&&($this->pass===$this->confirm)){
            $salt = $user->encrypt_text(strtolower($this->pass), $user->salt);
            $user->updateByPk($user->id_customer, array('password' => $user->hash($this->pass),'requires_new_password'=>0));
            Yii::app()->user->setFlash('success', '<strong>Success!</strong>This account is verified!');
            $this->result = true;
            }else{
            $this->result = true;    
            }
        } else {
            $this->result = false;
        }
        return $this->result;
    }
    public function hash($value, $salt = null) {
        if (!isset($salt)) {
            $this->salt = $this->blowfishSalt(10);
        }
        return ($salt === NULL) ? crypt($value, $this->salt) : crypt($value, $salt);
    }

}
