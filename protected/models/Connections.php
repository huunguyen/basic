<?php

/**
 * This is the model class for table "tbl_connections".
 *
 * The followings are the available columns in table 'tbl_connections':
 * @property string $id_connections
 * @property string $id_store
 * @property string $id_guest
 * @property string $id_page
 * @property string $ip_address
 * @property string $date_add
 * @property string $http_referer
 */
class Connections extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Connections the static model class
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
		return 'tbl_connections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_guest, id_page, date_add', 'required'),
			array('id_store, id_guest, id_page', 'length', 'max'=>10),
			array('ip_address', 'length', 'max'=>20),
			array('http_referer', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_connections, id_store, id_guest, id_page, ip_address, date_add, http_referer', 'safe', 'on'=>'search'),
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
			'id_connections' => 'Id Connections',
			'id_store' => 'Id Store',
			'id_guest' => 'Id Guest',
			'id_page' => 'Id Page',
			'ip_address' => 'Ip Address',
			'date_add' => 'Date Add',
			'http_referer' => 'Http Referer',
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

		$criteria->compare('id_connections',$this->id_connections,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('id_guest',$this->id_guest,true);
		$criteria->compare('id_page',$this->id_page,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('http_referer',$this->http_referer,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}