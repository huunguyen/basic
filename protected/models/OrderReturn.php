<?php

/**
 * This is the model class for table "tbl_order_return".
 *
 * The followings are the available columns in table 'tbl_order_return':
 * @property string $id_order_return
 * @property string $id_customer
 * @property string $id_order
 * @property integer $state
 * @property string $question
 * @property string $date_add
 * @property string $date_upd
 */
class OrderReturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderReturn the static model class
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
		return 'tbl_order_return';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_customer, id_order, question, date_add, date_upd', 'required'),
			array('state', 'numerical', 'integerOnly'=>true),
			array('id_customer, id_order', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_order_return, id_customer, id_order, state, question, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'id_order_return' => 'Id Order Return',
			'id_customer' => 'Id Customer',
			'id_order' => 'Id Order',
			'state' => 'State',
			'question' => 'Question',
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

		$criteria->compare('id_order_return',$this->id_order_return,true);
		$criteria->compare('id_customer',$this->id_customer,true);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}