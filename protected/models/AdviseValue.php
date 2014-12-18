<?php

/**
 * This is the model class for table "tbl_advise_value".
 *
 * The followings are the available columns in table 'tbl_advise_value':
 * @property integer $id_advise_value
 * @property string $id_advise
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $state
 * @property string $module
 *
 * The followings are the available model relations:
 * @property Advise $idAdvise
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 * @property ProductAdvise[] $productAdvises
 */
class AdviseValue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_advise_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_advise, id_product', 'required'),
			array('id_advise, id_product, id_product_attribute', 'length', 'max'=>10),
			array('state', 'length', 'max'=>11),
			array('module', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_advise_value, id_advise, id_product, id_product_attribute, state, module', 'safe', 'on'=>'search'),
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
			'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
			'productAdvises' => array(self::HAS_MANY, 'ProductAdvise', 'id_advise_value'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_advise_value' => 'Id Advise Value',
			'id_advise' => 'Id Advise',
			'id_product' => 'Id Product',
			'id_product_attribute' => 'Id Product Attribute',
			'state' => 'State',
			'module' => 'Module',
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

		$criteria->compare('id_advise_value',$this->id_advise_value);
		$criteria->compare('id_advise',$this->id_advise,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('module',$this->module,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdviseValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
