<?php

/**
 * This is the model class for table "tbl_referrer_store".
 *
 * The followings are the available columns in table 'tbl_referrer_store':
 * @property string $id_referrer
 * @property string $id_store
 * @property integer $cache_visitors
 * @property integer $cache_visits
 * @property integer $cache_pages
 * @property integer $cache_registrations
 * @property integer $cache_orders
 * @property string $cache_sales
 * @property string $cache_reg_rate
 * @property string $cache_order_rate
 */
class ReferrerStore extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_referrer_store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cache_visitors, cache_visits, cache_pages, cache_registrations, cache_orders', 'numerical', 'integerOnly'=>true),
			array('id_store', 'length', 'max'=>10),
			array('cache_sales', 'length', 'max'=>17),
			array('cache_reg_rate, cache_order_rate', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_referrer, id_store, cache_visitors, cache_visits, cache_pages, cache_registrations, cache_orders, cache_sales, cache_reg_rate, cache_order_rate', 'safe', 'on'=>'search'),
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
			'id_referrer' => 'Id Referrer',
			'id_store' => 'Id Store',
			'cache_visitors' => 'Cache Visitors',
			'cache_visits' => 'Cache Visits',
			'cache_pages' => 'Cache Pages',
			'cache_registrations' => 'Cache Registrations',
			'cache_orders' => 'Cache Orders',
			'cache_sales' => 'Cache Sales',
			'cache_reg_rate' => 'Cache Reg Rate',
			'cache_order_rate' => 'Cache Order Rate',
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
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('cache_visitors',$this->cache_visitors);
		$criteria->compare('cache_visits',$this->cache_visits);
		$criteria->compare('cache_pages',$this->cache_pages);
		$criteria->compare('cache_registrations',$this->cache_registrations);
		$criteria->compare('cache_orders',$this->cache_orders);
		$criteria->compare('cache_sales',$this->cache_sales,true);
		$criteria->compare('cache_reg_rate',$this->cache_reg_rate,true);
		$criteria->compare('cache_order_rate',$this->cache_order_rate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReferrerStore the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
