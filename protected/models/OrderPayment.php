<?php

/**
 * This is the model class for table "tbl_order_payment".
 *
 * The followings are the available columns in table 'tbl_order_payment':
 * @property string $id_order_payment
 * @property string $order_reference
 * @property string $amount
 * @property string $payment_method
 * @property string $conversion_rate
 * @property string $transaction_id
 * @property string $card_number
 * @property string $card_brand
 * @property string $card_expiration
 * @property string $card_holder
 * @property string $date_add
 *
 * The followings are the available model relations:
 * @property OrderInvoice[] $tblOrderInvoices
 */
class OrderPayment extends CActiveRecord
{
    public $cc;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order_payment, amount, payment_method, date_add', 'required'),
			array('id_order_payment, amount', 'length', 'max'=>10),
			array('order_reference', 'length', 'max'=>9),
			array('payment_method', 'length', 'max'=>255),
			array('conversion_rate', 'length', 'max'=>13),
			array('transaction_id, card_number, card_brand, card_holder', 'length', 'max'=>254),
			array('card_expiration', 'length', 'max'=>7),
                        array('cc','common.extensions.behaviors.ECCValidator',
                                'format'=>ECCValidator::MASTERCARD),
        // You can also check multiple type of cards
        // 'format'=>array(ECCValidator::MASTERCARD, ECCValidator::VISA)),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cc, id_order_payment, order_reference, amount, payment_method, conversion_rate, transaction_id, card_number, card_brand, card_expiration, card_holder, date_add', 'safe', 'on'=>'search'),
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
			'tblOrderInvoices' => array(self::MANY_MANY, 'OrderInvoice', 'tbl_order_invoice_payment(id_order_payment, id_order_invoice)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_order_payment' => 'Id Order Payment',
			'order_reference' => 'Order Reference',
			'amount' => 'Amount',
			'payment_method' => 'Payment Method',
			'conversion_rate' => 'Conversion Rate',
			'transaction_id' => 'Transaction',
			'card_number' => 'Card Number',
			'card_brand' => 'Card Brand',
			'card_expiration' => 'Card Expiration',
			'card_holder' => 'Card Holder',
			'date_add' => 'Date Add',
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

		$criteria->compare('id_order_payment',$this->id_order_payment,true);
		$criteria->compare('order_reference',$this->order_reference,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('payment_method',$this->payment_method,true);
		$criteria->compare('conversion_rate',$this->conversion_rate,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('card_number',$this->card_number,true);
		$criteria->compare('card_brand',$this->card_brand,true);
		$criteria->compare('card_expiration',$this->card_expiration,true);
		$criteria->compare('card_holder',$this->card_holder,true);
		$criteria->compare('date_add',$this->date_add,true);

		$sort = new CSort;
                $sort->defaultOrder = 'payment_method, date_add ASC';
                $sort->attributes = array(
                    'payment_method' => 'payment_method',
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
