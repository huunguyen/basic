<?php

/**
 * This is the model class for table "tbl_order_detail_product_supplier".
 *
 * The followings are the available columns in table 'tbl_order_detail_product_supplier':
 * @property string $id_order_detail_product_supplier
 * @property string $id_order_detail
 * @property string $id_product_supplier
 * @property string $quantity
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property OrderDetail $idOrderDetail
 * @property ProductSupplier $idProductSupplier
 */
class OrderDetailProductSupplier extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_detail_product_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order_detail, id_product_supplier, quantity, date_add', 'required'),
			array('id_order_detail, id_product_supplier, quantity', 'length', 'max'=>10),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_order_detail_product_supplier, id_order_detail, id_product_supplier, quantity, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'idOrderDetail' => array(self::BELONGS_TO, 'OrderDetail', 'id_order_detail'),
			'idProductSupplier' => array(self::BELONGS_TO, 'ProductSupplier', 'id_product_supplier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_order_detail_product_supplier' => 'Id Order Detail Product Supplier',
			'id_order_detail' => 'Id Order Detail',
			'id_product_supplier' => 'Id Product Supplier',
			'quantity' => 'Quantity',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
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

		$criteria->compare('id_order_detail_product_supplier',$this->id_order_detail_product_supplier,true);
		$criteria->compare('id_order_detail',$this->id_order_detail,true);
		$criteria->compare('id_product_supplier',$this->id_product_supplier,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderDetailProductSupplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
