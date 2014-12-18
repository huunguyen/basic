<?php

/**
 * This is the model class for table "tbl_referrer".
 *
 * The followings are the available columns in table 'tbl_referrer':
 * @property string $id_referrer
 * @property string $name
 * @property string $passwd
 * @property string $http_referer_regexp
 * @property string $http_referer_like
 * @property string $request_uri_regexp
 * @property string $request_uri_like
 * @property string $http_referer_regexp_not
 * @property string $http_referer_like_not
 * @property string $request_uri_regexp_not
 * @property string $request_uri_like_not
 * @property string $base_fee
 * @property string $percent_fee
 * @property string $click_fee
 * @property string $date_add
 *
 * The followings are the available model relations:
 * @property PageViewed[] $pageVieweds
 * @property Store[] $tblStores
 */
class Referrer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referrer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date_add', 'required'),
			array('name, http_referer_regexp, http_referer_like, request_uri_regexp, request_uri_like, http_referer_regexp_not, http_referer_like_not, request_uri_regexp_not, request_uri_like_not', 'length', 'max'=>64),
			array('passwd', 'length', 'max'=>32),
			array('base_fee, percent_fee, click_fee', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_referrer, name, passwd, http_referer_regexp, http_referer_like, request_uri_regexp, request_uri_like, http_referer_regexp_not, http_referer_like_not, request_uri_regexp_not, request_uri_like_not, base_fee, percent_fee, click_fee, date_add', 'safe', 'on'=>'search'),
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
			'pageVieweds' => array(self::HAS_MANY, 'PageViewed', 'id_referrer'),
			'tblStores' => array(self::MANY_MANY, 'Store', 'tbl_referrer_store(id_referrer, id_store)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_referrer' => 'Id Referrer',
			'name' => 'Name',
			'passwd' => 'Passwd',
			'http_referer_regexp' => 'Http Referer Regexp',
			'http_referer_like' => 'Http Referer Like',
			'request_uri_regexp' => 'Request Uri Regexp',
			'request_uri_like' => 'Request Uri Like',
			'http_referer_regexp_not' => 'Http Referer Regexp Not',
			'http_referer_like_not' => 'Http Referer Like Not',
			'request_uri_regexp_not' => 'Request Uri Regexp Not',
			'request_uri_like_not' => 'Request Uri Like Not',
			'base_fee' => 'Base Fee',
			'percent_fee' => 'Percent Fee',
			'click_fee' => 'Click Fee',
			'date_add' => 'Date Add',
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

		$criteria->compare('id_referrer',$this->id_referrer,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('http_referer_regexp',$this->http_referer_regexp,true);
		$criteria->compare('http_referer_like',$this->http_referer_like,true);
		$criteria->compare('request_uri_regexp',$this->request_uri_regexp,true);
		$criteria->compare('request_uri_like',$this->request_uri_like,true);
		$criteria->compare('http_referer_regexp_not',$this->http_referer_regexp_not,true);
		$criteria->compare('http_referer_like_not',$this->http_referer_like_not,true);
		$criteria->compare('request_uri_regexp_not',$this->request_uri_regexp_not,true);
		$criteria->compare('request_uri_like_not',$this->request_uri_like_not,true);
		$criteria->compare('base_fee',$this->base_fee,true);
		$criteria->compare('percent_fee',$this->percent_fee,true);
		$criteria->compare('click_fee',$this->click_fee,true);
		$criteria->compare('date_add',$this->date_add,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Referrer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
