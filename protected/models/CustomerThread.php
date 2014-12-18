<?php

/**
 * This is the model class for table "tbl_customer_thread".
 *
 * The followings are the available columns in table 'tbl_customer_thread':
 * @property string $id_customer_thread
 * @property string $id_store
 * @property string $id_contact
 * @property string $id_customer
 * @property string $id_order
 * @property string $id_product
 * @property string $status
 * @property string $email
 * @property string $token
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property CustomerMessage[] $customerMessages
 * @property Contact $idContact
 * @property Customer $idCustomer
 * @property Orders $idOrder
 * @property Product $idProduct
 * @property Store $idStore
 */
class CustomerThread extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_customer_thread';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_contact, email', 'required'),
            array('id_store, id_contact, id_customer, id_order, id_product', 'length', 'max' => 10),
            array('status', 'length', 'max' => 8),
            array('email', 'length', 'max' => 128),
            array('token', 'length', 'max' => 12),
            array('date_upd, date_add', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_customer_thread, id_store, id_contact, id_customer, id_order, id_product, status, email, token, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customerMessages' => array(self::HAS_MANY, 'CustomerMessage', 'id_customer_thread'),
            'idContact' => array(self::BELONGS_TO, 'Contact', 'id_contact'),
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_customer_thread' => 'Mã diễn đàn',
            'id_store' => 'Mã chi nhánh',
            'id_contact' => 'Mã đối tác',
            'id_customer' => 'Mã khách hàng',
            'id_order' => 'Mã đơn hàng',
            'id_product' => 'Mã sản phẩm',
            'status' => 'Trạng thái',
            'email' => 'Thư điện tử',
            'token' => 'Chuổi bảo mật',
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

        $criteria->compare('id_customer_thread', $this->id_customer_thread, true);
        $criteria->compare('id_store', $this->id_store, true);
        $criteria->compare('id_contact', $this->id_contact, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_order', $this->id_order, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('token', $this->token, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_contact, id_customer, status ASC';
        $sort->attributes = array(
            'id_contact' => 'id_contact',
            'id_customer' => 'id_customer',
            'status' => 'status'
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
        if(!isset($this->id_order) || ($this->id_order == "")) $this->id_order = null;
        if(!isset($this->id_product) || ($this->id_product == "")) $this->id_product = null;
        return parent::beforeValidate();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerThread the static model class
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
