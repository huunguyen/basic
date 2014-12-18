<?php

/**
 * This is the model class for table "tbl_order_invoice".
 *
 * The followings are the available columns in table 'tbl_order_invoice':
 * @property string $id_order_invoice
 * @property string $id_order
 * @property integer $number
 * @property integer $delivery_number
 * @property string $delivery_date
 * @property string $total_paid_tax_excl
 * @property string $total_paid_tax_incl
 * @property string $total_products
 * @property string $total_products_wt
 * @property string $total_shipping_tax_excl
 * @property string $total_shipping_tax_incl
 * @property string $total_wrapping_tax_excl
 * @property string $total_wrapping_tax_incl
 * @property string $note
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property OrderCarrier[] $orderCarriers
 * @property OrderCartRule[] $orderCartRules
 * @property Orders $idOrder
 * @property OrderPayment[] $tblOrderPayments
 */
class OrderInvoice extends CActiveRecord {

    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_delivery_date;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_order_invoice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_order,', 'required'),
            array('number, delivery_number', 'numerical', 'integerOnly' => true),
            array('id_order', 'length', 'max' => 10),
            array('total_paid_tax_excl, total_paid_tax_incl, total_products, total_products_wt, total_shipping_tax_excl, total_shipping_tax_incl, total_wrapping_tax_excl, total_wrapping_tax_incl', 'length', 'max' => 17),
            array('delivery_date', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('delivery_date, note, date_upd, number, delivery_number, date_add', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_order_invoice, id_order, number, delivery_number, delivery_date, total_paid_tax_excl, total_paid_tax_incl, total_products, total_products_wt, total_shipping_tax_excl, total_shipping_tax_incl, total_wrapping_tax_excl, total_wrapping_tax_incl, note, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'orderCarriers' => array(self::HAS_MANY, 'OrderCarrier', 'id_order_invoice'),
            'orderCartRules' => array(self::HAS_MANY, 'OrderCartRule', 'id_order_invoice'),
            'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
            'tblOrderPayments' => array(self::MANY_MANY, 'OrderPayment', 'tbl_order_invoice_payment(id_order_invoice, id_order_payment)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_order_invoice' => 'Mã hóa đơn',
            'id_order' => 'Mã đơn hàng',
            'number' => 'Số hóa đơn',
            'delivery_number' => 'Mã số vận chuyển',
            'delivery_date' => 'Ngày giao hàng',
            'total_paid_tax_excl' => 'Tổng trả chưa thuế',
            'total_paid_tax_incl' => 'Tổng trả có thuế',
            'total_products' => 'Tổng sản phẩm',
            'total_products_wt' => 'Tổng phí hoa hồng',
            'total_shipping_tax_excl' => 'Tổng vận chuyển chưa thuế',
            'total_shipping_tax_incl' => 'Tổng vận chuyển có thuế',
            'total_wrapping_tax_excl' => 'Tổng cộng thêm chưa thuế',
            'total_wrapping_tax_incl' => 'Tổng cộng thêm có thuế',
            'note' => 'Ghi chú',
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

        $criteria->compare('id_order_invoice', $this->id_order_invoice, true);
        $criteria->compare('id_order', $this->id_order, true);
        $criteria->compare('number', $this->number);
        $criteria->compare('delivery_number', $this->delivery_number);
        $criteria->compare('delivery_date', $this->delivery_date, true);
        $criteria->compare('total_paid_tax_excl', $this->total_paid_tax_excl, true);
        $criteria->compare('total_paid_tax_incl', $this->total_paid_tax_incl, true);
        $criteria->compare('total_products', $this->total_products, true);
        $criteria->compare('total_products_wt', $this->total_products_wt, true);
        $criteria->compare('total_shipping_tax_excl', $this->total_shipping_tax_excl, true);
        $criteria->compare('total_shipping_tax_incl', $this->total_shipping_tax_incl, true);
        $criteria->compare('total_wrapping_tax_excl', $this->total_wrapping_tax_excl, true);
        $criteria->compare('total_wrapping_tax_incl', $this->total_wrapping_tax_incl, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, delivery_date ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
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

    public function beforeSave() {
        if (!isset($this->number)) {
            $this->number = 1;
        }
        if (!isset($this->delivery_number)) {
            $this->delivery_number = 1;
        }
        if (isset($this->delivery_date) && (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->delivery_date))) {
            $date = DateTime::createFromFormat($this->in_format, $this->delivery_date);
            $this->delivery_date = $date->format($this->out_format);
        } else
            $this->delivery_date = date('Y-m-d H:i:s', time());
        return parent::beforeSave();
    }

    public function afterFind() {
        if (isset($this->delivery_date)) {
            $date = DateTime::createFromFormat($this->out_format, $this->delivery_date);
            $this->old_delivery_date = $this->delivery_date = $date->format($this->in_format);
        }
        return parent::afterFind();
    }

    public function afterSave() {
        if (isset($this->delivery_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->delivery_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->delivery_date);
            $this->delivery_date = $date->format($this->out_format);
        }
        return parent::afterSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderInvoice the static model class
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
