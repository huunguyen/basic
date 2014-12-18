<?php

/**
 * This is the model class for table "tbl_currency".
 *
 * The followings are the available columns in table 'tbl_currency':
 * @property string $id_currency
 * @property string $name
 * @property string $iso_code
 * @property string $iso_code_num
 * @property string $sign
 * @property integer $deleted
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Country[] $countries
 */
class Currency extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_currency';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sign', 'required'),
			array('deleted, active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('iso_code, iso_code_num', 'length', 'max'=>3),
			array('sign', 'length', 'max'=>8),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_currency, name, iso_code, iso_code_num, sign, deleted, active', 'safe', 'on'=>'search'),
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
			'countries' => array(self::HAS_MANY, 'Country', 'id_currency'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_currency' => 'Id Currency',
			'name' => 'Name',
			'iso_code' => 'Iso Code',
			'iso_code_num' => 'Iso Code Num',
			'sign' => 'Sign',
			'deleted' => 'Deleted',
			'active' => 'Active',
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

		$criteria->compare('id_currency',$this->id_currency,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('iso_code',$this->iso_code,true);
		$criteria->compare('iso_code_num',$this->iso_code_num,true);
		$criteria->compare('sign',$this->sign,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currency the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
