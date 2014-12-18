<?php

/**
 * This is the model class for table "tbl_product_supplier".
 *
 * The followings are the available columns in table 'tbl_product_supplier':
 * @property string $id_product_supplier
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_supplier
 * @property string $product_supplier_reference
 * @property string $product_supplier_price_te
 *
 * The followings are the available model relations:
 * @property OrderDetailProductSupplier[] $orderDetailProductSuppliers
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 * @property Supplier $idSupplier
 */
class ProductSupplier extends CActiveRecord
{
    public $count_id_product_attribute;
    public $sum_quantity;
    public $max_id_product_attribute;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_product_supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_supplier', 'required'),
			array('id_product, id_product_attribute, id_supplier', 'length', 'max'=>10),
			array('product_supplier_reference', 'length', 'max'=>32),
			array('product_supplier_price_te', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('count_id_product_attribute, sum_quantity, max_id_product_attribute, id_product_supplier, id_product, id_product_attribute, id_supplier, product_supplier_reference, product_supplier_price_te', 'safe', 'on'=>'search'),
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
			'orderDetailProductSuppliers' => array(self::HAS_MANY, 'OrderDetailProductSupplier', 'id_product_supplier'),
			'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
			'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
			'idSupplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product_supplier' => 'Id Product Supplier',
			'id_product' => 'Mã sản phẩm',
			'id_product_attribute' => 'Mã chủng loại sản phẩm',
			'id_supplier' => 'Mã nhà cung cấp',
			'product_supplier_reference' => 'Chứng từ Sản phẩm [Nhà cung cấp]',
			'product_supplier_price_te' => 'Giá theo Nhà cung cấp',
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

		$criteria->compare('id_product_supplier',$this->id_product_supplier,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('id_supplier',$this->id_supplier,true);
		$criteria->compare('product_supplier_reference',$this->product_supplier_reference,true);
		$criteria->compare('product_supplier_price_te',$this->product_supplier_price_te,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSupplier the static model class
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
        $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_supplier' => $this->id_supplier,'id_product_attribute' => $this->id_product_attribute));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_product = $this->id_product;
            $model->id_supplier = $this->id_supplier;
            $model->id_product_attribute = $this->id_product_attribute;
        }
        $model->product_supplier_price_te = $this->product_supplier_price_te;
        $model->product_supplier_reference = $this->product_supplier_reference;
        $model->save(false);
        return $model;
    }
}
