<?php

/**
 * This is the model class for table "tbl_order_cart_rule".
 *
 * The followings are the available columns in table 'tbl_order_cart_rule':
 * @property string $id_order_cart_rule
 * @property string $id_order
 * @property string $id_cart_rule
 * @property string $id_order_invoice
 * @property string $name
 * @property string $value
 * @property string $value_tax_excl
 */
class OrderCartRule extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderCartRule the static model class
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
		return 'tbl_order_cart_rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order, id_cart_rule, name', 'required'),
			array('id_order, id_cart_rule, id_order_invoice', 'length', 'max'=>10),
			array('name', 'length', 'max'=>32),
			array('value, value_tax_excl', 'length', 'max'=>17),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_order_cart_rule, id_order, id_cart_rule, id_order_invoice, name, value, value_tax_excl', 'safe', 'on'=>'search'),
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
			'id_order_cart_rule' => 'Id Order Cart Rule',
			'id_order' => 'Id Order',
			'id_cart_rule' => 'Id Cart Rule',
			'id_order_invoice' => 'Id Order Invoice',
			'name' => 'Name',
			'value' => 'Value',
			'value_tax_excl' => 'Value Tax Excl',
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

		$criteria->compare('id_order_cart_rule',$this->id_order_cart_rule,true);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('id_cart_rule',$this->id_cart_rule,true);
		$criteria->compare('id_order_invoice',$this->id_order_invoice,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('value_tax_excl',$this->value_tax_excl,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}