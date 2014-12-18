<?php

/**
 * This is the model class for table "tbl_warehouse_product_location".
 *
 * The followings are the available columns in table 'tbl_warehouse_product_location':
 * @property string $id_warehouse_product_location
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_warehouse
 * @property string $location
 *
 * The followings are the available model relations:
 * @property Warehouse $idWarehouse
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 */
class WarehouseProductLocation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_warehouse_product_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_product_attribute, id_warehouse', 'required'),
			array('id_product, id_product_attribute, id_warehouse', 'length', 'max'=>10),
			array('location', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_warehouse_product_location, id_product, id_product_attribute, id_warehouse, location', 'safe', 'on'=>'search'),
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
			'idWarehouse' => array(self::BELONGS_TO, 'Warehouse', 'id_warehouse'),
			'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
			'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_warehouse_product_location' => 'Mã Nơi Chứa Hàng',
			'id_product' => 'Mã Sản Phẩm',
			'id_product_attribute' => 'Mã Thuộc Tính',
			'id_warehouse' => 'Mã Nhà Kho',
			'location' => 'Nơi Chứa Hàng',
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

		$criteria->compare('id_warehouse_product_location',$this->id_warehouse_product_location,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('id_warehouse',$this->id_warehouse,true);
		$criteria->compare('location',$this->location,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarehouseProductLocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
         /**
     * Uses the primary keys set on a new record to either create or update
     * a record with those keys to have the last_access value set to the same value
     * as the current unsaved model.
     *
     * Returns the model with the updated last_access. Success can be checked by
     * examining the isNewRecord property.
     *
     * IMPORTANT: This method does not modify the existing model.
     * */
    public function updateRecord() {
        $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_warehouse' => $this->id_warehouse,'id_product_attribute' => $this->id_product_attribute));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_product = $this->id_product;
            $model->id_warehouse = $this->id_warehouse;
            $model->id_product_attribute = $this->id_product_attribute;
        }
        $model->save(false);
        return $model;
    }
}
