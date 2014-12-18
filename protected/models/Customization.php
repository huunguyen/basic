<?php

/**
 * This is the model class for table "tbl_customization".
 *
 * The followings are the available columns in table 'tbl_customization':
 * @property string $id_customization
 * @property string $id_cart
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_address_delivery
 * @property integer $quantity
 * @property integer $quantity_refunded
 * @property integer $quantity_returned
 * @property integer $in_cart
 *
 * The followings are the available model relations:
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 * @property Address $idAddressDelivery
 * @property Cart $idCart
 * @property CustomizedData[] $customizedDatas
 * @property OrderReturnDetail[] $orderReturnDetails
 */
class Customization extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_customization';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_cart, id_product, quantity', 'required'),
            array('quantity, quantity_refunded, quantity_returned, in_cart', 'numerical', 'integerOnly' => true),
            array('id_cart, id_product, id_product_attribute, id_address_delivery', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_customization, id_cart, id_product, id_product_attribute, id_address_delivery, quantity, quantity_refunded, quantity_returned, in_cart', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
            'idAddressDelivery' => array(self::BELONGS_TO, 'Address', 'id_address_delivery'),
            'idCart' => array(self::BELONGS_TO, 'Cart', 'id_cart'),
            'customizedDatas' => array(self::HAS_MANY, 'CustomizedData', 'id_customization'),
            'orderReturnDetails' => array(self::HAS_MANY, 'OrderReturnDetail', 'id_customization'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_customization' => 'Id Customization',
            'id_cart' => 'Id Cart',
            'id_product' => 'Id Product',
            'id_product_attribute' => 'Id Product Attribute',
            'id_address_delivery' => 'Id Address Delivery',
            'quantity' => 'Quantity',
            'quantity_refunded' => 'Quantity Refunded',
            'quantity_returned' => 'Quantity Returned',
            'in_cart' => 'In Cart',
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

        $criteria->compare('id_customization', $this->id_customization, true);
        $criteria->compare('id_cart', $this->id_cart, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('id_address_delivery', $this->id_address_delivery, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('quantity_refunded', $this->quantity_refunded);
        $criteria->compare('quantity_returned', $this->quantity_returned);
        $criteria->compare('in_cart', $this->in_cart);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        if (!isset($this->quantity_refunded) || ($this->quantity_refunded == 0)) {
            $this->quantity_returned = $this->quantity;
        } else {
            $this->quantity_returned = $this->quantity - $this->quantity_refunded;
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Customization the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
