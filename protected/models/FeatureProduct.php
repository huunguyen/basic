<?php

/**
 * This is the model class for table "tbl_feature_product".
 *
 * The followings are the available columns in table 'tbl_feature_product':
 * @property string $id_feature
 * @property string $id_product
 * @property string $id_feature_value
 */
class FeatureProduct extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_feature_product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_feature, id_product, id_feature_value', 'required'),
            array('id_feature, id_product, id_feature_value', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_feature, id_product, id_feature_value', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idFeature' => array(self::BELONGS_TO, 'Feature', 'id_feature'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'idFeatureValue' => array(self::BELONGS_TO, 'FeatureValue', 'id_feature_value'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_feature' => 'Id Feature',
            'id_product' => 'Id Product',
            'id_feature_value' => 'Id Feature Value',
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

        $criteria->compare('id_feature', $this->id_feature, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_feature_value', $this->id_feature_value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
public function searchByProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->compare('id_product', $this->id_product, true);
        if (isset($id_product)) {
            $criteria->condition = 'id_product=:id_product';
            $criteria->params = array(':id_product' => $id_product);
        } else
            $criteria->compare('id_feature', $this->id_feature, true);
        
        $criteria->compare('id_feature_value', $this->id_feature_value, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_product, id_feature, id_feature_value ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'id_feature' => 'id_feature',
            'id_feature_value' => 'id_feature_value'
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
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FeatureProduct the static model class
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
        $model = self::model()->findByPk(array('id_product' => $this->id_product, 'id_feature' => $this->id_feature));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_product = $this->id_product;
            $model->id_feature = $this->id_feature;
        }
        $model->id_feature_value = $this->id_feature_value;
        $model->save(false);
        return $model;
    }
}
