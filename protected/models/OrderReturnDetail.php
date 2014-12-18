<?php

/**
 * This is the model class for table "tbl_order_return_detail".
 *
 * The followings are the available columns in table 'tbl_order_return_detail':
 * @property string $id_order_return
 * @property string $id_order_detail
 * @property string $id_customization
 * @property string $product_quantity
 */
class OrderReturnDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderReturnDetail the static model class
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
		return 'tbl_order_return_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order_return, id_order_detail', 'required'),
			array('id_order_return, id_order_detail, id_customization, product_quantity', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_order_return, id_order_detail, id_customization, product_quantity', 'safe', 'on'=>'search'),
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
			'id_order_return' => 'Id Order Return',
			'id_order_detail' => 'Id Order Detail',
			'id_customization' => 'Id Customization',
			'product_quantity' => 'Product Quantity',
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

		$criteria->compare('id_order_return',$this->id_order_return,true);
		$criteria->compare('id_order_detail',$this->id_order_detail,true);
		$criteria->compare('id_customization',$this->id_customization,true);
		$criteria->compare('product_quantity',$this->product_quantity,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}