<?php

/**
 * This is the model class for table "tbl_customer_message".
 *
 * The followings are the available columns in table 'tbl_customer_message':
 * @property string $id_customer_message
 * @property string $id_customer_thread
 * @property string $id_user
 * @property string $title
 * @property string $message
 * @property string $file_name
 * @property integer $ip_address
 * @property string $user_agent
 * @property string $date_add
 * @property string $date_upd
 * @property integer $private
 *
 * The followings are the available model relations:
 * @property CustomerThread $idCustomerThread
 * @property User $idUser
 * @property User[] $users
 */
class CustomerMessage extends CActiveRecord {
    const TYPE = "mes";
    public $old_file;
    public $thumbnail;
    public $isUser = false;
    public $verifyCode;
    public $verification_code;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_customer_message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_customer_thread, message', 'required'),
            array('file_name', 'length', 'max' => 255, 'tooLong' => '{attribute} quá lớn (tối đa {max} ký tự).', 'on' => 'update,create'),
            array('file_name', 'file', 'types' => 'jpeg, jpg, gif, png, txt, doc, docx, xls, xlsx, ppt, pptx, zip, rar', 'allowEmpty' => true, 'maxSize' => 1024 * 1024 * 10, 'on' => 'create, update, insert, reply'),
                       
            array('ip_address, private', 'numerical', 'integerOnly' => true),
            array('id_customer_thread, id_user', 'length', 'max' => 10),
            array('title', 'length', 'max' => 255),
            array('user_agent', 'length', 'max' => 128),
            array('date_upd, date_add', 'safe'),
            array('verification_code', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'on'=>'requestByCustomer'),
            array('verifyCode', 'captcha', 'allowEmpty'=>true, 'on' => 'replyByAdmin'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_customer_message, id_customer_thread, id_user, title, message, file_name, ip_address, user_agent, date_add, date_upd, private', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idCustomerThread' => array(self::BELONGS_TO, 'CustomerThread', 'id_customer_thread'),
            'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
            'users' => array(self::HAS_MANY, 'User', 'id_last_customer_message'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_customer_message' => 'Mã tin khách hàng',
            'id_customer_thread' => 'Mã diễn đàn',
            'id_user' => 'Mã người dùng',
            'title' => 'Tiêu đề',
            'message' => 'Nội dung',
            'file_name' => 'Tên tập tin',
            'ip_address' => 'Địa chỉ IP',
            'user_agent' => 'User Agent',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'private' => 'Riêng tư',
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

        $criteria->compare('id_customer_message', $this->id_customer_message, true);
        $criteria->compare('id_customer_thread', $this->id_customer_thread, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('file_name', $this->file_name, true);
        $criteria->compare('ip_address', $this->ip_address);
        $criteria->compare('user_agent', $this->user_agent, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('private', $this->private);

        $sort = new CSort;
        $sort->defaultOrder = 'id_customer_thread, id_user, user_agent ASC';
        $sort->attributes = array(
            'id_customer_thread' => 'id_customer_thread',
            'id_user' => 'id_user',
            'user_agent' => 'user_agent'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 10),
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
    public function searchByThread($id_customer_thread) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if (isset($id_customer_thread)) {
            $criteria->compare('id_customer_thread', $id_customer_thread);
        } else {
            $criteria->compare('id_customer_thread', $this->id_customer_thread, true);
        }

        $sort = new CSort;
        $sort->defaultOrder = 'id_customer_thread, id_user, date_add ASC';
        $sort->attributes = array(
            'id_customer_thread' => 'id_customer_thread',
            'id_user' => 'id_user',
            'date_add' => 'date_add'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 10),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if(!isset($this->ip_address)){
            $this->ip_address = PostHelper::getUserHostAddress();
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if ($this->isUser) {
            CustomerThread::model()->updateByPk($this->id_customer_thread, array('status' => 'pending2'));
        } else {
            CustomerThread::model()->updateByPk($this->id_customer_thread, array('status' => 'pending1'));
        }
        return parent::afterSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerMessage the static model class
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
