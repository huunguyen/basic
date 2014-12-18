<?php

/**
 * This is the model class for table "tbl_order_carrier".
 *
 * The followings are the available columns in table 'tbl_order_carrier':
 * @property integer $id_order_carrier
 * @property string $id_order
 * @property string $id_carrier
 * @property string $id_order_invoice
 * @property double $weight
 * @property double $distant
 * @property double $price
 * @property string $method
 * @property string $shipping_cost_tax_excl
 * @property string $shipping_cost_tax_incl
 * @property string $tracking_number
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property OrderInvoice $idOrderInvoice
 * @property Orders $idOrder
 * @property Carrier $idCarrier
 */
class OrderCarrier extends CActiveRecord
{
    public $_rangeDistant;
    public $_rangePrice;
    public $_rangeWeight;
    public $_id_range;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_carrier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order, id_carrier, date_add', 'required'),
			array('weight, distant, price', 'numerical'),
			array('id_order, id_carrier, id_order_invoice', 'length', 'max'=>10),
			array('method', 'length', 'max'=>7),
			array('shipping_cost_tax_excl, shipping_cost_tax_incl', 'length', 'max'=>20),
			array('tracking_number', 'length', 'max'=>64),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_order_carrier, id_order, id_carrier, id_order_invoice, weight, distant, price, method, shipping_cost_tax_excl, shipping_cost_tax_incl, tracking_number, date_add, date_upd', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idOrderInvoice' => array(self::BELONGS_TO, 'OrderInvoice', 'id_order_invoice'),
			'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
			'idCarrier' => array(self::BELONGS_TO, 'Carrier', 'id_carrier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_order_carrier' => 'Mã DHVC',
			'id_order' => 'Mã đơn hàng',
			'id_carrier' => 'Mã nhà Vận chuyển',
			'id_order_invoice' => 'Mã hóa đơn',
			'weight' => 'Cân nặng',
			'distant' => 'Khoản cách',
			'price' => 'Giá Tính',
			'method' => 'Phương pháp tính',
			'shipping_cost_tax_excl' => 'Tổng chi phí vận chuyển không thuế',
			'shipping_cost_tax_incl' => 'Tổng chi phí vận chuyển có thuế',
			'tracking_number' => 'Số vận chuyển',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_order_carrier',$this->id_order_carrier);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('id_carrier',$this->id_carrier,true);
		$criteria->compare('id_order_invoice',$this->id_order_invoice,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('distant',$this->distant);
		$criteria->compare('price',$this->price);
		$criteria->compare('method',$this->method,true);
		$criteria->compare('shipping_cost_tax_excl',$this->shipping_cost_tax_excl,true);
		$criteria->compare('shipping_cost_tax_incl',$this->shipping_cost_tax_incl,true);
		$criteria->compare('tracking_number',$this->tracking_number,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		$sort = new CSort;
        $sort->defaultOrder = 'id_order, id_carrier, date_add ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_carrier' => 'id_carrier',
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
        if ($this->isNewRecord) {
            $this->tracking_number = PostHelper::rand_string();
        } elseif (!isset($this->tracking_number) || ($this->tracking_number == "")) {
            $this->tracking_number = PostHelper::rand_string();
        }
        return parent::beforeValidate();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderCarrier the static model class
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
