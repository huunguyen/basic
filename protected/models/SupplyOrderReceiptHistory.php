<?php

/**
 * This is the model class for table "tbl_supply_order_receipt_history".
 *
 * The followings are the available columns in table 'tbl_supply_order_receipt_history':
 * @property string $id_supply_order_receipt_history
 * @property string $id_supply_order_detail
 * @property string $id_user
 * @property string $user_lastname
 * @property string $user_firstname
 * @property string $id_supply_order_state
 * @property string $quantity
 * @property string $date_add
 */
class SupplyOrderReceiptHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_supply_order_receipt_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_supply_order_detail, id_user, id_supply_order_state, quantity, date_add', 'required'),
			array('id_supply_order_detail, id_user, id_supply_order_state, quantity', 'length', 'max'=>10),
			array('user_lastname, user_firstname', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_supply_order_receipt_history, id_supply_order_detail, id_user, user_lastname, user_firstname, id_supply_order_state, quantity, date_add', 'safe', 'on'=>'search'),
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
			'id_supply_order_receipt_history' => 'Id Supply Order Receipt History',
			'id_supply_order_detail' => 'Id Supply Order Detail',
			'id_user' => 'Id User',
			'user_lastname' => 'User Lastname',
			'user_firstname' => 'User Firstname',
			'id_supply_order_state' => 'Id Supply Order State',
			'quantity' => 'Quantity',
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

		$criteria->compare('id_supply_order_receipt_history',$this->id_supply_order_receipt_history,true);
		$criteria->compare('id_supply_order_detail',$this->id_supply_order_detail,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('user_lastname',$this->user_lastname,true);
		$criteria->compare('user_firstname',$this->user_firstname,true);
		$criteria->compare('id_supply_order_state',$this->id_supply_order_state,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('date_add',$this->date_add,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SupplyOrderReceiptHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
