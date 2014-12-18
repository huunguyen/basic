<?php

/**
 * This is the model class for table "tbl_cart_rule".
 *
 * The followings are the available columns in table 'tbl_cart_rule':
 * @property string $id_cart_rule
 * @property string $id_pack
 * @property string $id_customer
 * @property string $name
 * @property string $reduction_percent
 * @property string $reduction_amount
 * @property integer $active
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Cart[] $tblCarts
 * @property Customer $idCustomer
 * @property Pack $idPack
 * @property Carrier[] $tblCarriers
 * @property CartRuleCombination[] $cartRuleCombinations
 * @property CartRuleCombination[] $cartRuleCombinations1
 * @property Group[] $tblGroups
 * @property CartRuleProductRuleGroup[] $cartRuleProductRuleGroups
 * @property OrderCartRule[] $orderCartRules
 * @property SpecificPrice[] $specificPrices
 */
class CartRule extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_cart_rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pack, date_add, date_upd', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('id_pack, id_customer', 'length', 'max'=>10),
			array('name', 'length', 'max'=>45),
			array('reduction_percent', 'length', 'max'=>5),
			array('reduction_amount', 'length', 'max'=>17),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_cart_rule, id_pack, id_customer, name, reduction_percent, reduction_amount, active, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'tblCarts' => array(self::MANY_MANY, 'Cart', 'tbl_cart_cart_rule(id_cart_rule, id_cart)'),
			'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
			'idPack' => array(self::BELONGS_TO, 'Pack', 'id_pack'),
			'tblCarriers' => array(self::MANY_MANY, 'Carrier', 'tbl_cart_rule_carrier(id_cart_rule, id_carrier)'),
			'cartRuleCombinations' => array(self::HAS_MANY, 'CartRuleCombination', 'id_cart_rule_2'),
			'cartRuleCombinations1' => array(self::HAS_MANY, 'CartRuleCombination', 'id_cart_rule_1'),
			'tblGroups' => array(self::MANY_MANY, 'Group', 'tbl_cart_rule_group(id_cart_rule, id_group)'),
			'cartRuleProductRuleGroups' => array(self::HAS_MANY, 'CartRuleProductRuleGroup', 'id_cart_rule'),
			'orderCartRules' => array(self::HAS_MANY, 'OrderCartRule', 'id_cart_rule'),
			'specificPrices' => array(self::HAS_MANY, 'SpecificPrice', 'id_cart_rule'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_cart_rule' => 'Id Cart Rule',
			'id_pack' => 'Id Pack',
			'id_customer' => 'Id Customer',
			'name' => 'Name',
			'reduction_percent' => 'Reduction Percent',
			'reduction_amount' => 'Reduction Amount',
			'active' => 'Active',
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

		$criteria->compare('id_cart_rule',$this->id_cart_rule,true);
		$criteria->compare('id_pack',$this->id_pack,true);
		$criteria->compare('id_customer',$this->id_customer,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('reduction_percent',$this->reduction_percent,true);
		$criteria->compare('reduction_amount',$this->reduction_amount,true);
		$criteria->compare('active',$this->active);
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
	 * @return CartRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
