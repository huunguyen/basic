<?php

/**
 * This is the model class for table "tbl_feature_value".
 *
 * The followings are the available columns in table 'tbl_feature_value':
 * @property string $id_feature_value
 * @property string $id_feature
 * @property integer $custom
 * @property string $value
 */
class FeatureValue extends CActiveRecord {

    public $newvalue;
    public $oldvalue;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_feature_value';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_feature, value', 'required'),
            array('custom', 'numerical', 'integerOnly' => true),
            array('id_feature', 'length', 'max' => 10),
            array('value', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('newvalue, id_feature_value, id_feature, custom, value', 'safe', 'on' => 'search'),
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
            'featureProducts' => array(self::HAS_MANY, 'FeatureProduct', 'id_feature_value'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_feature_value' => 'Mã Giá Trị Nổi Bật',
            'id_feature' => 'Mã Nổi Bật',
            'custom' => 'Tùy Chỉnh',
            'value' => 'Giá Trị',
            'newvalue' => 'Gía Trị Mới',
            'id_feature_value[]' => 'Mã Giá Trị Nổi Bật',
            'value[]' => 'Giá Trị',
            'newvalue[]' => 'Gía Trị Mới'
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

        $criteria->compare('id_feature_value', $this->id_feature_value, true);
        $criteria->compare('id_feature', $this->id_feature, true);
        $criteria->compare('custom', $this->custom);
        $criteria->compare('value', $this->value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByFeatureId($id_feature) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        if (isset($id_feature) && $model = Feature::model()->findByPk($id_feature))
            $criteria->compare('id_feature', $model->id_feature, true);
        else
            $criteria->compare('id_feature', $this->id_feature, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_feature, value ASC';
        $sort->attributes = array(
            'value' => 'value',
            'id_feature' => 'id_feature'
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
     * @return FeatureValue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
