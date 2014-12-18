<?php

/**
 * This is the model class for table "tbl_customer".
 *
 * The followings are the available columns in table 'tbl_customer':
 * @property string $id_customer
 * @property string $id_default_group
 * @property string $id_risk
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $password_strategy
 * @property string $last_password_gen
 * @property string $default_role
 * @property integer $requires_new_password
 * @property string $secure_key
 * @property string $salt
 * @property integer $active
 * @property integer $is_guest
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property AnswerCustomer[] $answerCustomers
 * @property Books[] $books
 * @property Cart[] $carts
 * @property CartRule[] $cartRules
 * @property Comment[] $comments
 * @property Compare[] $compares
 * @property Risk $idRisk
 * @property Group $idDefaultGroup
 * @property Group[] $tblGroups
 * @property CustomerThread[] $customerThreads
 * @property Detail[] $details
 * @property Email[] $emails
 * @property Guest[] $guests
 * @property Message[] $messages
 * @property OrderReturn[] $orderReturns
 * @property OrderSlip[] $orderSlips
 * @property Orders[] $orders
 * @property ProductAdvise[] $productAdvises
 * @property SpecificPrice[] $specificPrices
 * @property User[] $users
 */
class Customer extends CActiveRecord {

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

    const TYPE = "cus";

    public $avatar;
    public $old_avatar;
    public $thumbnail;
    public $rememberMe;
    public $autoLogin = false;
    public $term = false;
    public $id_supplier;
    public $old_id_supplier;
    public $old_default_role;
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_customer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, username, last_password_gen, date_add', 'required'),
            array('id_supplier', 'required', 'on' => 'supplier, csupplier, usupplier, isupplier'),
            array('requires_new_password, active, is_guest', 'numerical', 'integerOnly' => true),
            array('id_default_group, id_risk', 'length', 'max' => 10),
            array('email, default_role', 'length', 'max' => 128),
            array('username', 'length', 'max' => 255),
            array('password, password_strategy', 'length', 'max' => 255),
            array('secure_key, salt', 'length', 'max' => 128),
            array('old_default_role, id_supplier, old_id_supplier, date_upd', 'safe'),
            array('secure_key', 'length', 'max' => 128),
            array('email', 'email', 'message' => "Email không chính xác"),
            array('username, email', 'unique', 'message' => '{attribute} đã tồn tại!'),
            array('passwordSave, repeatPassword', 'required', 'on' => 'create, insert, supplier'),
            array('passwordSave, repeatPassword', 'length', 'min' => 6, 'max' => 40),
            //array('passwordSave', 'checkStrength', 'score' => 20),
            array('username', 'unique', 'className' => 'CusAuthItem', 'attributeName' => 'name', 'message'=>'{attribute} đã được sử dụng xin vui lòng chọn tên khác', 'on' => 'create'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'passwordSave'),
            array('term', 'compare', 'compareValue' => true, 'on' => 'create, insert', 'message' => 'Bạn phải chấp nhận các điều khoản và điều kiện'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('old_default_role, id_supplier,  old_id_supplier, id_customer, id_default_group, id_risk, email, username, password, password_strategy, last_password_gen, default_role, requires_new_password, secure_key, salt, active, is_guest, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answerCustomers' => array(self::HAS_MANY, 'AnswerCustomer', 'id_customer'),
            'books' => array(self::HAS_MANY, 'Books', 'id_custommer'),
            'carts' => array(self::HAS_MANY, 'Cart', 'id_customer'),
            'cartRules' => array(self::HAS_MANY, 'CartRule', 'id_customer'),
            'comments' => array(self::HAS_MANY, 'Comment', 'id_customer'),
            'compares' => array(self::HAS_MANY, 'Compare', 'id_customer'),
            'idRisk' => array(self::BELONGS_TO, 'Risk', 'id_risk'),
            'idDefaultGroup' => array(self::BELONGS_TO, 'Group', 'id_default_group'),
            'tblGroups' => array(self::MANY_MANY, 'Group', 'tbl_customer_group(id_customer, id_group)'),
            'customerSuppliers' => array(self::HAS_MANY, 'CustomerSupplier', 'id_customer'),
            'customerThreads' => array(self::HAS_MANY, 'CustomerThread', 'id_customer'),
            'details' => array(self::HAS_MANY, 'Detail', 'id_customer'),
            'emails' => array(self::HAS_MANY, 'Email', 'id_custommer'),
            'guests' => array(self::HAS_MANY, 'Guest', 'id_customer'),
            'messages' => array(self::HAS_MANY, 'Message', 'id_customer'),
            'orderReturns' => array(self::HAS_MANY, 'OrderReturn', 'id_customer'),
            'orderSlips' => array(self::HAS_MANY, 'OrderSlip', 'id_customer'),
            'orders' => array(self::HAS_MANY, 'Orders', 'id_customer'),
            'productAdvises' => array(self::HAS_MANY, 'ProductAdvise', 'id_customer'),
            'specificPrices' => array(self::HAS_MANY, 'SpecificPrice', 'id_customer'),
            'users' => array(self::HAS_MANY, 'User', 'id_last_customer'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_customer' => 'Mã khách hàng',
            'id_default_group' => 'Mã nhóm',
            'id_risk' => 'Mã rủi ro',
            'email' => 'Thư điện tử',
            'username' => 'Tên đăng nhập',
            'password' => 'Mã đăng nhập',
            'password_strategy' => 'Ràng buột',
            'last_password_gen' => 'Lần sinh mã cuối',
            'default_role' => 'Quyền mặc định',
            'requires_new_password' => 'Y/c mật khẩu',
            'secure_key' => 'Mã bảo mật',
            'salt' => 'Mã Salt',
            'active' => 'Kích hoạt',
            'is_guest' => 'Là khách vãn lai',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'old_avatar' => 'Ảnh cũ',
            'avatar' => 'Ảnh đại diện',
            'passwordSave' => 'Mật khẩu',
            'repeatPassword' => 'Mật khẩu lặp lại',
            'id_supplier' => 'Nhà cung cấp'
        );
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
            'secure_key' => md5(mt_rand() . mt_rand() . mt_rand()),
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

    public function encrypt_text($value, $salt = null) {
        if (!isset($value))
            return false;

        if ($salt == null)
            $salt = $this->salt;

        $strpwd = preg_replace('/[^a-zA-Z0-9.]/s', '', $this->password);
        $key = substr($strpwd, 7, ((strlen($strpwd) - 6) > 32) ? 32 : (strlen($strpwd) - 6));

        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB, $salt);
        return trim(base64_encode($crypttext));
    }

    public function decrypt_text($value, $salt = null) {
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

    public function hash($value, $salt = null) {
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
    public function blowfishSalt($cost = 13, $rand = array()) {
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
        if ($this->password === crypt($value, $this->password))
            return $value;
        else {
            return false;
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
        if (!empty($this->password)) {
            if (preg_match('~^[a-z0-9]*[0-9][a-z0-9]*$~i', $this->password)) {
                // $subject is alphanumeric and contains at least 1 number
            } else {   // failed
                $this->addError($attribute_name, 'Enter password with digits');
            }
        }
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

        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_default_group', $this->id_default_group, true);
        $criteria->compare('id_risk', $this->id_risk, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('password_strategy', $this->password_strategy, true);
        $criteria->compare('last_password_gen', $this->last_password_gen, true);
        $criteria->compare('default_role', $this->default_role, true);
        $criteria->compare('requires_new_password', $this->requires_new_password);
        $criteria->compare('secure_key', $this->secure_key, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('is_guest', $this->is_guest);
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
        if (!isset($this->secure_key)) {
            $this->secure_key = md5(mt_rand() . mt_rand() . mt_rand());
        }
        $this->last_password_gen = new CDbExpression('NOW()');
        $this->regenerateUsername();
        return parent::beforeValidate();
    }

    public function beforeSave() {
        //add the password hash if it's a new record
        if ($this->isNewRecord) {
            if (isset($this->passwordSave, $this->repeatPassword) && ($this->passwordSave === $this->repeatPassword)) {
                $this->password = $this->hash($this->passwordSave);
            }
            //$this->password_expiry_date = new CDbExpression("DATE_ADD(NOW(), INTERVAL " . self::PASSWORD_EXPIRY . " DAY) ");
        } else
        if (!empty($this->passwordSave) && !empty($this->repeatPassword) && ($this->passwordSave === $this->repeatPassword)) {
            //if it's not a new password, save the password only if it not empty and the two passwords match
            $this->password = $this->hash($this->passwordSave);
            //$this->password_expiry_date = new CDbExpression("DATE_ADD(NOW(), INTERVAL " . self::PASSWORD_EXPIRY . " DAY) ");
        }
        $this->password_strategy = $this->encrypt_text($this->email);
        if (!in_array(Lookup::item('AccessRole', $this->default_role), Lookup::items('AccessRole'))) {
            $this->default_role = 'registered';
        }

        return parent::beforeSave();
    }
    public function afterSave() {
        //1. tao moi
        if ($this->isNewRecord && ($supplier=  Supplier::model()->findByPk($this->id_supplier))) {
            $model = CustomerSupplier::model()->findByAttributes(array('id_customer' => $this->id_customer, 'id_supplier' => $this->id_supplier));
            if($model===null){
                $model = new CustomerSupplier;
                $model->id_supplier = $this->id_supplier;
                $model->id_customer = $this->id_customer;                
            }
            $model->save(false);
        }
        //2. thay doi nha cung cap cho supplier - customer
        elseif((isset($this->old_id_supplier)||($this->old_id_supplier>0)) && isset($this->id_supplier) && ($this->id_supplier!="") && ($this->old_id_supplier!=$this->id_supplier)){
            $model = CustomerSupplier::model()->findByAttributes(array('id_customer' => $this->id_customer, 'id_supplier' => $this->old_id_supplier));
            if($model!=null){
                $model->delete();
                $newmodel = new CustomerSupplier;
                $newmodel->id_supplier = $this->id_supplier;
                $newmodel->id_customer = $this->id_customer;  
                $newmodel->updateRecord();
            }
        }
        //3. thay doi customer supplier den customer
        elseif((isset($this->old_id_supplier)||($this->old_id_supplier>0)) && (!isset($this->id_supplier) ||($this->id_supplier==""))){
            $model = CustomerSupplier::model()->findByAttributes(array('id_customer' => $this->id_customer, 'id_supplier' => $this->old_id_supplier));
            if($model!=null){
                $model->delete();
            }
        }
        //4. Cap nhat binh thuong customer hoac supplier
        else {
            $model = CustomerSupplier::model()->findByAttributes(array('id_customer' => $this->id_customer, 'id_supplier' => $this->id_supplier));
            if(($this->default_role != 'supplier') && ($model!=null)){
                $model->delete();                
            }
        }         
        return parent::afterSave();
    }

    public function afterFind() {
        $this->old_avatar = $this->avatar = ImageHelper::FindImageByPk(self::TYPE, $this->id_customer);
        try {
            if ($this->avatar != null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->avatar, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $this->old_default_role = $this->default_role;
        if($this->default_role == 'supplier'){
            $this->scenario = 'usupplier';
            $cus_sup = CustomerSupplier::model()->findByAttributes(array('id_customer'=>  $this->id_customer));
            if($cus_sup!=null) $this->old_id_supplier = $this->id_supplier = $cus_sup->id_supplier;
        }
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Customer the static model class
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
