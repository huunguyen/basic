<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property string $id_user
 * @property string $email
 * @property string $password
 * @property string $password_strategy
 * @property string $password_expiry_date
 * @property string $last_password_gen
 * @property string $default_role
 * @property string $roles
 * @property integer $max_level
 * @property integer $active
 * @property string $id_last_order
 * @property string $id_last_customer_message
 * @property string $id_last_customer
 * @property integer $requires_new_password
 * @property string $login_attempts
 * @property string $login_time
 * @property string $validation_key
 * @property string $salt
 * @property integer $verified
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property AuthItem[] $tblAuthItems
 * @property Books[] $books
 * @property Comment[] $comments
 * @property CustomerMessage[] $customerMessages
 * @property Detail[] $details
 * @property Email[] $emails
 * @property Message[] $messages
 * @property Message[] $tblMessages
 * @property OrderHistory[] $orderHistories
 * @property Post[] $posts
 * @property Post[] $posts1
 * @property StockMvt[] $stockMvts
 * @property SupplyOrderHistory[] $supplyOrderHistories
 * @property SupplyOrderReceiptHistory[] $supplyOrderReceiptHistories
 * @property Customer $idLastCustomer
 * @property Orders $idLastOrder
 * @property CustomerMessage $idLastCustomerMessage
 * @property Warehouse[] $warehouses
 */
class User extends CActiveRecord {
    /*
      0 : cấm tất cả các quyền                        0000
      1 : AUTHOR                                      0001
      2 : MODERATOR                                   0010
      4 : ADMIN                                       0100
      8 : SUPPER                                      1111
     * 
      3 : AUTHOR + MODERATOR                           0011
      5 : AUTHOR + ADMIN                               0101
      6 : MODERATOR + ADMIN                            0110
      7 : AUTHOR + MODERATOR + ADMIN                   0111
      8 : AUTHOR + MODERATOR + ADMIN + SUPPER          1111
     *  */

    const IS_NOT_ACTIVE = 0;
    const IS_NOT_VERIFIED = 0;
    const REQUIRES_NEW_PASSWORD = 1;
    const ROLE_MANAGER = "00111111";
    const ROLE_ADMIN = "01111111";
    const ROLE_SUPPER = "11111111";
    const PASSWORD_EXPIRY = 90;

    public $passwordSave;
    public $repeatPassword;
    public $_detail;

    const TYPE = "use";

    public $avatar;
    public $old_avatar;
    public $old_default_role;
    public $thumbnail;
    public $rememberMe;
    public $autoLogin = false;
    public $term = false;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, last_password_gen, default_role', 'required'),
            array('max_level, active, requires_new_password, verified', 'numerical', 'integerOnly' => true),
            array('username, password, email, password_strategy, default_role, salt', 'length', 'max' => 128),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'on' => 'create, update, insert',
                'message' => 'Tên đăng nhập chỉ được gõ ký tự, số ,ký tự "_-" và không được có khoảng trắng. '),
            //array('password', 'match', 'pattern' => '/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&?]+).*$/u', 'on' => 'create', 'message' => 'Mật khẩu có ít nhất 1 ký tự, 1 số, 1 ký tự !#$%&? và không được có khoảng trắng. ít nhất có 4 ký tự'),
            array('id_last_order, id_last_customer_message, id_last_customer', 'length', 'max' => 10),
            array('validation_key', 'length', 'max' => 128),
            array('email', 'email', 'message' => "Email không chính xác"),
            array('username, email', 'unique', 'message' => '{attribute} đã tồn tại!'),
            array('passwordSave, repeatPassword', 'required', 'on' => 'create, insert'),
            array('passwordSave, repeatPassword', 'length', 'min' => 6, 'max' => 40),
            //array('passwordSave', 'checkStrength', 'score' => 20),
            array('username', 'unique', 'className' => 'AuthItem', 'attributeName' => 'name', 'message'=>'{attribute} hoặc thư điện tử đã được sử dụng xin vui lòng chọn tên khác', 'on' => 'create'),
            
            array('passwordSave', 'compare', 'compareAttribute' => 'repeatPassword'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'passwordSave'),
            array('term', 'compare', 'compareValue' => true, 'on' => 'create, insert', 'message' => 'Bạn phải chấp nhận các điều khoản và điều kiện'),
            array('password_expiry_date, roles, login_attempts, login_time, date_add, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('avatar, old_avatar, passwordSave, repeatPassword, id_user, username, email, password, password_strategy, password_expiry_date, last_password_gen, default_role, roles, max_level, active, id_last_order, id_last_customer_message, id_last_customer, requires_new_password, login_attempts, login_time, validation_key, salt, verified, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /** score password strength
     * where score is increased based on
     * - password length
     * - number of unqiue chars
     * - number of special chars
     * - number of numbers
     * 
     * A medium score is around 20
     * 
     * @param type $attribute
     * @param type $params
     * @return boolean 
     */
    function CheckStrength($attribute, $params) {
        if (isset($this->$attribute)) {  // Edit 2013-06-01
            $password = $this->$attribute;
            if (strlen($password) == 0)
                $strength = -10;
            else
                $strength = 0;
            /*             * * get the length of the password ** */
            $length = strlen($password);
            /*             * * check if password is not all lower case ** */
            if (strtolower($password) != $password) {
                $strength += 1;
            }
            /*             * * check if password is not all upper case ** */
            if (strtoupper($password) == $password) {
                $strength += 1;
            }
            /*             * * check string length is 8 -15 chars ** */
            if ($length >= 8 && $length <= 15) {
                $strength += 2;
            }
            /*             * * check if lenth is 16 - 35 chars ** */
            if ($length >= 16 && $length <= 35) {
                $strength += 2;
            }
            /*             * * check if length greater than 35 chars ** */
            if ($length > 35) {
                $strength += 3;
            }
            /*             * * get the numbers in the password ** */
            preg_match_all('/[0-9]/', $password, $numbers);
            $strength += count($numbers[0]);
            /*             * * check for special chars ** */
            preg_match_all('/[|!@#$%&*\/=?,;.:\-_+~^\\\]/', $password, $specialchars);
            $strength += sizeof($specialchars[0]);
            /*             * * get the number of unique chars ** */
            $chars = str_split($password);
            $num_unique_chars = sizeof(array_unique($chars));
            $strength += $num_unique_chars * 2;
            /*             * * strength is a number 1-100; ** */
            $strength = $strength > 99 ? 99 : $strength;
            //$strength = floor($strength / 10 + 1);
            if ($strength < $params['score'])
                $this->addError($attribute, "Password is too weak - try using CAPITALS, Num8er5, AND sp€c!al characters. Your score was " . $strength . "/" . $params['score']);
            else
                return true;
        }
    }

    /**
     * Compare Expiry date and today's date
     * @return type - positive number equals valid user
     */
    public function checkExpiryDate() {
        $expDate = DateTime::createFromFormat('Y-m-d H:i:s', $this->password_expiry_date);
        $today = new DateTime("now");
        fb($today->diff($expDate)->format('%a'), "PASSWORD EXPIRY");
        return ($today->diff($expDate)->format('%a'));
    }

    /**
     * Generates a new validation key (additional security for cookie)
     */
    public function regenerateValidationKey() {
        $this->saveAttributes(array(
            'validation_key' => md5(mt_rand() . mt_rand() . mt_rand()),
        ));
    }

    public function regenerateUsername() {
        $words = array("@", ".", "_", "-");
        $username = str_replace($words, "", $this->email);
        if ($this->isNewRecord) {
            $this->username = $username;
        } else
            $this->saveAttributes(array(
                'username' => $username,
            ));
    }

    protected function roles_encrypt() {
        $text = CJSON::encode(array('default_role' => $this->default_role, 'username' => $this->username));
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->email, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    protected function roles_decrypt() {
        $detext = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->email, base64_decode($this->roles), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
        $rs = CJSON::decode($detext);
        if (is_array($rs))
            return $rs;
        else
            return array('default_role' => $this->default_role, 'username' => $this->username);
    }

    protected function encrypt_text($value, $salt = null) {
        if (!isset($value))
            return false;

        if ($salt == null)
            $salt = $this->salt;

        $strpwd = preg_replace('/[^a-zA-Z0-9.]/s', '', $this->password);
        $key = substr($strpwd, 7, ((strlen($strpwd) - 6) > 32) ? 32 : (strlen($strpwd) - 6));

        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $salt);
        return trim(base64_encode($crypttext));
    }

    protected function decrypt_text($value, $salt = null) {
        if (!isset($value))
            return false;

        if ($salt == null)
            $salt = $this->salt;

        $strpwd = preg_replace('/[^a-zA-Z0-9.]/s', '', $this->password);
        $key = substr($strpwd, 7, ((strlen($strpwd) - 6) > 32) ? 32 : (strlen($strpwd) - 6));

        $crypttext = base64_decode($value);

        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $salt);
        return trim($decrypttext);
    }

    protected function hash($value, $salt = null) {
        if (!isset($this->salt)) {
            $this->salt = $this->blowfishSalt(10);
        }
        return ($salt === NULL) ? crypt($value, $this->salt) : crypt($value, $salt);
    }

    /**
     * Generate a random salt in the crypt(3) standard Blowfish format.
     *
     * @param int $cost Cost parameter from 4 to 31.
     *
     * @throws Exception on invalid cost parameter.
     * @return string A Blowfish hash salt for use in PHP's crypt()
     */
    protected function blowfishSalt($cost = 13, $rand = array()) {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception("cost parameter must be between 4 and 31");
        }
        //$rand = array();
        for ($i = 0; $i < 8; $i += 1) {
            $rand[] = pack('S', mt_rand(0, 0xffff));
        }
        $rand[] = substr(microtime(), 2, 6);
        $rand = sha1(implode('', $rand), true);
        $salt = '$2a$' . sprintf('%02d', $cost) . '$';
        $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
        return $salt;
    }

    public function check($value) {
        $strategy = $this->decrypt_text($this->password_strategy);
        if (($this->password === crypt($value, $this->password)) && ($strategy == strtolower($this->email))) {
            return $value;
        } else {
            return false;
        }
    }

    protected function checkRoles() {
        $old_level = RoleHelper::getLevel($this->old_default_role);
        if (!Yii::app()->user->checkAccess('admin')) {
            $this->addError('default_role', 'Bạn không đủ quyền để tạo tài khoản với quyền này');
        } elseif (!$this->isNewRecord && ($this->max_level > $old_level)) {
            $this->addError('default_role', 'Bạn chỉ thay đổi quyền tối đa bằng quyền của bạn');
        } else {
            $login = User::model()->findByPk(Yii::app()->user->id);
            if ($this->isNewRecord && ($login !== null) && ($this->max_level > RoleHelper::getLevel($login->default_role))) {
                $this->addError('default_role', 'Bạn chỉ tạo tài khoản với quyền tối đa bằng quyền của bạn');
            }
            if (!in_array(Lookup::item('AccessRole', $this->default_role), Lookup::items('AccessRole'))) {
                $this->default_role = 'member';
            }
        }
    }

    /**
     * check if the user password is strong enough
     * check the password against the pattern requested
     * by the strength parameter
     * This is the 'passwordStrength' validator as declared in rules().
     */
    public function passwordStrength($attribute, $params) {
        if ($params['strength'] === self::WEAK) {
            $pattern = '/^(?=.*[a-zA-Z0-9]).{5,}$/';
        } elseif ($params['strength'] === self::STRONG) {
            $pattern = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{5,}$/';
        }
        if (!preg_match($pattern, $this->$attribute)) {
            $this->addError($attribute, 'your password is not strong enough!');
        }
    }

    public function passwordalphanumeric($attribute_name, $params) {
        if (isset($this->password)) {
            if (preg_match('~^[a-z0-9]*[0-9][a-z0-9]*$~i', $this->password)) {
                // $subject is alphanumeric and contains at least 1 number
            } else {   // failed
                $this->addError($attribute_name, 'Enter password with digits');
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tblAuthItems' => array(self::MANY_MANY, 'AuthItem', 'tbl_auth_assignment(userid, itemname)'),
            'books' => array(self::HAS_MANY, 'Books', 'id_manager'),
            'comments' => array(self::HAS_MANY, 'Comment', 'id_user'),
            'customerMessages' => array(self::HAS_MANY, 'CustomerMessage', 'id_user'),
            'details' => array(self::HAS_MANY, 'Detail', 'id_user'),
            'emails' => array(self::HAS_MANY, 'Email', 'id_user'),
            'messages' => array(self::HAS_MANY, 'Message', 'id_user'),
            'tblMessages' => array(self::MANY_MANY, 'Message', 'tbl_message_readed(id_user, id_message)'),
            'orderHistories' => array(self::HAS_MANY, 'OrderHistory', 'id_user'),
            'posts' => array(self::HAS_MANY, 'Post', 'id_user_add'),
            'posts1' => array(self::HAS_MANY, 'Post', 'id_user_upd'),
            'stockMvts' => array(self::HAS_MANY, 'StockMvt', 'id_user'),
            'supplyOrderHistories' => array(self::HAS_MANY, 'SupplyOrderHistory', 'id_user'),
            'supplyOrderReceiptHistories' => array(self::HAS_MANY, 'SupplyOrderReceiptHistory', 'id_user'),
            'idLastCustomer' => array(self::BELONGS_TO, 'Customer', 'id_last_customer'),
            'idLastOrder' => array(self::BELONGS_TO, 'Orders', 'id_last_order'),
            'idLastCustomerMessage' => array(self::BELONGS_TO, 'CustomerMessage', 'id_last_customer_message'),
            'warehouses' => array(self::HAS_MANY, 'Warehouse', 'id_user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_user' => 'Mã người dùng',
            'email' => 'Thư điện tử',
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'password_strategy' => 'Ràng buột mật khẩu',
            'password_expiry_date' => 'Ngày mật khẩu hết hạn',
            'last_password_gen' => 'TG Sinh MK cuối cùng',
            'default_role' => 'Quyền mặc định',
            'roles' => 'Các quyền',
            'max_level' => 'Mức quyền cao nhất',
            'active' => 'TT Kích hoạt',
            'id_last_order' => 'Mã đơn hàng',
            'id_last_customer_message' => 'Mã tin nhắn',
            'id_last_customer' => 'Mã khách hàng',
            'requires_new_password' => 'Yêu cầu mật khẩu mới',
            'login_attempts' => 'TG đăng nhập',
            'login_time' => 'Thời gian đăng nhập',
            'validation_key' => 'Mã xác nhận',
            'salt' => 'Mã bảo mật',
            'verified' => 'Đã xác nhận',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'old_avatar' => 'Ảnh cũ',
            'avatar' => 'Ảnh đại diện',
            'passwordSave' => 'Mật khẩu',
            'repeatPassword' => 'Mật khẩu lặp lại',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('password_expiry_date', $this->password_expiry_date, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('max_level', $this->max_level);
        $criteria->compare('active', $this->active);
        $criteria->compare('id_last_order', $this->id_last_order, true);
        $criteria->compare('id_last_customer_message', $this->id_last_customer_message, true);
        $criteria->compare('id_last_customer', $this->id_last_customer, true);
        $criteria->compare('requires_new_password', $this->requires_new_password);
        $criteria->compare('login_attempts', $this->login_attempts, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('validation_key', $this->validation_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('verified', $this->verified);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function searchInRoleGroup($rolegroup) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $roles = AuthItemChild::model()->findAllByAttributes(array('child' => $rolegroup));
        $usernames = array();
        foreach ($roles as $role) {
            $usernames[] = $role->parent;
        }
        $criteria = new CDbCriteria;

        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('email', $this->email, true);
        $criteria->addInCondition('username', $usernames);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('password_expiry_date', $this->password_expiry_date, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('max_level', $this->max_level);
        $criteria->compare('active', $this->active);
        $criteria->compare('id_last_order', $this->id_last_order, true);
        $criteria->compare('id_last_customer_message', $this->id_last_customer_message, true);
        $criteria->compare('id_last_customer', $this->id_last_customer, true);
        $criteria->compare('requires_new_password', $this->requires_new_password);
        $criteria->compare('login_attempts', $this->login_attempts, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('validation_key', $this->validation_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('verified', $this->verified);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function searchNotInRoleGroup($rolegroup) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $roles = AuthItemChild::model()->findAllByAttributes(array('child' => $rolegroup));
        $usernames = array('supper4saocom');
        foreach ($roles as $role) {
            $usernames[] = $role->parent;
        }
        $criteria = new CDbCriteria;

        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('email', $this->email, true);
        $criteria->addNotInCondition('username', $usernames);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('password_expiry_date', $this->password_expiry_date, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('max_level', $this->max_level);
        $criteria->compare('active', $this->active);
        $criteria->compare('id_last_order', $this->id_last_order, true);
        $criteria->compare('id_last_customer_message', $this->id_last_customer_message, true);
        $criteria->compare('id_last_customer', $this->id_last_customer, true);
        $criteria->compare('requires_new_password', $this->requires_new_password);
        $criteria->compare('login_attempts', $this->login_attempts, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('validation_key', $this->validation_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('verified', $this->verified);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByActive($active = 0) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if (!isset($active) || ($active == 0))
            $active = 0;
        else
            $active = 1;
        $criteria = new CDbCriteria;

        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('password_expiry_date', $this->password_expiry_date, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('max_level', $this->max_level);
        $criteria->compare('active', $active);
        $criteria->compare('id_last_order', $this->id_last_order, true);
        $criteria->compare('id_last_customer_message', $this->id_last_customer_message, true);
        $criteria->compare('id_last_customer', $this->id_last_customer, true);
        $criteria->compare('requires_new_password', $this->requires_new_password);
        $criteria->compare('login_attempts', $this->login_attempts, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('validation_key', $this->validation_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('verified', $this->verified);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByVerified($verified = 0) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if (!isset($verified) || ($verified == 0))
            $verified = 0;
        else
            $verified = 1;
        $criteria = new CDbCriteria;

        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('password_expiry_date', $this->password_expiry_date, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('max_level', $this->max_level);
        $criteria->compare('active', $this->active);
        $criteria->compare('id_last_order', $this->id_last_order, true);
        $criteria->compare('id_last_customer_message', $this->id_last_customer_message, true);
        $criteria->compare('id_last_customer', $this->id_last_customer, true);
        $criteria->compare('requires_new_password', $this->requires_new_password);
        $criteria->compare('login_attempts', $this->login_attempts, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('validation_key', $this->validation_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('verified', $verified);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByExpiry() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $expiry = date('Y-m-d H:i:s', time());

        $criteria = new CDbCriteria;
        $criteria->addCondition('password_expiry_date < "' . $expiry . '" ');
        $criteria->compare('email', $this->email, true);

        $criteria->compare('default_role', $this->default_role, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByRqPasswd($passwd = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if (!isset($passwd) || ($passwd == null))
            $passwd = 1;

        $criteria = new CDbCriteria;

        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('password_expiry_date', $this->password_expiry_date, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('roles', $this->roles, true);
        $criteria->compare('max_level', $this->max_level);
        $criteria->compare('active', $this->active);
        $criteria->compare('id_last_order', $this->id_last_order, true);
        $criteria->compare('id_last_customer_message', $this->id_last_customer_message, true);
        $criteria->compare('id_last_customer', $this->id_last_customer, true);
        $criteria->compare('requires_new_password', $passwd);
        $criteria->compare('login_attempts', $this->login_attempts, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('validation_key', $this->validation_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('verified', $this->verified);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'email, default_role ASC';
        $sort->attributes = array(
            'email' => 'email',
            'default_role' => 'default_role'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function beforeValidate() {
        if (!isset($this->salt)) {
            $this->salt = $this->blowfishSalt(10);
        }
        if (!isset($this->validation_key)) {
            $this->validation_key = md5(mt_rand() . mt_rand() . mt_rand());
        }
        $this->last_password_gen = new CDbExpression('NOW()');
        $this->regenerateUsername();
        $this->max_level = RoleHelper::getLevel($this->default_role);
        if (!isset($this->id_last_customer)) {
            $this->id_last_customer = null;
        }
        if (!isset($this->id_last_customer_message)) {
            $this->id_last_customer_message = null;
        }
        if (!isset($this->id_last_order)) {
            $this->id_last_order = null;
        }
        //$this->id_last_customer = $this->id_last_customer_message = $this->id_last_order = null;
        $this->checkRoles();
        return parent::beforeValidate();
    }

    public function beforeSave() {
        //add the password hash if it's a new record
        if ($this->isNewRecord) {
            if (isset($this->passwordSave, $this->repeatPassword) && ($this->passwordSave === $this->repeatPassword)) {
                $this->password = $this->hash($this->passwordSave);
            }
            $this->password_expiry_date = new CDbExpression("DATE_ADD(NOW(), INTERVAL " . self::PASSWORD_EXPIRY . " DAY) ");
        } else
        if (isset($this->passwordSave) && isset($this->repeatPassword) && ($this->passwordSave === $this->repeatPassword)) {
            //if it's not a new password, save the password only if it not empty and the two passwords match
            $this->password = $this->hash($this->passwordSave);
            $this->password_expiry_date = new CDbExpression("DATE_ADD(NOW(), INTERVAL " . self::PASSWORD_EXPIRY . " DAY) ");
        }
        $this->password_strategy = $this->encrypt_text(strtolower($this->email));
        if (!in_array(Lookup::item('AccessRole', $this->default_role), Lookup::items('AccessRole'))) {
            $this->default_role = 'member';
        }
        $this->roles = $this->roles_encrypt();
        return parent::beforeSave();
    }

    public function afterSave() {
        $this->roles = $this->roles_decrypt();
        $auth = Yii::app()->authManager;
        if ($auth->getAuthItem($this->username) === null) {
            $ownrole = $auth->createRole($this->username, 'Auto Create a Roles from email ' . $this->username);
            $auth->save();
        }
        AuthItem::model()->updateByPk($this->username, array('level' => 2, 'description' => "Quyền Cấp riêng cho thành viên có email [$this->email]"));
        if ($auth->getAuthItem($this->default_role) === null) {
            $defaultrole = $auth->createRole($this->default_role, 'Auto Create a Roles from email ' . $this->default_role);
            $auth->save();
        }
        AuthItem::model()->updateByPk($this->default_role, array('level' => 0, 'description' => "Quyền tạo sẳn [Quyền cơ bản]"));
        return parent::afterSave();
    }

    public function afterFind() {
        $this->old_avatar = $this->avatar = ImageHelper::FindImageByPk(self::TYPE, $this->id_user);
        try {
            if ($this->avatar != null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->avatar, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        $this->old_default_role = $this->default_role;
        $this->roles = $this->roles_decrypt();
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'common.extensions.behaviors.AutoTimestampBehavior',
            //You can optionally set the field name options here
            )
        );
    }

}
