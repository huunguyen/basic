<?php

/**
 * This is the model class for table "tbl_product_advise".
 *
 * The followings are the available columns in table 'tbl_product_advise':
 * @property string $id_product_advise
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_advise
 * @property string $id_advise_value
 * @property string $id_customer
 * @property string $state
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Advise $idAdvise
 * @property Product $idProduct
 * @property AdviseValue $idAdviseValue
 * @property ProductAttribute $idProductAttribute
 * @property Customer $idCustomer
 */
class ProductAdvise extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_product_advise';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_advise, id_advise_value, date_add', 'required'),
			array('id_product, id_product_attribute, id_advise, id_advise_value, id_customer', 'length', 'max'=>10),
			array('state', 'length', 'max'=>7),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product_advise, id_product, id_product_attribute, id_advise, id_advise_value, id_customer, state, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'idAdvise' => array(self::BELONGS_TO, 'Advise', 'id_advise'),
			'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
			'idAdviseValue' => array(self::BELONGS_TO, 'AdviseValue', 'id_advise_value'),
			'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
			'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product_advise' => 'Id Product Advise',
			'id_product' => 'Id Product',
			'id_product_attribute' => 'Id Product Attribute',
			'id_advise' => 'Id Advise',
			'id_advise_value' => 'Id Advise Value',
			'id_customer' => 'Id Customer',
			'state' => 'State',
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

		$criteria->compare('id_product_advise',$this->id_product_advise,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('id_advise',$this->id_advise,true);
		$criteria->compare('id_advise_value',$this->id_advise_value,true);
		$criteria->compare('id_customer',$this->id_customer,true);
		$criteria->compare('state',$this->state,true);
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
	 * @return ProductAdvise the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
