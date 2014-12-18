<?php

/**
 * This is the model class for table "tbl_attribute_impact".
 *
 * The followings are the available columns in table 'tbl_attribute_impact':
 * @property string $id_attribute_impact
 * @property string $id_product
 * @property string $id_attribute
 * @property double $weight
 * @property string $price
 */
class AttributeImpact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AttributeImpact the static model class
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
		return 'tbl_attribute_impact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_attribute, weight, price', 'required'),
			array('weight', 'numerical'),
			array('id_product, id_attribute', 'length', 'max'=>10),
			array('price', 'length', 'max'=>17),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_attribute_impact, id_product, id_attribute, weight, price', 'safe', 'on'=>'search'),
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
			'id_attribute_impact' => 'Id Attribute Impact',
			'id_product' => 'Id Product',
			'id_attribute' => 'Id Attribute',
			'weight' => 'Weight',
			'price' => 'Price',
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

		$criteria->compare('id_attribute_impact',$this->id_attribute_impact,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_attribute',$this->id_attribute,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}