<?php

/**
 * This is the model class for table "tbl_country".
 *
 * The followings are the available columns in table 'tbl_country':
 * @property string $id_country
 * @property string $id_currency
 * @property string $name
 * @property string $iso_code
 * @property string $call_prefix
 * @property integer $active
 * @property string $date_add
 * @property string $date_upd
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property City[] $cities
 * @property Currency $idCurrency
 */
class Country extends CActiveRecord
{
    const CODE_VIETNAM = 1;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_add', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('id_currency', 'length', 'max'=>10),
			array('name, slug', 'length', 'max'=>45),
			array('iso_code', 'length', 'max'=>3),
			array('call_prefix', 'length', 'max'=>12),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_country, id_currency, name, iso_code, call_prefix, active, date_add, date_upd, slug', 'safe', 'on'=>'search'),
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
			'cities' => array(self::HAS_MANY, 'City', 'id_country'),
			'idCurrency' => array(self::BELONGS_TO, 'Currency', 'id_currency'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_country' => 'Id Country',
			'id_currency' => 'Id Currency',
			'name' => 'Name',
			'iso_code' => 'Iso Code',
			'call_prefix' => 'Call Prefix',
			'active' => 'Active',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
			'slug' => 'Slug',
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

		$criteria->compare('id_country',$this->id_country,true);
		$criteria->compare('id_currency',$this->id_currency,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('iso_code',$this->iso_code,true);
		$criteria->compare('call_prefix',$this->call_prefix,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
