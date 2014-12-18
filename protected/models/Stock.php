<?php

/**
 * This is the model class for table "tbl_stock".
 *
 * The followings are the available columns in table 'tbl_stock':
 * @property string $id_stock
 * @property string $id_warehouse
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $reference
 * @property string $physical_quantity
 * @property string $usable_quantity
 * @property string $price_te
 *
 * The followings are the available model relations:
 * @property Warehouse $idWarehouse
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 * @property StockMvt[] $stockMvts
 */
class Stock extends CActiveRecord {

    public $count_id_product_attribute;
    public $sum_physical_quantity;
    public $old_physical_quantity;
    public $transfer_stock;
    public $inreason;
    public $outreason;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_stock';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_warehouse, id_product, id_product_attribute, reference, physical_quantity, usable_quantity', 'required'),
            array('id_warehouse, id_product, id_product_attribute, physical_quantity, usable_quantity', 'length', 'max' => 10),
            array('reference', 'length', 'max' => 32),
            array('price_te', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('count_id_product_attribute, sum_physical_quantity, id_stock, id_warehouse, id_product, id_product_attribute, reference, physical_quantity, usable_quantity, price_te', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idWarehouse' => array(self::BELONGS_TO, 'Warehouse', 'id_warehouse'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
            'stockMvts' => array(self::HAS_MANY, 'StockMvt', 'id_stock'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_stock' => 'Mã Lô Hàng',
            'id_warehouse' => 'Mã Kho Hàng',
            'id_product' => 'Mã Sản Phẩm',
            'id_product_attribute' => 'Mã Thuộc Tính SP',
            'reference' => 'MS-HoaDon - MS-ChungTu',
            'physical_quantity' => 'SL Thực Tế',
            'usable_quantity' => 'SL Hữu Dụng',
            'price_te' => 'Giá Nhập',
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

        $criteria->compare('id_stock', $this->id_stock, true);
        $criteria->compare('id_warehouse', $this->id_warehouse, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('physical_quantity', $this->physical_quantity, true);
        $criteria->compare('usable_quantity', $this->usable_quantity, true);
        $criteria->compare('price_te', $this->price_te, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_warehouse, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_warehouse' => 'id_warehouse',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute',
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

    public function searchProductInStock() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = '*, COUNT(id_product_attribute) count_id_product_attribute, SUM(physical_quantity) sum_physical_quantity';
        $criteria->group = 'id_product';
        $criteria->order = 'id_product DESC, count_id_product_attribute DESC';

//$criteria->condition = 'receiver_id = :receiverId';
//$criteria->params = array('receiverId' => $userId);	

        $sort = new CSort;
        $sort->defaultOrder = 'id_warehouse, id_product ASC';
        $sort->attributes = array(
            'id_warehouse' => 'id_warehouse',
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
    public function searchPAInStock($id_product) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->condition = 'id_product =:id_product AND id_product_attribute IS NOT NULL';
        $criteria->params = array('id_product' => $id_product);
        $criteria->order = 'id_product DESC, id_product_attribute DESC';

        $sort = new CSort;
        $sort->defaultOrder = 'id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute'
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
    
    protected function process(){
        if((get_class($this)==get_class($this->transfer_stock)) && ($this->scenario=="transfer")){
            $this->inreason = StockMvtReason::model()->findByPk(2);
            $this->outreason = StockMvtReason::model()->findByPk(3);
//            if($this->inreason==null) {
//                $this->inreason = new StockMvtReason;
//                $this->inreason->sign = 1;
//                $this->inreason->name = "Chuyển Hàng Sang Kho Khác";
//                $this->inreason->save(false);
//            }
//            if($this->outreason==null) {
//                $this->outreason = new StockMvtReason;
//                $this->outreason->sign = 1;
//                $this->outreason->name = "Chuyển Hàng Từ Kho Khác";
//                $this->outreason->save(false);
//            }
            $stock_inmvt = new StockMvt;
            $stock_outmvt = new StockMvt;
            $stock_inmvt->sign = $stock_outmvt->sign = 1;
            $stock_inmvt->physical_quantity = $stock_outmvt->physical_quantity = $this->physical_quantity;
            $stock_inmvt->price_te = $stock_outmvt->price_te = $this->price_te;
            $stock_inmvt->date_add = $stock_outmvt->date_add = date('Y-m-d H:i:s', time());
            
            $stock_outmvt->id_stock_mvt_reason = 2;
            $stock_inmvt->id_stock_mvt_reason = 3;
            
            $stock_outmvt->id_stock = $this->getPrimaryKey();
            $stock_inmvt->id_stock = $this->transfer_stock->getPrimaryKey();
            $stock_outmvt->save();
            $stock_inmvt->save();
            
//            dump($stock_inmvt);
//            dump($stock_outmvt);
//            exit();
        }
    }

    protected function beforeValidate() {
        if(!isset($this->usable_quantity)){
            $this->usable_quantity = $this->physical_quantity;
        }
        // xu ly chuyen hang va rang buot o day
        if($this->isNewRecord && (get_class($this)==get_class($this->transfer_stock)) && ($this->scenario=="transfer")){
            if(($this->physical_quantity<=0) ||($this->physical_quantity>$this->transfer_stock->physical_quantity)){
                $this->addError('physical_quantity', Yii::t('errors', 'Số lượng nhập vào không chính xác.'));
            }
        }
        return parent::beforeValidate();
    }

    public function afterFind() {
        $this->old_physical_quantity = $this->physical_quantity;
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Stock the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
