<?php

/**
 * This is the model class for table "tbl_message".
 *
 * The followings are the available columns in table 'tbl_message':
 * @property string $id_message
 * @property string $id_cart
 * @property string $id_customer
 * @property string $id_user
 * @property string $id_order
 * @property string $title
 * @property string $message
 * @property integer $private
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Cart $idCart
 * @property Customer $idCustomer
 * @property User $idUser
 * @property Orders $idOrder
 * @property User[] $tblUsers
 */
class Message extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_message';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_order, id_cart, id_customer, message', 'required'),
            array('private', 'numerical', 'integerOnly' => true),
            array('id_order, id_cart, id_customer, id_user, id_order', 'length', 'max' => 10),
            array('title', 'length', 'max' => 255),
            array('date_upd, date_add', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_message, id_cart, id_customer, id_user, id_order, title, message, private, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idCart' => array(self::BELONGS_TO, 'Cart', 'id_cart'),
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
            'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
            'tblUsers' => array(self::MANY_MANY, 'User', 'tbl_message_readed(id_message, id_user)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_message' => 'Mã tin',
            'id_cart' => 'Mã giỏ hàng',
            'id_customer' => 'Mã khách hàng',
            'id_user' => 'Mã người dùng',
            'id_order' => 'Mã đơn hàng',
            'title' => 'Tiêu đề',
            'message' => 'Nội dung',
            'private' => 'Bảo mật',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
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

        $criteria->compare('id_message', $this->id_message, true);
        $criteria->compare('id_cart', $this->id_cart, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('id_order', $this->id_order, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('private', $this->private);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_user, id_customer, id_message ASC';
        $sort->attributes = array(
            'id_user' => 'id_user',
            'id_customer' => 'id_customer',
            'id_message' => 'id_message'
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
    public function searchByCustomer($id_customer) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_customer', $id_customer);

        $sort = new CSort;
        $sort->defaultOrder = 'id_user, id_customer, id_message ASC';
        $sort->attributes = array(
            'id_user' => 'id_user',
            'id_customer' => 'id_customer',
            'id_message' => 'id_message'
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
    public function searchByUser($id_user) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_user', $id_user);

        $sort = new CSort;
        $sort->defaultOrder = 'id_user, id_customer, id_message ASC';
        $sort->attributes = array(
            'id_user' => 'id_user',
            'id_customer' => 'id_customer',
            'id_message' => 'id_message'
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
    public function searchByCart($id_cart) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_cart', $id_cart);

        $sort = new CSort;
        $sort->defaultOrder = 'id_user, id_customer, id_message ASC';
        $sort->attributes = array(
            'id_user' => 'id_user',
            'id_customer' => 'id_customer',
            'id_message' => 'id_message'
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
    public function searchByOrder($id_order) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_order', $id_order);

        $sort = new CSort;
        $sort->defaultOrder = 'id_user, id_customer, id_message ASC';
        $sort->attributes = array(
            'id_user' => 'id_user',
            'id_customer' => 'id_customer',
            'id_message' => 'id_message'
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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
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
