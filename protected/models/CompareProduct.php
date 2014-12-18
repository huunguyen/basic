<?php

/**
 * This is the model class for table "tbl_compare_product".
 *
 * The followings are the available columns in table 'tbl_compare_product':
 * @property string $id_compare
 * @property string $id_product
 * @property string $date_add
 * @property string $date_upd
 */
class CompareProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompareProduct the static model class
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
		return 'tbl_compare_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_compare, id_product, date_add, date_upd', 'required'),
			array('id_compare, id_product', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_compare, id_product, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'id_compare' => 'Id Compare',
			'id_product' => 'Id Product',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
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

		$criteria->compare('id_compare',$this->id_compare,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}