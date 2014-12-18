<?php

/**
 * This is the model class for table "tbl_product_hot_deal".
 *
 * The followings are the available columns in table 'tbl_product_hot_deal':
 * @property string $id_product_hot_deal
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_hot_deal
 * @property string $id_specific_price_rule
 * @property string $quantity
 * @property string $price
 * @property string $remain_quantity
 * @property string $state
 *
 * The followings are the available model relations:
 * @property Product $idProduct
 * @property HotDeal $idHotDeal
 * @property ProductAttribute $idProductAttribute
 * @property SpecificPriceRule $idSpecificPriceRule
 */
class ProductHotDeal extends CActiveRecord {

    public $old_id_specific_price_rule;
    public $old_id_product_attribute;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_product_hot_deal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_product, id_hot_deal, id_specific_price_rule', 'required'),
            array('id_product, id_product_attribute, id_hot_deal, id_specific_price_rule, quantity, remain_quantity', 'length', 'max' => 10),
            array('price', 'length', 'max' => 20),
            array('state', 'length', 'max' => 9),
            array('id_product_attribute, id_specific_price_rule', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_product_hot_deal, id_product, id_product_attribute, id_hot_deal, id_specific_price_rule, quantity, price, remain_quantity, state', 'safe', 'on' => 'search'),
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
            'idHotDeal' => array(self::BELONGS_TO, 'HotDeal', 'id_hot_deal'),
            'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
            'idSpecificPriceRule' => array(self::BELONGS_TO, 'SpecificPriceRule', 'id_specific_price_rule'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_product_hot_deal' => 'Mã Chương Trình Giảm Giá',
            'id_product' => 'Mã Sản Phẩm',
            'id_product_attribute' => 'Mã Loại Sản Phẩm',
            'id_hot_deal' => 'Mã Chương Trình',
            'id_specific_price_rule' => 'Mã Đặc Tả Giá',
            'quantity' => 'Số Lượng',
            'price' => 'Giá',
            'remain_quantity' => 'Số Lượng Còn Lại',
            'state' => 'Trạng Thái',
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

        $criteria->compare('id_product_hot_deal', $this->id_product_hot_deal, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('id_hot_deal', $this->id_hot_deal, true);
        $criteria->compare('id_specific_price_rule', $this->id_specific_price_rule, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('remain_quantity', $this->remain_quantity, true);
        $criteria->compare('state', $this->state, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_hot_deal, id_product, id_product_attribute, id_specific_price_rule ASC';
        $sort->attributes = array(
            'id_hot_deal' => 'id_hot_deal',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute',
            'id_specific_price_rule' => 'id_specific_price_rule'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 5),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByHotDeal($id_hot_deal = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_product_hot_deal', $this->id_product_hot_deal, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        if (isset($id_hot_deal)) {
            $criteria->compare('id_hot_deal', $id_hot_deal, true);
        } else
            $criteria->compare('id_hot_deal', $this->id_hot_deal, true);
        $criteria->compare('id_specific_price_rule', $this->id_specific_price_rule, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('remain_quantity', $this->remain_quantity, true);
        $criteria->compare('state', $this->state, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_hot_deal, id_product, id_product_attribute, id_specific_price_rule ASC';
        $sort->attributes = array(
            'id_hot_deal' => 'id_hot_deal',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute',
            'id_specific_price_rule' => 'id_specific_price_rule'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 5),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductHotDeal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterFind() {
        if (isset($this->id_specific_price_rule)) {
            $this->old_id_specific_price_rule = $this->id_specific_price_rule;
        }
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
        if (isset($this->id_product_attribute)){
            $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_product_attribute' => $this->id_product_attribute, 'id_hot_deal' => $this->id_hot_deal, 'id_specific_price_rule' => $this->id_specific_price_rule));
        }
        else
            {
            $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_hot_deal' => $this->id_hot_deal, 'id_specific_price_rule' => $this->id_specific_price_rule));
        }
        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_hot_deal = $this->id_hot_deal;
            $model->id_product = $this->id_product;
            $model->id_product_attribute = $this->id_product_attribute;
            $model->id_specific_price_rule = $this->id_specific_price_rule;
        }
        if (isset($this->id_product_attribute) && $pro_att = ProductAttribute::model()->findByPk($this->id_product_attribute)){
            $model->price = $pro_att->price;
            if($model->isNewRecord)
                $model->remain_quantity = $pro_att->quantity;
        }
        $model->save(false);
        return $model;
    }

    public function updateRule() {

        if (isset($this->old_id_specific_price_rule, $this->id_specific_price_rule) && ($this->old_id_specific_price_rule != $this->id_specific_price_rule)) {
            if (isset($this->id_product_attribute))
                $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_product_attribute' => $this->id_product_attribute, 'id_hot_deal' => $this->id_hot_deal, 'id_specific_price_rule' => $this->old_id_specific_price_rule));
            else
                $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_hot_deal' => $this->id_hot_deal, 'id_specific_price_rule' => $this->id_specific_price_rule));
        }
        else 
            {
                if (!empty($this->id_product_attribute)) 
                {
                    $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_product_attribute' => $this->id_product_attribute, 'id_hot_deal' => $this->id_hot_deal, 'id_specific_price_rule' => $this->id_specific_price_rule));
                } 
                else 
                {
                    $model = self::model()->findByAttributes(array('id_product' => $this->id_product, 'id_hot_deal' => $this->id_hot_deal, 'id_specific_price_rule' => $this->id_specific_price_rule));
                }
        }

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_hot_deal = $this->id_hot_deal;
            $model->id_product = $this->id_product;
            $model->id_product_attribute = $this->id_product_attribute;
            $model->id_specific_price_rule = $this->id_specific_price_rule;
        }        
        $model->id_specific_price_rule = $this->id_specific_price_rule;
        $model->quantity = $this->quantity;
        $rule = SpecificPriceRule::model()->findByPk($this->id_specific_price_rule);
        if($rule->reduction_type == "amount")
            $model->price = $this->price - $rule->reduction;
        else $model->price = $this->price - $this->price*$rule->reduction/100;
        $model->save(false);
        return $model;
    }

}
