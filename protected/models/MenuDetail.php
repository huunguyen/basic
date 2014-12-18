<?php

/**
 * This is the model class for table "tbl_menu_detail".
 *
 * The followings are the available columns in table 'tbl_menu_detail':
 * @property string $id_menu_detail
 * @property string $id_menu
 * @property string $id_parent
 * @property integer $active
 * @property string $title
 * @property string $alias
 * @property string $link
 * @property string $img
 * @property string $type
 * @property string $position
 *
 * The followings are the available model relations:
 * @property Menu $idMenu
 * @property MenuDetail $idParent
 * @property MenuDetail[] $menuDetails
 */
class MenuDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_menu_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_menu, type', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('id_menu, id_parent, position', 'length', 'max' => 10),
            array('title, alias, link, img', 'length', 'max' => 250),
            array('type', 'length', 'max' => 8),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_menu_detail, id_menu, id_parent, active, title, alias, link, img, type, position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idMenu' => array(self::BELONGS_TO, 'Menu', 'id_menu'),
            'idParent' => array(self::BELONGS_TO, 'MenuDetail', 'id_parent'),
            'menuDetails' => array(self::HAS_MANY, 'MenuDetail', 'id_parent'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_menu_detail' => 'Mã chi tiết',
            'id_menu' => 'Mã menu',
            'id_parent' => 'Mã cha',
            'active' => 'Trạng thái',
            'title' => 'Tiêu đề',
            'alias' => 'Bí danh',
            'link' => 'Liên kết',
            'img' => 'Ảnh',
            'type' => 'Loại',
            'position' => 'Vị trí',
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

        $criteria->compare('id_menu_detail', $this->id_menu_detail, true);
        $criteria->compare('id_menu', $this->id_menu, true);
        $criteria->compare('id_parent', $this->id_parent, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('img', $this->img, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('position', $this->position, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_menu, id_parent, type, title ASC';
        $sort->attributes = array(
            'id_menu' => 'id_menu',
            'id_parent' => 'id_parent',
            'type' => 'type',
            'title' => 'title'
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
    public function searchByMenu($id_menu = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_menu', $id_menu);
        $criteria->addCondition("id_parent IS NULL");

        $sort = new CSort;
        $sort->defaultOrder = ' id_parent, type, title ASC';
        $sort->attributes = array(
            'id_parent' => 'id_parent',
            'type' => 'type',
            'title' => 'title'
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
    public function searchByParent($id_parent = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_parent', $id_parent);

        $sort = new CSort;
        $sort->defaultOrder = ' id_parent, type, title ASC';
        $sort->attributes = array(
            'id_parent' => 'id_parent',
            'type' => 'type',
            'title' => 'title'
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

    public function beforeValidate() {
        if (!isset($this->alias)) {
            $this->alias = PostHelper::TitleVNtoEN($this->title) . "_" . PostHelper::id4slug($this->id_menu_detail, 'n');
        } else {
            // se fixed sau khi da sua csdl
            $this->alias = PostHelper::TitleVNtoEN($this->title) . "_" . PostHelper::id4slug($this->id_menu_detail, 'n');
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (!isset($this->id_parent) || ($this->id_parent == 0))
            $this->id_parent = null;
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MenuDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
