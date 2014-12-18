<?php

/**
 * This is the model class for table "tbl_orders".
 *
 * The followings are the available columns in table 'tbl_orders':
 * @property string $id_order
 * @property string $id_carrier
 * @property string $id_customer
 * @property string $id_cart
 * @property string $id_address_delivery
 * @property string $id_address_invoice
 * @property string $id_parent
 * @property string $current_state
 * @property string $valid
 * @property string $reference
 * @property string $secure_key
 * @property string $payment
 * @property integer $gift
 * @property string $gift_message
 * @property string $shipping_number
 * @property string $total_paid
 * @property string $total_paid_tax_incl
 * @property string $total_paid_tax_excl
 * @property string $total_paid_real
 * @property string $total_products
 * @property string $total_products_wt
 * @property string $total_shipping
 * @property string $total_shipping_tax_incl
 * @property string $total_shipping_tax_excl
 * @property string $total_wrapping
 * @property string $total_wrapping_tax_incl
 * @property string $total_wrapping_tax_excl
 * @property string $invoice_number
 * @property string $invoice_date
 * @property string $delivery_number
 * @property string $delivery_date
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property CustomerThread[] $customerThreads
 * @property Message[] $messages
 * @property OrderCarrier[] $orderCarriers
 * @property OrderCartRule[] $orderCartRules
 * @property OrderDetail[] $orderDetails
 * @property OrderHistory[] $orderHistories
 * @property OrderInvoice[] $orderInvoices
 * @property OrderReturn[] $orderReturns
 * @property OrderSlip[] $orderSlips
 * @property Address $idAddressInvoice
 * @property Customer $idCustomer
 * @property Carrier $idCarrier
 * @property Cart $idCart
 * @property Address $idAddressDelivery
 * @property Orders $idParent
 * @property Orders[] $orders
 * @property StockMvt[] $stockMvts
 * @property User[] $users
 */
class Orders extends CActiveRecord {

    public $_cart;
    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_invoice_date, $old_delivery_date;
    public $total_weight;
    public $to;
    public $from;
    public $range_date;
    public $state_order;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('total_paid, total_paid_real, id_cart, id_address_delivery, id_address_invoice, current_state, invoice_date, delivery_date, date_add', 'required'),
            array('gift', 'numerical', 'integerOnly' => true),
            array('id_carrier, id_customer, id_cart, id_address_delivery, id_address_invoice, id_parent, current_state, invoice_number, delivery_number', 'length', 'max' => 10),
            array('valid', 'length', 'max' => 1),
            array('reference', 'length', 'max' => 9),
            array('secure_key, shipping_number', 'length', 'max' => 32),
            array('payment,code_bank', 'length', 'max' => 255),
            array('total_paid_tax_incl, total_paid_tax_excl, total_products, total_products_wt, total_shipping, total_shipping_tax_incl, total_shipping_tax_excl, total_wrapping, total_wrapping_tax_incl, total_wrapping_tax_excl', 'length', 'max' => 17),
            array('invoice_date, delivery_date', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('state_order, range_date, to, from, gift_message, date_upd, payment, id_customer', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('state_order, range_date, to, from, id_order, id_carrier, id_customer, id_cart, id_address_delivery, id_address_invoice, id_parent, current_state, valid, reference, secure_key, payment, gift, gift_message, shipping_number, total_paid, total_paid_tax_incl, total_paid_tax_excl, total_paid_real, total_products, total_products_wt, total_shipping, total_shipping_tax_incl, total_shipping_tax_excl, total_wrapping, total_wrapping_tax_incl, total_wrapping_tax_excl, invoice_number, invoice_date, delivery_number, delivery_date, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customerThreads' => array(self::HAS_MANY, 'CustomerThread', 'id_order'),
            'messages' => array(self::HAS_MANY, 'Message', 'id_order'),
            'orderCarriers' => array(self::HAS_MANY, 'OrderCarrier', 'id_order'),
            'orderCartRules' => array(self::HAS_MANY, 'OrderCartRule', 'id_order'),
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'id_order'),
            'orderHistories' => array(self::HAS_MANY, 'OrderHistory', 'id_order'),
            'orderInvoices' => array(self::HAS_MANY, 'OrderInvoice', 'id_order'),
            'orderReturns' => array(self::HAS_MANY, 'OrderReturn', 'id_order'),
            'orderSlips' => array(self::HAS_MANY, 'OrderSlip', 'id_order'),
            'idAddressInvoice' => array(self::BELONGS_TO, 'Address', 'id_address_invoice'),
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idCarrier' => array(self::BELONGS_TO, 'Carrier', 'id_carrier'),
            'idCart' => array(self::BELONGS_TO, 'Cart', 'id_cart'),
            'idAddressDelivery' => array(self::BELONGS_TO, 'Address', 'id_address_delivery'),
            'idParent' => array(self::BELONGS_TO, 'Orders', 'id_parent'),
            'orders' => array(self::HAS_MANY, 'Orders', 'id_parent'),
            'currentState' => array(self::BELONGS_TO, 'OrderState', 'current_state'),
            'stockMvts' => array(self::HAS_MANY, 'StockMvt', 'id_order'),
            'users' => array(self::HAS_MANY, 'User', 'id_last_order'),
            'idCart' => array(self::BELONGS_TO, 'Cart', 'id_cart'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_order' => 'Mã đơn hàng',
            'id_carrier' => 'Mã nhà Vận chuyển',
            'id_customer' => 'Mã khách hàng',
            'id_cart' => 'Mã mua hàng',
            'id_address_delivery' => 'Địa chỉ gửi hàng',
            'id_address_invoice' => 'Địa chỉ xuất hóa đơn',
            'id_parent' => 'Mã hóa đơn cha',
            'current_state' => 'Trạng thái hiện tại',
            'valid' => 'Trạng thái',
            'reference' => 'Tham khảo',
            'secure_key' => 'Từ khóa bảo mật',
            'payment' => 'Thanh toán',
            'gift' => 'Quà tặng',
            'gift_message' => 'Thông điệp quà tặng',
            'shipping_number' => 'Mã số vận chuyển',
            'total_paid' => 'Tổng tiền phải trả',
            'total_paid_tax_incl' => 'Tổng tiền bao gồm thuế',
            'total_paid_tax_excl' => 'Tổng tiền không gồm thuế',
            'total_paid_real' => 'Tổng phải trả thực sự',
            'total_products' => 'Tổng sản phẩm',
            'total_products_wt' => 'Tổng phí hoa hồng',
            'total_shipping' => 'Tổng tiền vận chuyển',
            'total_shipping_tax_incl' => 'Tổng tiền bao gồm thuế',
            'total_shipping_tax_excl' => 'Tổng tiền không gồm thuế',
            'total_wrapping' => 'Tổng phí',
            'total_wrapping_tax_incl' => 'Tổng phí bao gồm thuế',
            'total_wrapping_tax_excl' => 'Tổng phí không gồm thuế',
            'invoice_number' => 'Số hóa đơn',
            'invoice_date' => 'Ngày xuất hóa đơn',
            'delivery_number' => 'Số vận chuyển',
            'delivery_date' => 'Ngày vận chuyển',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'range_date' => 'Ngày bắt đầu - Ngày kết thúc',
            'to' => 'Ngày bắt đầu',
            'from' => 'Ngày kết thúc',
            'state_order' => 'Trạng thái đơn hàng',
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

        $criteria->compare('id_order', $this->id_order, true);
        $criteria->compare('id_carrier', $this->id_carrier, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_cart', $this->id_cart, true);
        $criteria->compare('id_address_delivery', $this->id_address_delivery, true);
        $criteria->compare('id_address_invoice', $this->id_address_invoice, true);
        $criteria->compare('id_parent', $this->id_parent, true);
        $criteria->compare('current_state', $this->current_state, true);
        $criteria->compare('valid', $this->valid, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('secure_key', $this->secure_key, true);
        $criteria->compare('payment', $this->payment, true);
        $criteria->compare('gift', $this->gift);
        $criteria->compare('gift_message', $this->gift_message, true);
        $criteria->compare('shipping_number', $this->shipping_number, true);
        $criteria->compare('total_paid', $this->total_paid, true);
        $criteria->compare('total_paid_tax_incl', $this->total_paid_tax_incl, true);
        $criteria->compare('total_paid_tax_excl', $this->total_paid_tax_excl, true);
        $criteria->compare('total_paid_real', $this->total_paid_real, true);
        $criteria->compare('total_products', $this->total_products, true);
        $criteria->compare('total_products_wt', $this->total_products_wt, true);
        $criteria->compare('total_shipping', $this->total_shipping, true);
        $criteria->compare('total_shipping_tax_incl', $this->total_shipping_tax_incl, true);
        $criteria->compare('total_shipping_tax_excl', $this->total_shipping_tax_excl, true);
        $criteria->compare('total_wrapping', $this->total_wrapping, true);
        $criteria->compare('total_wrapping_tax_incl', $this->total_wrapping_tax_incl, true);
        $criteria->compare('total_wrapping_tax_excl', $this->total_wrapping_tax_excl, true);
        $criteria->compare('invoice_number', $this->invoice_number, true);
        $criteria->compare('invoice_date', $this->invoice_date, true);
        $criteria->compare('delivery_number', $this->delivery_number, true);
        $criteria->compare('delivery_date', $this->delivery_date, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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

    public function searchByCarrier($id_carrier) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_carrier', $id_carrier);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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
        $criteria->addCondition('("' . $begin . '" <= date_add) AND (date_add <= "' . $end . '") ');
        $criteria->compare('id_cart', $this->id_cart, true);
        $criteria->compare('id_order', $this->id_order, true);
        $criteria->compare('id_parent', $this->id_parent, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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
    
    public function searchByRange() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if(isset($this->to) && isset($this->from)){
            //$criteria->mergeWith($this->dateRangeSearchCriteria('date_add', array($this->to,  $this->from)));  
            $criteria->addBetweenCondition('date_add', $this->from, $this->to, 'AND');
        }            
        else $criteria->compare('date_add', $this->date_add, true);
        
        if(isset($this->current_state) && ($state = OrderState::model()->findByPk($this->current_state))){
            $criteria->compare('current_state', $this->current_state, true);
        }
        
        $sort = new CSort;
        $sort->defaultOrder = 'total_paid, total_paid_real, date_add, delivery_date ASC';
        $sort->attributes = array(
            'total_paid' => 'total_paid',
            'total_paid_real' => 'total_paid_real',
            'date_add' => 'date_add',
            'delivery_date' => 'delivery_date'
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
    
    public function searchByState($state = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if($stateOrder = OrderState::model()->findByPk($state))
            $criteria->compare('current_state', $stateOrder->id_order_state);
        else {
            $criteria->compare('current_state', $this->current_state, true);
        }

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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
    
    public function searchByNewState() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $values = array(1,2,3,4);
        $criteria->addInCondition('current_state', $values);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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
    
    public function searchByPendingState() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $values = array(3,4);
        $criteria->addInCondition('current_state', $values);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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
    public function searchBySuccessState() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $values = array(5,6,7,8,9,10,11);
        $criteria->addInCondition('current_state', $values);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_cart, id_parent ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_parent' => 'id_parent',
            'id_cart' => 'id_cart'
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
        if (isset($this->id_cart) && isset($this->idCart)) {
            $this->secure_key = $this->idCart->secure_key;
        } elseif (isset($this->id_cart) && ($cart = Cart::model()->findByPk($this->id_cart))) {
            $this->secure_key = $cart->secure_key;
        }
        if ($this->isNewRecord)
            $this->date_add = date('Y-m-d H:i:s', time());
        else
            $this->date_upd = date('Y-m-d H:i:s', time());
        return parent::beforeValidate();
    }

    public function afterValidate() {
        return parent::afterValidate();
    }

    public function beforeSave() {
        if (isset($this->id_cart) && isset($this->idCart)) {
            $this->secure_key = $this->idCart->secure_key;
        } elseif (isset($this->id_cart) && ($cart = Cart::model()->findByPk($this->id_cart))) {
            $this->secure_key = $cart->secure_key;
        }
        $this->current_state = 4; /* Đang xử lý thanh toán */
        if ($this->isNewRecord)
            $this->date_add = date('Y-m-d H:i:s', time());
        else
            $this->date_upd = date('Y-m-d H:i:s', time());

        if (isset($this->delivery_date) && (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->delivery_date))) {
            $date = DateTime::createFromFormat($this->in_format, $this->delivery_date);
            $this->delivery_date = $date->format($this->out_format);
        } else
            $this->delivery_date = date('Y-m-d H:i:s', time());

        if (isset($this->invoice_date) && (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->invoice_date))) {
            $date = DateTime::createFromFormat($this->in_format, $this->invoice_date);
            $this->invoice_date = $date->format($this->out_format);
        } else
            $this->invoice_date = date('Y-m-d H:i:s', time());

        return parent::beforeSave();
    }

    public function afterSave() {
        $this->addOrderDetail();

        if (isset($this->delivery_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->delivery_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->delivery_date);
            $this->delivery_date = $date->format($this->out_format);
        }

        if (isset($this->invoice_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->invoice_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->invoice_date);
            $this->invoice_date = $date->format($this->out_format);
        }
        if ($current = OrderState::model()->findByPk($this->current_state)) {
            $orderhistory = new OrderHistory;
            $orderhistory->id_order = $this->getPrimaryKey();
            $orderhistory->id_order_state = $this->current_state;
            $orderhistory->id_user = null;
            $orderhistory->save(true);
        }

        return parent::afterSave();
    }

    public function afterFind() {
        if (isset($this->delivery_date)) {
            $date = DateTime::createFromFormat($this->out_format, $this->delivery_date);
            $this->old_delivery_date = $this->delivery_date = $date->format($this->in_format);
        }
        if (isset($this->invoice_date)) {
            $date = DateTime::createFromFormat($this->out_format, $this->invoice_date);
            $this->old_invoice_date = $this->invoice_date = $date->format($this->in_format);
        }
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Orders the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    

    public function autoCalShip(Cart $cart) {
        if (($carrier = Carrier::model()->findByPk($cart->id_carrier)) && ($zone = Zone::model()->findByPk($cart->idAddressDelivery->id_zone))) {
            $ca_zo = CarrierZone::model()->findByPk(array('id_carrier' => $carrier->id_carrier, 'id_zone' => $zone->id_zone));
            if ($ca_zo == null) {
                $ca_zo = new CarrierZone;
                $ca_zo->id_carrier = $carrier->id_carrier;
                $ca_zo->id_zone = $zone->id_zone;
                $ca_zo->updateRecord();
                return 0; //not found
            }
            $criteria = new CDbCriteria;
            $criteria->compare('id_carrier', $cart->id_carrier);
            $criteria->compare('id_zone', $zone->id_zone);
            $criteria->addCondition("range_weight IS NOT NULL");
            $criteria->addCondition("range_price IS NULL");
            $criteria->addCondition("range_distant IS NULL");
            if ($deliveries = Delivery::model()->findAll($criteria)) {
                foreach ($deliveries as $delivery) {
                    if (($delivery->rangeWeight->delimiter1 <= $this->total_weight) && ($this->total_weight <= $delivery->rangeWeight->delimiter2)) {
                        return $delivery->price;
                        break;
                    }
                }
                return 0; //not found
            }
//            else {
//                dump($carrier);
//                dump($zone);
//                exit();
//            }
        }
    }

    public function sumTotal(Cart $cart) {
        if ((get_class($cart) == "Cart") && isset($cart->customizations) && (count($cart->customizations) > 0)) {

            foreach ($cart->customizations as $customization) {
                $criteria2 = new CDbCriteria;
                $criteria2->compare('id_cart', $cart->getPrimaryKey());
                $criteria2->compare('id_product', $customization->id_product);
                if (isset($customization->id_product_attribute) && ($pro_att = ProductAttribute::model()->findByPk($customization->id_product_attribute))) {
                    $criteria2->compare('id_product_attribute', $customization->id_product_attribute);

                    $this->total_weight += $pro_att->weight;
                } else {
                    $criteria2->addCondition('id_product_attribute IS NULL');
                    if ($pro = Product::model()->findByPk($customization->id_product))
                        $this->total_weight += $pro->weight;
                }

                if ($price = SpecificPrice::model()->find($criteria2)) {
                    $this->total_paid += $price->price * $customization->quantity;
                    try {
                        if ($price->reduction_type == 'percentage') {
                            $reduction = round((($price->price * $price->reduction) / 100), 2);
                        } elseif ($price->reduction_type == 'amount') {
                            $reduction = round($price->reduction, 2);
                        }
                        $this->total_paid_real += ($price->price - $reduction) * $customization->quantity;
                    } catch (Exception $e) {
                        throw new Exception("Divide error.");
                    }
                }
            }
            //$this->total_shipping = $this->total_shipping_tax_excl = $this->autoCalShip($cart);
        }
        $this->total_paid_tax_incl = $this->total_paid_tax_excl = $this->total_paid;
        $this->total_paid_tax_incl = 0;
        $this->total_wrapping = $this->total_wrapping_tax_excl = $this->total_wrapping_tax_incl = 0;
    }

    public function addOrderDetail() {
        if ((get_class($this->_cart) == "Cart") && isset($this->_cart->customizations) && (count($this->_cart->customizations) > 0)) {
            foreach ($this->_cart->customizations as $customization) {
                $criteria = new CDbCriteria;
                $criteria->compare('id_order', $this->getPrimaryKey());
                $criteria->compare('id_product', $customization->id_product);
                $criteria->compare('id_product_attribute', $customization->id_product_attribute);
                $model = OrderDetail::model()->find($criteria);

                //model is new, so create a copy with the keys set
                if (null === $model) {
                    //we don't use clone $this as it can leave off behaviors and events
                    $model = new OrderDetail;
                    $model->id_order = $this->getPrimaryKey();
                    $model->id_product = $customization->id_product;
                    $model->id_product_attribute = $customization->id_product_attribute;
                }

                $model->quantity = $customization->quantity;
                $criteria2 = new CDbCriteria;
                $criteria2->compare('id_cart', $this->_cart->getPrimaryKey());
                $criteria2->compare('id_product', $customization->id_product);
                if (isset($customization->id_product_attribute) && ($pro_att = ProductAttribute::model()->findByPk($customization->id_product_attribute)))
                    $criteria2->compare('id_product_attribute', $customization->id_product_attribute);
                else
                    $criteria2->addCondition('id_product_attribute IS NULL');

                if ($price = SpecificPrice::model()->find($criteria2)) {
                    $model->unit_price_tax_incl = $price->price;
                    $model->total_price_tax_incl = $model->unit_price_tax_incl * $model->quantity;
                    $model->price = $price->price * $model->quantity;
                    try {
                        if ($price->reduction_type == 'percentage') {
                            $model->reduction_percent = $price->reduction;
                            $model->reduction_amount = round((($price->price * $model->reduction_percent) / 100) * $model->quantity, 2);
                        } elseif ($price->reduction_type == 'amount') {
                            $model->reduction_amount = $price->reduction;
                            if ($price->price != 0)
                                $model->reduction_percent = round(($model->reduction_amount * 100) / $price->price, 2);
                            else
                                $model->reduction_percent = 0;
                        }
                    } catch (Exception $e) {
                        throw new Exception("Divide error.");
                    }
                }
                if ($warehouse = WarehouseProductLocation::model()->findByAttributes(
                        array('id_product' => $customization->id_product, 'id_product_attribute' => $customization->id_product_attribute), array(
                    'condition' => 'id_warehouse>:id_warehouse',
                    'params' => array(':id_warehouse' => 0)
                        ))
                ) {
                    $model->id_warehouse = $warehouse->id_warehouse;
                } else
                    $model->id_warehouse = null;

                $model->save(true);
            }
        }
    }

    public function updateOrderFromCart(Cart $cart) {
        if (get_class($cart) == "Cart") {
            $criteria = new CDbCriteria;
            $criteria->compare('id_cart', $cart->id_cart);
            $criteria->addCondition('id_parent IS NULL');
            $model = self::model()->find($criteria);

            //model is new, so create a copy with the keys set
            if (null === $model) {
                //we don't use clone $this as it can leave off behaviors and events
                $model = new self;
                $model->id_cart = $this->id_cart;
                $model->id_parent = null;
                $model->id_address_delivery = $cart->id_address_delivery;
                $model->id_address_invoice = $cart->id_address_invoice;
                $model->id_carrier = $cart->id_carrier;
                $model->id_customer = $cart->id_customer;
                $model->gift = $cart->gift;
                $model->gift_message = $cart->gift_message;
            }

            $model->total_paid = $model->total_paid_real = 0;
            $model->_cart = $cart;
            $model->sumTotal($cart);
            $model->total_shipping = $model->total_shipping_tax_excl = $model->autoCalShip($cart);
            $model->total_paid_real += $model->total_shipping;
            if ($model->save(false)) {
                return $model;
            }
        }
        return null;
    }

    public function updateChangeDetail(Cart $cart) {
        if (get_class($cart) == "Cart") {
            $criteria = new CDbCriteria;
            $criteria->compare('id_cart', $cart->id_cart);
            $criteria->addCondition('id_parent IS NULL');
            $model = self::model()->find($criteria);

            //model is new, so create a copy with the keys set
            if (null === $model) {
                //we don't use clone $this as it can leave off behaviors and events
                $model = new self;
                $model->id_cart = $this->id_cart;
                $model->id_parent = null;
                $model->id_address_delivery = $cart->id_address_delivery;
                $model->id_address_invoice = $cart->id_address_invoice;
                $model->id_carrier = $cart->id_carrier;
                $model->id_customer = $cart->id_customer;
                $model->gift = $cart->gift;
                $model->gift_message = $cart->gift_message;
            }

            $model->total_paid = 0;
            $model->total_weight = 0;
            $model->_cart = $cart;
            $model->sumTotal($cart);
            if ($model->save(false)) {
                return $model;
            }
        }
        return null;
    }

    public function setCart($id_cart) {
        if ($this->_cart = Cart::model()->findByPk($id_cart)) {
            $this->id_cart = $this->_cart->id_cart;
            $order = $this->updateOrderFromCart($this->_cart);
            return $order;
        } else {
            return null;
        }
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'common.extensions.behaviors.AutoTimestampBehavior',
            //You can optionally set the field name options here
            ),
            'dateRangeSearch'=>array(
                'class'=>'common.extensions.behaviors.EDateRangeSearchBehavior',
                'dateDb' => '%Y-%m-%d %H:%M:%S',
                'dateInput' => '%d/%m/%Y'
             ),
//            'crypt' => array(
//                // this assumes that the behavior is in the folder: protected/behaviors/
//                'class' => 'common.extensions.behaviors.crypt.ECryptBehavior',
//                // this sets that the attributes to be encrypted/decrypted are encrypted fieldname of the model
//                'attributes' => array('total_paid', 'total_paid_real', 'total_shipping', 'total_wrapping'),
//                'useAESMySql' => false
//        )
        );
    }
}
