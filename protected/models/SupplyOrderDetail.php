<?php

/**
 * This is the model class for table "tbl_supply_order_detail".
 *
 * The followings are the available columns in table 'tbl_supply_order_detail':
 * @property string $id_supply_order_detail
 * @property string $id_supply_order
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $reference
 * @property string $supplier_reference
 * @property string $name
 * @property string $unit_price_ratio_te
 * @property string $price_te
 * @property string $price_ti
 * @property string $wholesale_price_te
 * @property string $quantity_expected
 * @property string $quantity_received
 *
 * The followings are the available model relations:
 * @property ProductAttribute $idProductAttribute
 * @property SupplyOrder $idSupplyOrder
 * @property Product $idProduct
 * @property SupplyOrderReceiptHistory[] $supplyOrderReceiptHistories
 */
class SupplyOrderDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_supply_order_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('reference, name, price_te, unit_price_ratio_te, wholesale_price_te, quantity_expected', 'required', 'on' => 'update'),
            array('id_supply_order, id_product, id_product_attribute, quantity_expected, quantity_received', 'length', 'max' => 10),
            array('reference, supplier_reference', 'length', 'max' => 32),
            array('name', 'length', 'max' => 128),
            array('unit_price_ratio_te, price_te, price_ti, wholesale_price_te', 'length', 'max' => 20),
            array('reference, supplier_reference', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_supply_order_detail, id_supply_order, id_product, id_product_attribute, reference, supplier_reference, name, unit_price_ratio_te, price_te, price_ti, wholesale_price_te, quantity_expected, quantity_received', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
            'idSupplyOrder' => array(self::BELONGS_TO, 'SupplyOrder', 'id_supply_order'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'supplyOrderReceiptHistories' => array(self::HAS_MANY, 'SupplyOrderReceiptHistory', 'id_supply_order_detail'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_supply_order_detail' => 'Id Supply Order Detail',
            'id_supply_order' => 'Mã đơn hàng',
            'id_product' => 'Mã sản phẩm',
            'id_product_attribute' => 'Mã phân loại',
            'reference' => 'Tham khảo [Chứng Từ]',
            'supplier_reference' => 'Chứng Từ [Nhà Cung Cấp]',
            'name' => 'Tên',
            'unit_price_ratio_te' => 'Giá một đơn vị [Chưa Thuế]',
            'price_te' => 'Tổng Giá [Chưa Thuế]',
            'price_ti' => 'Tổng Giá [Có Thuế]',
            'wholesale_price_te' => 'Giá Toàn Bộ [Chưa Thuế]',
            'quantity_expected' => 'Số Lượng Đặt Hàng',
            'quantity_received' => 'Số Lượng Nhận Được',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supply_order_detail', $this->id_supply_order_detail, true);
        $criteria->compare('id_supply_order', $this->id_supply_order, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('supplier_reference', $this->supplier_reference, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('unit_price_ratio_te', $this->unit_price_ratio_te, true);
        $criteria->compare('price_te', $this->price_te, true);
        $criteria->compare('price_ti', $this->price_ti, true);
        $criteria->compare('wholesale_price_te', $this->wholesale_price_te, true);
        $criteria->compare('quantity_expected', $this->quantity_expected, true);
        $criteria->compare('quantity_received', $this->quantity_received, true);

        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supply_order, id_product ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supply_order' => 'id_supply_order',
            'id_product' => 'id_product'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByOrder($id_supply_order) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supply_order_detail', $this->id_supply_order_detail, true);
        $criteria->compare('id_supply_order', $id_supply_order);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('supplier_reference', $this->supplier_reference, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('unit_price_ratio_te', $this->unit_price_ratio_te, true);
        $criteria->compare('price_te', $this->price_te, true);
        $criteria->compare('price_ti', $this->price_ti, true);
        $criteria->compare('wholesale_price_te', $this->wholesale_price_te, true);
        $criteria->compare('quantity_expected', $this->quantity_expected, true);
        $criteria->compare('quantity_received', $this->quantity_received, true);

        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supply_order, id_product ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supply_order' => 'id_supply_order',
            'id_product' => 'id_product'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function beforeValidate() {
        if (!isset($this->name)) {
            $attribute = ProductAttribute::model()->findByPk($this->id_product_attribute);
            $this->name = $attribute->fullname;
        }
        return parent::beforeValidate();
    }
    
    protected function updateOrder(){
        $criteria = new CDbCriteria();
        $criteria->condition = 'id_supply_order=:id_supply_order';
        $criteria->params = array(':id_supply_order' => $this->id_supply_order);
        $models = self::model()->findAll($criteria);
        $total = 0;
        foreach ($models as $model) {
            $total += $model->quantity_expected*$model->unit_price_ratio_te;
        }
        
        $order = SupplyOrder::model()->findByPk($this->id_supply_order);
        $order->total_te = $total;
        $order->save(false);          
    }
    public function beforeSave() {
        $this->price_te = $this->unit_price_ratio_te*$this->quantity_expected;
        return parent::beforeSave();
    }

    public function afterSave() {
        $this->updateOrder();
        return parent::afterSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SupplyOrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
