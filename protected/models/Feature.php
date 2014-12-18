<?php

/**
 * This is the model class for table "tbl_feature".
 *
 * The followings are the available columns in table 'tbl_feature':
 * @property string $id_feature
 * @property string $name
 * @property string $position
 */
class Feature extends CActiveRecord {

    public $old_position;
    public $min_position;
    public $max_position;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_feature';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 45),
            array('position', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_feature, name, position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'featureProducts' => array(self::HAS_MANY, 'FeatureProduct', 'id_feature'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_feature' => 'Mã Điểm nổi bật',
            'name' => 'Tên Đặc Tả',
            'position' => 'Vị Trí',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('position', $this->position, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_feature', $this->id_feature, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('position', $this->position, true);
        $criteria->with = 'featureProducts';
        $criteria->together = true;

        if (isset($id_product)) {
            $criteria->compare('featureProducts.id_product', $id_product, true);
        }

        $sort = new CSort;
        $sort->defaultOrder = 'name, id_feature ASC';
        $sort->attributes = array(
            'name' => 'name',
            'id_feature' => 'id_feature'
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

    public function searchByOtherProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('position', $this->position, true);
        $criteria->with = 'featureProducts';
        $criteria->together = true;

        if (isset($id_product)) {
            $criteria2 = new CDbCriteria;
            $criteria2->with = 'featureProducts';
            $criteria2->together = true;
            $criteria2->compare('featureProducts.id_product', $id_product, true);
            $features = $this->findAll($criteria2);
            if (isset($features) && count($features) > 0) {
                $list = array();
                foreach ($features as $feature) {
                    $list[] = $feature->id_feature;
                }
                $criteria->addNotInCondition('id_feature', $list);
            }
        }

        $sort = new CSort;
        $sort->defaultOrder = 'name, id_feature ASC';
        $sort->attributes = array(
            'name' => 'name',
            'id_feature' => 'id_feature'
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
     * @return Feature the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC';
            // process position here. find range position. 
            $criteria->compare('position', $this->position, true);
            if ($group = self::model()->findAll($criteria)) {
                $criteria2 = new CDbCriteria();
                $criteria2->select = array('*', 'max(position) as max_position');
                $criteria2->order = 'position DESC';
                $groups2 = self::model()->findAll($criteria2);
                foreach ($groups2 as $group2) {
                    $this->position = ++$group2->max_position;
                    break;
                }
            }
        } else {
            if (($this->old_position != $this->position)) {
                $criteria = new CDbCriteria();
                $criteria->order = 'position DESC';
                $criteria->compare('position', $this->position, true);
                if ($group = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC';
                    $groups2 = self::model()->findAll($criteria2);
                    foreach ($groups2 as $group2) {
                        $this->position = ++$group2->max_position;
                        break;
                    }
                }
            }
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->old_position = $this->position;

        return parent::afterFind();
    }

}
