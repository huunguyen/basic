<?php

/**
 * This is the model class for table "tbl_order_state".
 *
 * The followings are the available columns in table 'tbl_order_state':
 * @property string $id_order_state
 * @property integer $invoice
 * @property integer $send_email
 * @property integer $unremovable
 * @property integer $hidden
 * @property integer $logable
 * @property integer $delivery
 * @property integer $shipped
 * @property integer $paid
 * @property integer $deleted
 * @property string $name
 * @property string $template
 *
 * The followings are the available model relations:
 * @property OrderHistory[] $orderHistories
 * @property Orders[] $orders
 */
class OrderState extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_state';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('unremovable', 'required'),
			array('invoice, send_email, unremovable, hidden, logable, delivery, shipped, paid, deleted', 'numerical', 'integerOnly'=>true),
			array('name, template', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_order_state, invoice, send_email, unremovable, hidden, logable, delivery, shipped, paid, deleted, name, template', 'safe', 'on'=>'search'),
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
			'orderHistories' => array(self::HAS_MANY, 'OrderHistory', 'id_order_state'),
			'orders' => array(self::HAS_MANY, 'Orders', 'current_state'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_order_state' => 'Id Order State',
			'invoice' => 'Invoice',
			'send_email' => 'Send Email',
			'unremovable' => 'Unremovable',
			'hidden' => 'Hidden',
			'logable' => 'Logable',
			'delivery' => 'Delivery',
			'shipped' => 'Shipped',
			'paid' => 'Paid',
			'deleted' => 'Deleted',
			'name' => 'Name',
			'template' => 'Template',
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

		$criteria->compare('id_order_state',$this->id_order_state,true);
		$criteria->compare('invoice',$this->invoice);
		$criteria->compare('send_email',$this->send_email);
		$criteria->compare('unremovable',$this->unremovable);
		$criteria->compare('hidden',$this->hidden);
		$criteria->compare('logable',$this->logable);
		$criteria->compare('delivery',$this->delivery);
		$criteria->compare('shipped',$this->shipped);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('template',$this->template,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderState the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
