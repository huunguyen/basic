<?php

/**
 * This is the model class for table "tbl_menu".
 *
 * The followings are the available columns in table 'tbl_menu':
 * @property string $id_menu
 * @property string $id_store
 * @property string $id_supplier
 * @property string $id_manufacturer
 * @property integer $active
 * @property string $menu_type
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Store $idStore
 * @property Supplier $idSupplier
 * @property Manufacturer $idManufacturer
 * @property MenuDetail[] $menuDetails
 */
class Menu extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_store, title, description', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('id_store, id_supplier, id_manufacturer', 'length', 'max' => 10),
            array('menu_type', 'length', 'max' => 9),
            array('title, description', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_menu, id_store, id_supplier, id_manufacturer, active, menu_type, title, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
            'idSupplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
            'idManufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'id_manufacturer'),
            'menuDetails' => array(self::HAS_MANY, 'MenuDetail', 'id_menu'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_menu' => 'Mã menu',
            'id_store' => 'Mã Chi nhánh',
            'id_supplier' => 'Mã nhà cung cấp',
            'id_manufacturer' => 'Mã nhà sản xuất',
            'active' => 'Trạng thái',
            'menu_type' => 'Loại menu',
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
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

//        $criteria->compare('id_menu', $this->id_menu, true);
//        $criteria->compare('id_store', $this->id_store, true);
//        $criteria->compare('id_supplier', $this->id_supplier, true);
//        $criteria->compare('id_manufacturer', $this->id_manufacturer, true);
        $criteria->compare('active', $this->active);
//        $criteria->compare('menu_type', $this->menu_type, true);
//        $criteria->compare('title', $this->title, true);
//        $criteria->compare('description', $this->description, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_store, id_supplier, id_manufacturer, menu_type, title ASC';
        $sort->attributes = array(
            'id_store' => 'id_store',
            'id_supplier' => 'id_supplier',
            'id_manufacturer' => 'id_manufacturer',
            'menu_type' => 'menu_type',
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
    
public function beforeSave() {
        if (!isset($this->id_supplier) || ($this->id_supplier == 0))
            $this->id_supplier = null;
        if (!isset($this->id_manufacturer) || ($this->id_manufacturer == 0))
            $this->id_manufacturer = null;
        return parent::beforeSave();
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Menu the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
