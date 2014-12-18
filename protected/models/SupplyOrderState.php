<?php

/**
 * This is the model class for table "tbl_supply_order_state".
 *
 * The followings are the available columns in table 'tbl_supply_order_state':
 * @property string $id_supply_order_state
 * @property integer $editable
 * @property integer $receipt_state
 * @property integer $pending_receipt
 * @property integer $enclosed
 * @property string $color
 * @property string $name
 *
 * The followings are the available model relations:
 * @property SupplyOrder[] $supplyOrders
 * @property SupplyOrderHistory[] $supplyOrderHistories
 * @property SupplyOrderReceiptHistory[] $supplyOrderReceiptHistories
 */
class SupplyOrderState extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_supply_order_state';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('editable, receipt_state, pending_receipt, enclosed', 'numerical', 'integerOnly'=>true),
			array('color', 'length', 'max'=>32),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_supply_order_state, editable, receipt_state, pending_receipt, enclosed, color, name', 'safe', 'on'=>'search'),
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
			'supplyOrders' => array(self::HAS_MANY, 'SupplyOrder', 'id_supply_order_state'),
			'supplyOrderHistories' => array(self::HAS_MANY, 'SupplyOrderHistory', 'id_supply_order_state'),
			'supplyOrderReceiptHistories' => array(self::HAS_MANY, 'SupplyOrderReceiptHistory', 'id_supply_order_state'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_supply_order_state' => 'Mã trạng thái',			
			'editable' => 'Cho phép thay đổi',
			'receipt_state' => 'Trạng thái nhận',
			'pending_receipt' => 'Trạng thái chờ tiếp nhận',
			'enclosed' => 'Đóng gói',
			'color' => 'Màu sắc',
			'name' => 'Tên trạng thái',
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

		$criteria->compare('id_supply_order_state',$this->id_supply_order_state,true);
		$criteria->compare('editable',$this->editable);
		$criteria->compare('receipt_state',$this->receipt_state);
		$criteria->compare('pending_receipt',$this->pending_receipt);
		$criteria->compare('enclosed',$this->enclosed);
		$criteria->compare('color',$this->color,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SupplyOrderState the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
