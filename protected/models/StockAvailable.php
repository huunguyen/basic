<?php

/**
 * This is the model class for table "tbl_stock_available".
 *
 * The followings are the available columns in table 'tbl_stock_available':
 * @property string $id_stock_available
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_store
 * @property integer $quantity
 * @property integer $depends_on_stock
 * @property integer $out_of_stock
 *
 * The followings are the available model relations:
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 * @property Store $idStore
 */
class StockAvailable extends CActiveRecord {

    public $count_id_product_attribute;
    public $sum_quantity;
    public $max_id_product_attribute;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_stock_available';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_product, id_product_attribute, id_store', 'required'),
            array('quantity, depends_on_stock, out_of_stock', 'numerical', 'integerOnly' => true),
            array('id_product, id_product_attribute, id_store', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('count_id_product_attribute, sum_quantity, max_id_product_attribute, id_stock_available, id_product, id_product_attribute, id_store, quantity, depends_on_stock, out_of_stock', 'safe', 'on' => 'search'),
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
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_stock_available' => 'Id Stock Available',
            'id_product' => 'Id Product',
            'id_product_attribute' => 'Id Product Attribute',
            'id_store' => 'Id Store',
            'quantity' => 'Quantity',
            'depends_on_stock' => 'Depends On Stock',
            'out_of_stock' => 'Out Of Stock',
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

        $criteria->compare('id_stock_available', $this->id_stock_available, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('id_store', $this->id_store, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('depends_on_stock', $this->depends_on_stock);
        $criteria->compare('out_of_stock', $this->out_of_stock);

        $sort = new CSort;
        $sort->defaultOrder = 'depends_on_stock, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'depends_on_stock' => 'depends_on_stock',
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

    public function searchProductOutStock() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = '*, COUNT(id_product_attribute) count_id_product_attribute, SUM(quantity) sum_quantity';
        $criteria->group = 'id_product';
        $criteria->order = 'id_product DESC, count_id_product_attribute DESC, sum_quantity DESC';

        $criteria->condition = 'id_product_attribute IS NOT NULL';

        $sort = new CSort;
        $sort->defaultOrder = 'id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'count_id_product_attribute' => 'count_id_product_attribute'
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

    public function searchPAOutStock($id_product) {
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StockAvailable the static model class
     */
    public static function model($className = __CLASS__) {
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
        if ($this->id_product_attribute == null) {
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $this->id_product);
            $criteria->addCondition("id_product_attribute IS NULL");
            $model = self::model()->find($criteria);
        } else {
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $this->id_product);
            $criteria->compare('id_product_attribute', $this->id_product_attribute);
            $model = self::model()->find($criteria);
        }
        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_product = $this->id_product;
            $model->id_product_attribute = $this->id_product_attribute;
            $model->id_store = Config::ID_STORE;
        }
        $model->quantity = $this->quantity;
        $model->depends_on_stock = $this->depends_on_stock;
        $model->out_of_stock = $this->out_of_stock;
        $model->save(false);
        return $model;
    }

}
