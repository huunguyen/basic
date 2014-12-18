<?php

/**
 * This is the model class for table "tbl_attribute".
 *
 * The followings are the available columns in table 'tbl_attribute':
 * @property string $id_attribute
 * @property string $id_attribute_group
 * @property string $color
 * @property string $position
 * @property string $name
 *
 * The followings are the available model relations:
 * @property AttributeGroup $idAttributeGroup
 * @property Image[] $tblImages
 * @property ProductAttribute[] $tblProductAttributes
 */
class Attribute extends CActiveRecord {

    public $old_position;
    public $min_position;
    public $max_position;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_attribute';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_attribute_group, name', 'required'),
            array('id_attribute_group, position', 'length', 'max' => 10),
            array('color', 'length', 'max' => 32),
            array('name', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_attribute, id_attribute_group, color, position, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idAttributeGroup' => array(self::BELONGS_TO, 'AttributeGroup', 'id_attribute_group'),
            'tblImages' => array(self::MANY_MANY, 'Image', 'tbl_image_attribute(id_attribute, id_image)'),
            'tblImageAttributes' => array(self::HAS_MANY, 'ImageAttribute', 'id_attribute'),
            'tblProductAttributes' => array(self::MANY_MANY, 'ProductAttribute', 'tbl_product_attribute_combination(id_attribute, id_product_attribute)'),
            'tblProductAttributeCombinations' => array(self::HAS_MANY, 'ProductAttributeCombination', 'id_attribute'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_attribute' => 'Mã Thuộc Tính',
            'id_attribute_group' => 'Mã Nhóm',
            'color' => 'Màu Sắc',
            'position' => 'Vị Trí',
            'name' => 'Tên Thuộc Tính',
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
        $criteria->compare('id_attribute_group', $this->id_attribute_group, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('name', $this->name, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, position ASC';
        $sort->attributes = array(
            'name' => 'name',
            'position' => 'position',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)).'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this).'_page', 0),
            ),
                )
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
    public function searchInGroup($id=null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
if($id!=null)
    $criteria->compare('id_attribute_group', $id, true);
else 
    $criteria->compare('id_attribute_group', $this->id_attribute_group, true);
        $criteria->compare('id_attribute', $this->id_attribute, true);
        
        $criteria->compare('color', $this->color, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('name', $this->name, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, position ASC';
        $sort->attributes = array(
            'name' => 'name',
            'position' => 'position',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)).'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this).'_page', 0),
            ),
                )
        );
    }
    
     public function searchByProAttribute($id_product_attribute=null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
// tim tat ca cac att cho pro att
        $values = array();
        if (isset($id_product_attribute)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = '$id_product_attribute=:id_product_attribute';
            $criteria3->params = array(':id_product_attribute' => $id_product_attribute);
            $pro_att_coms = ProductAttributeCombination::model()->findAll($criteria3);
            foreach ($pro_att_coms as $pro_att_com) {
                $values[] = $pro_att_com->id_attribute;
            }
        }
         
         
        $criteria = new CDbCriteria;
        $criteria->together = true; 
        $criteria->with = array('idAttributeGroup');
        
        $criteria->addInCondition('t.id_attribute', $values);
        
        $criteria->compare('t.position', $this->position, true);
        $criteria->compare('t.name', $this->name, true);

        $sort = new CSort;
        $sort->defaultOrder = 't.id_attribute_group, t.name, t.position ASC';
        $sort->attributes = array(
            't.id_attribute_group' => 't.id_attribute_group', 
            't.name' => 't.name',
            't.position' => 't.position',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)).'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this).'_page', 0),
            ),
                )
        );
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Attribute the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_attribute_group DESC';
            $criteria->compare('id_attribute_group', $this->id_attribute_group, true);
            // process position here. find range position. 
            $criteria->compare('position', $this->position, true);
            if ($group = self::model()->findAll($criteria)) {
                $criteria2 = new CDbCriteria();
                $criteria2->select = array('*', 'max(position) as max_position');
                $criteria2->compare('id_attribute_group', $this->id_attribute_group, true);
                $criteria2->order = 'position DESC, id_attribute_group ASC';
                $groups2 = self::model()->findAll($criteria2);
                foreach ($groups2 as $group2) {
                    $this->position = ++$group2->max_position;
                    break;
                }
            }
        } else {
            if (($this->old_position != $this->position)) {
                $criteria = new CDbCriteria();
                $criteria->order = 'position DESC, id_attribute_group ASC';
                $criteria->compare('id_attribute_group', $this->id_attribute_group, true);
                $criteria->compare('position', $this->position, true);
                if ($group = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->compare('id_attribute_group', $this->id_attribute_group, true);
                    $criteria2->order = 'position DESC, id_attribute_group ASC';
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
