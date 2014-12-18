<?php

/**
 * This is the model class for table "tbl_stock_mvt".
 *
 * The followings are the available columns in table 'tbl_stock_mvt':
 * @property string $id_stock_mvt
 * @property string $id_stock
 * @property string $id_order
 * @property string $id_supply_order
 * @property string $id_stock_mvt_reason
 * @property string $id_user
 * @property string $user_lastname
 * @property string $user_firstname
 * @property string $physical_quantity
 * @property string $date_add
 * @property integer $sign
 * @property string $price_te
 * @property string $last_wa
 * @property string $current_wa
 * @property string $referer
 *
 * The followings are the available model relations:
 * @property Stock $idStock
 * @property Orders $idOrder
 * @property SupplyOrder $idSupplyOrder
 * @property StockMvtReason $idStockMvtReason
 * @property User $idUser
 */
class StockMvt extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_stock_mvt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_stock, id_stock_mvt_reason, id_user, physical_quantity, date_add', 'required'),
			array('sign', 'numerical', 'integerOnly'=>true),
			array('id_stock, id_order, id_supply_order, id_stock_mvt_reason, id_user, physical_quantity', 'length', 'max'=>10),
			array('user_lastname, user_firstname', 'length', 'max'=>32),
			array('price_te, last_wa, current_wa, referer', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_stock_mvt, id_stock, id_order, id_supply_order, id_stock_mvt_reason, id_user, user_lastname, user_firstname, physical_quantity, date_add, sign, price_te, last_wa, current_wa, referer', 'safe', 'on'=>'search'),
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
			'idStock' => array(self::BELONGS_TO, 'Stock', 'id_stock'),
			'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
			'idSupplyOrder' => array(self::BELONGS_TO, 'SupplyOrder', 'id_supply_order'),
			'idStockMvtReason' => array(self::BELONGS_TO, 'StockMvtReason', 'id_stock_mvt_reason'),
			'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_stock_mvt' => 'Id Stock Mvt',
			'id_stock' => 'Id Stock',
			'id_order' => 'Id Order',
			'id_supply_order' => 'Id Supply Order',
			'id_stock_mvt_reason' => 'Id Stock Mvt Reason',
			'id_user' => 'Id User',
			'user_lastname' => 'User Lastname',
			'user_firstname' => 'User Firstname',
			'physical_quantity' => 'Physical Quantity',
			'date_add' => 'Date Add',
			'sign' => 'Sign',
			'price_te' => 'Price Te',
			'last_wa' => 'Last Wa',
			'current_wa' => 'Current Wa',
			'referer' => 'Referer',
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

		$criteria->compare('id_stock_mvt',$this->id_stock_mvt,true);
		$criteria->compare('id_stock',$this->id_stock,true);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('id_supply_order',$this->id_supply_order,true);
		$criteria->compare('id_stock_mvt_reason',$this->id_stock_mvt_reason,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('user_lastname',$this->user_lastname,true);
		$criteria->compare('user_firstname',$this->user_firstname,true);
		$criteria->compare('physical_quantity',$this->physical_quantity,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('sign',$this->sign);
		$criteria->compare('price_te',$this->price_te,true);
		$criteria->compare('last_wa',$this->last_wa,true);
		$criteria->compare('current_wa',$this->current_wa,true);
		$criteria->compare('referer',$this->referer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StockMvt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
