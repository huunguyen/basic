<?php

/**
 * This is the model class for table "tbl_product_attribute_combination".
 *
 * The followings are the available columns in table 'tbl_product_attribute_combination':
 * @property string $id_attribute
 * @property string $id_product_attribute
 */
class ProductAttributeCombination extends CActiveRecord {
    public $_proAttribute = array();
    public $_attribute = array();
    public $_list = array();
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_product_attribute_combination';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_attribute, id_product_attribute', 'required'),
            array('id_attribute, id_product_attribute', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_attribute, id_product_attribute', 'safe', 'on' => 'search'),
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
            'idAttribute' => array(self::BELONGS_TO, 'Attribute', 'id_attribute'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_attribute' => 'Id Attribute',
            'id_product_attribute' => 'Id Product Attribute',
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

        $criteria->compare('id_attribute', $this->id_attribute, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 'id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $productattributes = ProductAttribute::model()->findAll($criteria3);
            foreach ($productattributes as $productattribute) {
                $values[] = $productattribute->id_product_attribute;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->compare('id_attribute', $this->id_attribute, true);
        if (!empty($values))
            $criteria->addInCondition('id_product_attribute', $values);

        $sort = new CSort;
        $sort->defaultOrder = 'id_product_attribute, id_attribute ASC';
        $sort->attributes = array(
            'id_product_attribute' => 'id_product_attribute',
            'id_attribute' => 'id_attribute'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByPro_has_Atts($id_product = null, $list = array()) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        $a_values = new CMap();
        if (isset($id_product) && !empty($list)) {
            // tim pro_att cua pro
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 'id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            if($productattributes = ProductAttribute::model()->findAll($criteria3)){
                foreach ($productattributes as $productattribute) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->condition = 'id_product_attribute=:id_product_attribute';
                    $criteria2->params = array(':id_product_attribute' => $productattribute->id_product_attribute);
                    if($productattributecombinations = ProductAttributeCombination::model()->findAll($criteria2)){
                        $atts = array(); // chua att cua pro_att
                        foreach ($productattributecombinations as $productattributecombination) {
                            $atts[] = $productattributecombination->id_attribute;
                        }
                        
                        $flag = true;
                        foreach ($list as $item) {
                            if (!in_array($item, $atts)) {
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            $values[] = $productattribute->id_product_attribute; 
                            $a_values->mergeWith($atts);
                        }
                    }
                }
            }
            
        }
        $criteria = new CDbCriteria;

        $criteria->compare('id_attribute', $this->id_attribute, true);
        $criteria->addInCondition('id_product_attribute', $values);

        $sort = new CSort;
        $sort->defaultOrder = 'id_product_attribute, id_attribute ASC';
        $sort->attributes = array(
            'id_product_attribute' => 'id_product_attribute',
            'id_attribute' => 'id_attribute'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductAttributeCombination the static model class
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
        $model = self::model()->findByPk(array('id_attribute' => $this->id_attribute, 'id_product_attribute' => $this->id_product_attribute));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_attribute = $this->id_attribute;
            $model->id_product_attribute = $this->id_product_attribute;
        }
        $model->save(false);
        return $model;
    }
}
