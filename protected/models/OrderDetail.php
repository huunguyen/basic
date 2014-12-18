<?php

/**
 * This is the model class for table "tbl_order_detail".
 *
 * The followings are the available columns in table 'tbl_order_detail':
 * @property string $id_order_detail
 * @property string $id_order
 * @property string $id_warehouse
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $quantity
 * @property integer $quantity_in_stock
 * @property string $quantity_refunded
 * @property string $quantity_return
 * @property string $quantity_reinjected
 * @property string $price
 * @property string $reduction_percent
 * @property string $reduction_amount
 * @property string $reduction_amount_tax_incl
 * @property string $reduction_amount_tax_excl
 * @property string $reference
 * @property string $supplier_reference
 * @property double $weight
 * @property string $total_price_tax_incl
 * @property string $total_price_tax_excl
 * @property string $unit_price_tax_incl
 * @property string $unit_price_tax_excl
 * @property string $total_shipping_price_tax_incl
 * @property string $total_shipping_price_tax_excl
 * @property string $purchase_supplier_price
 * @property string $original_product_price
 *
 * The followings are the available model relations:
 * @property ProductAttribute $idProductAttribute
 * @property Orders $idOrder
 * @property Product $idProduct
 * @property Warehouse $idWarehouse
 * @property OrderDetailProductSupplier[] $orderDetailProductSuppliers
 * @property OrderDetailTax[] $orderDetailTaxes
 * @property OrderReturnDetail[] $orderReturnDetails
 * @property OrderSlip[] $tblOrderSlips
 */
class OrderDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_order_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_order, id_product', 'required'),
            array('quantity_in_stock', 'numerical', 'integerOnly' => true),
            array('weight', 'numerical'),
            array('id_order, id_warehouse, id_product, id_product_attribute, quantity, quantity_refunded, quantity_return, quantity_reinjected, reduction_percent', 'length', 'max' => 10),
            array('price, reduction_amount, reduction_amount_tax_incl, reduction_amount_tax_excl, total_price_tax_incl, total_price_tax_excl, unit_price_tax_incl, unit_price_tax_excl, total_shipping_price_tax_incl, total_shipping_price_tax_excl, purchase_supplier_price, original_product_price', 'length', 'max' => 20),
            array('reference, supplier_reference', 'length', 'max' => 32),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_order_detail, id_order, id_warehouse, id_product, id_product_attribute, quantity, quantity_in_stock, quantity_refunded, quantity_return, quantity_reinjected, price, reduction_percent, reduction_amount, reduction_amount_tax_incl, reduction_amount_tax_excl, reference, supplier_reference, weight, total_price_tax_incl, total_price_tax_excl, unit_price_tax_incl, unit_price_tax_excl, total_shipping_price_tax_incl, total_shipping_price_tax_excl, purchase_supplier_price, original_product_price', 'safe', 'on' => 'search'),
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
            'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'idWarehouse' => array(self::BELONGS_TO, 'Warehouse', 'id_warehouse'),
            'orderDetailProductSuppliers' => array(self::HAS_MANY, 'OrderDetailProductSupplier', 'id_order_detail'),
            'orderDetailTaxes' => array(self::HAS_MANY, 'OrderDetailTax', 'id_order_detail'),
            'orderReturnDetails' => array(self::HAS_MANY, 'OrderReturnDetail', 'id_order_detail'),
            'tblOrderSlips' => array(self::MANY_MANY, 'OrderSlip', 'tbl_order_slip_detail(id_order_detail, id_order_slip)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_order_detail' => 'Mã chi tiết đơn hàng',
            'id_order' => 'Mã đơn hàng',
            'id_warehouse' => 'Mã kho hàng',
            'id_product' => 'Mã sản phẩm',
            'id_product_attribute' => 'Mã sản phẩm',
            'quantity' => 'Số lượng',
            'quantity_in_stock' => 'Số lượng trong kho',
            'quantity_refunded' => 'Số lượng hoàn lại',
            'quantity_return' => 'Số lượng trả lại',
            'quantity_reinjected' => 'Số lượng bị từ chối',
            'price' => 'Giá',
            'reduction_percent' => 'Phầm trăm giảm',
            'reduction_amount' => 'Khoản giảm',
            'reduction_amount_tax_incl' => 'Khoản giảm gồm thuế',
            'reduction_amount_tax_excl' => 'Khoản giảm không thuế',
            'reference' => 'Tham khảo (Chứng từ)',
            'supplier_reference' => 'Tham khảo (Chứng từ) NCC',
            'weight' => 'Nặng',
            'total_price_tax_incl' => 'Tổng trả gồm thuế',
            'total_price_tax_excl' => 'Tổng trả không thuế',
            'unit_price_tax_incl' => 'Giá mỗi đơn vị gồm thuế',
            'unit_price_tax_excl' => 'Giá mỗi đơn vị không thuế',
            'total_shipping_price_tax_incl' => 'Tổng phí vận chuyển gồm thuế',
            'total_shipping_price_tax_excl' => 'Tổng phí vận chuyển không thuế',
            'purchase_supplier_price' => 'Giá từ NCC',
            'original_product_price' => 'Giá trong hệ thống',
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

        $criteria->compare('id_order_detail', $this->id_order_detail, true);
        $criteria->compare('id_order', $this->id_order, true);
        $criteria->compare('id_warehouse', $this->id_warehouse, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('quantity_in_stock', $this->quantity_in_stock);
        $criteria->compare('quantity_refunded', $this->quantity_refunded, true);
        $criteria->compare('quantity_return', $this->quantity_return, true);
        $criteria->compare('quantity_reinjected', $this->quantity_reinjected, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('reduction_percent', $this->reduction_percent, true);
        $criteria->compare('reduction_amount', $this->reduction_amount, true);
        $criteria->compare('reduction_amount_tax_incl', $this->reduction_amount_tax_incl, true);
        $criteria->compare('reduction_amount_tax_excl', $this->reduction_amount_tax_excl, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('supplier_reference', $this->supplier_reference, true);
        $criteria->compare('weight', $this->weight);
        $criteria->compare('total_price_tax_incl', $this->total_price_tax_incl, true);
        $criteria->compare('total_price_tax_excl', $this->total_price_tax_excl, true);
        $criteria->compare('unit_price_tax_incl', $this->unit_price_tax_incl, true);
        $criteria->compare('unit_price_tax_excl', $this->unit_price_tax_excl, true);
        $criteria->compare('total_shipping_price_tax_incl', $this->total_shipping_price_tax_incl, true);
        $criteria->compare('total_shipping_price_tax_excl', $this->total_shipping_price_tax_excl, true);
        $criteria->compare('purchase_supplier_price', $this->purchase_supplier_price, true);
        $criteria->compare('original_product_price', $this->original_product_price, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 10),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }
    
 public function searchByOrder($id_order) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_order', $id_order);

        $sort = new CSort;
        $sort->defaultOrder = 'id_order, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_order' => 'id_order',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 10),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }
    
    public function beforeSave() {
        if (isset($this->id_product_attribute) && $pro_att = ProductAttribute::model()->findByPk($this->id_product_attribute)) {
            $this->weight = $pro_att->weight;
            $this->reference = $pro_att->reference;
            $this->supplier_reference = $pro_att->supplier_reference;
            $this->id_product = $pro_att->id_product;
            $this->purchase_supplier_price = $this->original_product_price = $pro_att->price;
        }

        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
