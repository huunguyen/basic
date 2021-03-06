<?php

/**
 * This is the model class for table "tbl_cart_rule_carrier".
 *
 * The followings are the available columns in table 'tbl_cart_rule_carrier':
 * @property string $id_cart_rule
 * @property string $id_carrier
 */
class CartRuleCarrier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CartRuleCarrier the static model class
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
		return 'tbl_cart_rule_carrier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cart_rule, id_carrier', 'required'),
			array('id_cart_rule, id_carrier', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_cart_rule, id_carrier', 'safe', 'on'=>'search'),
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
			'id_cart_rule' => 'Id Cart Rule',
			'id_carrier' => 'Id Carrier',
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

		$criteria->compare('id_cart_rule',$this->id_cart_rule,true);
		$criteria->compare('id_carrier',$this->id_carrier,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}