<?php

/**
 * This is the model class for table "tbl_order_slip".
 *
 * The followings are the available columns in table 'tbl_order_slip':
 * @property string $id_order_slip
 * @property string $conversion_rate
 * @property string $id_customer
 * @property string $id_order
 * @property integer $shipping_cost
 * @property string $amount
 * @property string $shipping_cost_amount
 * @property integer $partial
 * @property string $date_add
 * @property string $date_upd
 */
class OrderSlip extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderSlip the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_slip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_customer, id_order, amount, shipping_cost_amount, partial, date_add, date_upd', 'required'),
			array('shipping_cost, partial', 'numerical', 'integerOnly'=>true),
			array('conversion_rate', 'length', 'max'=>13),
			array('id_customer, id_order, amount, shipping_cost_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_order_slip, conversion_rate, id_customer, id_order, shipping_cost, amount, shipping_cost_amount, partial, date_add, date_upd', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_order_slip' => 'Id Order Slip',
			'conversion_rate' => 'Conversion Rate',
			'id_customer' => 'Id Customer',
			'id_order' => 'Id Order',
			'shipping_cost' => 'Shipping Cost',
			'amount' => 'Amount',
			'shipping_cost_amount' => 'Shipping Cost Amount',
			'partial' => 'Partial',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_order_slip',$this->id_order_slip,true);
		$criteria->compare('conversion_rate',$this->conversion_rate,true);
		$criteria->compare('id_customer',$this->id_customer,true);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('shipping_cost',$this->shipping_cost);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('shipping_cost_amount',$this->shipping_cost_amount,true);
		$criteria->compare('partial',$this->partial);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}