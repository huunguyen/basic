<?php

/**
 * This is the model class for table "tbl_cart".
 *
 * The followings are the available columns in table 'tbl_cart':
 * @property string $id_cart
 * @property string $id_store
 * @property string $id_carrier
 * @property string $id_address_delivery
 * @property string $id_address_invoice
 * @property string $id_customer
 * @property string $id_guest
 * @property string $secure_key
 * @property string $delivery_option
 * @property integer $recyclable
 * @property integer $gift
 * @property string $gift_message
 * @property integer $allow_seperated_package
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Customer $idCustomer
 * @property Address $idAddressDelivery
 * @property Address $idAddressInvoice
 * @property Carrier $idCarrier
 * @property Guest $idGuest
 * @property Store $idStore
 * @property CartRule[] $tblCartRules
 * @property Product[] $tblProducts
 * @property Customization[] $customizations
 * @property Message[] $messages
 * @property Orders[] $orders
 * @property SpecificPrice[] $specificPrices
 */
class Cart extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_cart';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_carrier, id_address_delivery, id_address_invoice,id_guest, date_add', 'required'),
            array('recyclable, gift, allow_seperated_package', 'numerical', 'integerOnly' => true),
            array('id_store, id_carrier, id_address_delivery, id_address_invoice, id_customer, id_guest', 'length', 'max' => 10),
            array('secure_key', 'length', 'max' => 32),
            array('delivery_option', 'length', 'max' => 100),
            array('gift_message, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_cart, id_store, id_carrier, id_address_delivery, id_address_invoice, id_customer, id_guest, secure_key, delivery_option, recyclable, gift, gift_message, allow_seperated_package, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idAddressDelivery' => array(self::BELONGS_TO, 'Address', 'id_address_delivery'),
            'idAddressInvoice' => array(self::BELONGS_TO, 'Address', 'id_address_invoice'),
            'idCarrier' => array(self::BELONGS_TO, 'Carrier', 'id_carrier'),
            'idGuest' => array(self::BELONGS_TO, 'Guest', 'id_guest'),
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
            'tblCartRules' => array(self::MANY_MANY, 'CartRule', 'tbl_cart_cart_rule(id_cart, id_cart_rule)'),
            'tblProducts' => array(self::MANY_MANY, 'Product', 'tbl_cart_product(id_cart, id_product)'),
            'customizations' => array(self::HAS_MANY, 'Customization', 'id_cart'),
            'messages' => array(self::HAS_MANY, 'Message', 'id_cart'),
            'orders' => array(self::HAS_MANY, 'Orders', 'id_cart'),
            'specificPrices' => array(self::HAS_MANY, 'SpecificPrice', 'id_cart'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_cart' => 'Mã giỏ hàng',
            'id_store' => 'Mã chi nhánh',
            'id_carrier' => 'Mã nhà vận chuyển',
            'id_address_delivery' => 'Mã địa chỉ nhận hàng',
            'id_address_invoice' => 'Mã địa chỉ nhận hóa đơn',
            'id_customer' => 'Mã khách hàng',
            'id_guest' => 'Mã khách',
            'secure_key' => 'Mã bảo mật',
            'delivery_option' => 'Phương thức vận chuyển',
            'recyclable' => 'Recyclable',
            'gift' => 'Quà tặng',
            'gift_message' => 'Thông điệp tặng quà',
            'allow_seperated_package' => 'Cho phép gói phân nhỏ',
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

        $criteria->compare('id_cart', $this->id_cart, true);
        $criteria->compare('id_store', $this->id_store, true);
        $criteria->compare('id_carrier', $this->id_carrier, true);
        $criteria->compare('id_address_delivery', $this->id_address_delivery, true);
        $criteria->compare('id_address_invoice', $this->id_address_invoice, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_guest', $this->id_guest, true);
        $criteria->compare('secure_key', $this->secure_key, true);
        $criteria->compare('delivery_option', $this->delivery_option, true);
        $criteria->compare('recyclable', $this->recyclable);
        $criteria->compare('gift', $this->gift);
        $criteria->compare('gift_message', $this->gift_message, true);
        $criteria->compare('allow_seperated_package', $this->allow_seperated_package);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_cart, date_add, id_carrier ASC';
        $sort->attributes = array(
            'id_cart' => 'id_cart',
            'date_add' => 'date_add',
            'id_carrier' => 'id_carrier'
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

    public function searchByLastMonth($days = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if (!isset($days) || !is_numeric($days))
            $days = 60 * 60 * 24 * 30; // 30 days
        $begin = date('Y-m-d H:i:s', time() - $days);
        $end = date('Y-m-d H:i:s', time());


        $criteria = new CDbCriteria;
        $criteria->addCondition('("' . $begin . '" < date_add) AND (date_add < "' . $end . '") ');
        $criteria->compare('id_cart', $this->id_cart, true);
        $criteria->compare('id_carrier', $this->id_carrier, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_cart, date_add, id_carrier ASC';
        $sort->attributes = array(
            'id_cart' => 'id_cart',
            'date_add' => 'date_add',
            'id_carrier' => 'id_carrier'
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
        if ($this->isNewRecord) {
            $this->secure_key = PostHelper::rand_string();
            
            $criteria = new CDbCriteria();
            $criteria->condition = "secure_key>=:secure_key";
            $criteria->params = array(":secure_key" => $this->secure_key);
            
        } elseif (!isset($this->secure_key) || ($this->secure_key == "")) {
            $this->secure_key = PostHelper::rand_string();
            
            $criteria = new CDbCriteria();
            $criteria->condition = "(id_cart <> :id_cart) AND (secure_key=:secure_key)";
            $criteria->params = array(":id_cart" => $this->id_cart, ":secure_key" => $this->secure_key);
            
        }
        $callStartTime = microtime(true);
        while ($cart = Cart::model()->find($criteria)) {
            $criteria = new CDbCriteria();
            $criteria->condition = "(id_cart <> :id_cart) AND (secure_key=:secure_key)";
            $criteria->params = array(":id_cart" => $this->id_cart, ":secure_key" => $this->secure_key);
            $callEndTime = microtime(true);
            $callTime = $callEndTime - $callStartTime;
          if($callTime>=100*60){
              $this->addError('secure_key', 'Sinh mã cho giỏ hàng bị lỗi. Xin vui lòng cố gắng lại một lần nữa!');
              break;
          }
          else
            $this->secure_key = PostHelper::rand_string();          
        }
        if($cart = Cart::model()->find($criteria)){
            $this->addError('secure_key', 'Sinh mã cho giỏ hàng bị lỗi. Xin vui lòng cố gắng lại một lần nữa!');
        }
        
        if (!isset($this->id_carrier))
            $this->id_carrier = 1;
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (!isset($this->id_carrier))
            $this->id_carrier = 1;

        if (isset($this->id_address_delivery) && isset($this->id_carrier) && ($delivery = Address::model()->findByPk($this->id_address_delivery)) && ($carrier = Carrier::model()->findByPk($this->id_carrier))) {
            $ca_zo = CarrierZone::model()->findByPk(array('id_carrier' => $carrier->id_carrier, 'id_zone' => $delivery->id_zone));
            if ($ca_zo == null) {
                $ca_zo = new CarrierZone;
                $ca_zo->id_carrier = $carrier->id_carrier;
                $ca_zo->id_zone = $delivery->id_zone;
                $ca_zo->updateRecord();
            }
        }

        if (isset($this->id_address_invoice) && isset($this->id_carrier) && ($invoice = Address::model()->findByPk($this->id_address_invoice)) && ($carrier = Carrier::model()->findByPk($this->id_carrier))) {
            $ca_zo = CarrierZone::model()->findByPk(array('id_carrier' => $carrier->id_carrier, 'id_zone' => $invoice->id_zone));
            if ($ca_zo == null) {
                $ca_zo = new CarrierZone;
                $ca_zo->id_carrier = $carrier->id_carrier;
                $ca_zo->id_zone = $delivery->id_zone;
                $ca_zo->updateRecord();
            }
        }

        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cart the static model class
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
