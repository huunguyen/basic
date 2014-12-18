<?php

/**
 * This is the model class for table "tbl_attribute_group".
 *
 * The followings are the available columns in table 'tbl_attribute_group':
 * @property string $id_attribute_group
 * @property string $group_type
 * @property string $position
 * @property string $name
 * @property string $public_name
 *
 * The followings are the available model relations:
 * @property Attribute[] $attributes
 */
class AttributeGroup extends CActiveRecord {

    public $old_position;
    public $min_position;
    public $max_position;
    public $total;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_attribute_group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, public_name', 'required'),
            array('name', 'unique', 'message' => '{attribute} đã tồn tại!'),
            array('name', 'match', 'pattern' => '/^([A-Za-z0-9_\-\s]+)$/u', 'message' => 'Tên chỉ được gõ ký tự, số ,ký tự "_-" và không được có khoảng trắng. '),
            array('position', 'length', 'max' => 10),
            array('public_name, group_type', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('old_position, id_attribute_group, group_type, position, name, public_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'attributes' => array(self::HAS_MANY, 'Attribute', 'id_attribute_group'),
            'attributeCount' => array(self::STAT, 'Attribute', 'id_attribute_group'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_attribute_group' => 'Mã Nhóm',
            'group_type' => 'Loại Nhóm',
            'position' => 'Vị Trí',
            'name' => 'Tên Nhóm',
            'public_name' => 'Tên Xuất bản',
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

        $criteria->compare('id_attribute_group', $this->id_attribute_group, true);
        $criteria->compare('group_type', $this->group_type, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('public_name', $this->public_name, true);
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
                'pageSize' => Yii::app()->user->getState($uni_id . 'attributeGroupPageSize', 20),
                'currentPage' => Yii::app()->user->getState('AttributeGroup_page', 0),
            ),
                )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AttributeGroup the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_attribute_group DESC';
            // process position here. find range position. 
            $criteria->compare('position', $this->position, true);
            if ($group = self::model()->findAll($criteria)) {
                $criteria2 = new CDbCriteria();
                $criteria2->select = array('*', 'max(position) as max_position');
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
                $criteria->compare('active', true);
                $criteria->order = 'position DESC, id_attribute_group ASC';
                $criteria->compare('position', $this->position, true);
                if ($group = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
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
