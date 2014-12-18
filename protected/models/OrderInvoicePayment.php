<?php

/**
 * This is the model class for table "tbl_order_invoice_payment".
 *
 * The followings are the available columns in table 'tbl_order_invoice_payment':
 * @property string $id_order_invoice
 * @property string $id_order_payment
 * @property string $id_order
 */
class OrderInvoicePayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_invoice_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order_invoice, id_order_payment, id_order', 'required'),
			array('id_order_invoice, id_order_payment, id_order', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_order_invoice, id_order_payment, id_order', 'safe', 'on'=>'search'),
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
			'id_order_invoice' => 'Id Order Invoice',
			'id_order_payment' => 'Id Order Payment',
			'id_order' => 'Id Order',
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

		$criteria->compare('id_order_invoice',$this->id_order_invoice,true);
		$criteria->compare('id_order_payment',$this->id_order_payment,true);
		$criteria->compare('id_order',$this->id_order,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderInvoicePayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
