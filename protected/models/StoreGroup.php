<?php

/**
 * This is the model class for table "tbl_store_group".
 *
 * The followings are the available columns in table 'tbl_store_group':
 * @property string $id_store_group
 * @property string $name
 * @property integer $share_customer
 * @property integer $share_order
 * @property integer $share_stock
 * @property integer $active
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Configuration[] $configurations
 * @property Store[] $stores
 */
class StoreGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_store_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, share_customer, share_order, share_stock', 'required'),
			array('share_customer, share_order, share_stock, active, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_store_group, name, share_customer, share_order, share_stock, active, deleted', 'safe', 'on'=>'search'),
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
			'configurations' => array(self::HAS_MANY, 'Configuration', 'id_store_group'),
			'stores' => array(self::HAS_MANY, 'Store', 'id_store_group'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_store_group' => 'Mã nhóm',
			'name' => 'Tên nhóm cấu hình',
			'share_customer' => 'Chia sẽ khách hàng',
			'share_order' => 'Chia sẽ đơn hàng',
			'share_stock' => 'Chia sẽ hàng trong kho',
			'active' => 'Trạng thái',
			'deleted' => 'Được xóa',
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

		$criteria->compare('id_store_group',$this->id_store_group,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('share_customer',$this->share_customer);
		$criteria->compare('share_order',$this->share_order);
		$criteria->compare('share_stock',$this->share_stock);
		$criteria->compare('active',$this->active);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StoreGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
