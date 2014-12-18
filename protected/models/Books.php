<?php

/**
 * This is the model class for table "tbl_books".
 *
 * The followings are the available columns in table 'tbl_books':
 * @property string $id_books
 * @property string $id_manager
 * @property string $id_custommer
 * @property string $id_user_update
 * @property string $id_store
 * @property string $date_add
 * @property string $date_upd
 * @property string $description
 * @property string $categories
 * @property string $status
 * @property string $cause_effect
 * @property string $paymentkey
 * @property string $shoppingcartkey
 * @property string $totalofmoney
 * @property string $salt
 * @property string $date_start_payment
 * @property string $date_end_payment
 */
class Books extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Books the static model class
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
		return 'tbl_books';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_manager, id_custommer, id_user_update, id_store', 'required'),
			array('id_manager, id_custommer, id_user_update, id_store', 'length', 'max'=>10),
			array('categories', 'length', 'max'=>6),
			array('status', 'length', 'max'=>18),
			array('paymentkey, shoppingcartkey', 'length', 'max'=>256),
			array('totalofmoney', 'length', 'max'=>128),
			array('salt', 'length', 'max'=>255),
			array('date_add, date_upd, description, cause_effect, date_start_payment, date_end_payment', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_books, id_manager, id_custommer, id_user_update, id_store, date_add, date_upd, description, categories, status, cause_effect, paymentkey, shoppingcartkey, totalofmoney, salt, date_start_payment, date_end_payment', 'safe', 'on'=>'search'),
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
			'id_books' => 'Id Books',
			'id_manager' => 'Id Manager',
			'id_custommer' => 'Id Custommer',
			'id_user_update' => 'Id User Update',
			'id_store' => 'Id Store',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
			'description' => 'Description',
			'categories' => 'Categories',
			'status' => 'Status',
			'cause_effect' => 'Cause Effect',
			'paymentkey' => 'Paymentkey',
			'shoppingcartkey' => 'Shoppingcartkey',
			'totalofmoney' => 'Totalofmoney',
			'salt' => 'Salt',
			'date_start_payment' => 'Date Start Payment',
			'date_end_payment' => 'Date End Payment',
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

		$criteria->compare('id_books',$this->id_books,true);
		$criteria->compare('id_manager',$this->id_manager,true);
		$criteria->compare('id_custommer',$this->id_custommer,true);
		$criteria->compare('id_user_update',$this->id_user_update,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('categories',$this->categories,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('cause_effect',$this->cause_effect,true);
		$criteria->compare('paymentkey',$this->paymentkey,true);
		$criteria->compare('shoppingcartkey',$this->shoppingcartkey,true);
		$criteria->compare('totalofmoney',$this->totalofmoney,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('date_start_payment',$this->date_start_payment,true);
		$criteria->compare('date_end_payment',$this->date_end_payment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}