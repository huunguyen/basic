<?php

/**
 * This is the model class for table "tbl_order_detail_tax".
 *
 * The followings are the available columns in table 'tbl_order_detail_tax':
 * @property string $id_order_detail
 * @property string $id_tax
 * @property string $unit_amount
 * @property string $total_amount
 */
class OrderDetailTax extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderDetailTax the static model class
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
		return 'tbl_order_detail_tax';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order_detail, id_tax', 'required'),
			array('id_order_detail, id_tax, unit_amount, total_amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_order_detail, id_tax, unit_amount, total_amount', 'safe', 'on'=>'search'),
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
			'id_order_detail' => 'Id Order Detail',
			'id_tax' => 'Id Tax',
			'unit_amount' => 'Unit Amount',
			'total_amount' => 'Total Amount',
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

		$criteria->compare('id_order_detail',$this->id_order_detail,true);
		$criteria->compare('id_tax',$this->id_tax,true);
		$criteria->compare('unit_amount',$this->unit_amount,true);
		$criteria->compare('total_amount',$this->total_amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}