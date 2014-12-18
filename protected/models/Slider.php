<?php

/**
 * This is the model class for table "tbl_slider".
 *
 * The followings are the available columns in table 'tbl_slider':
 * @property string $id_slider
 * @property string $id_supplier
 * @property string $id_category
 * @property string $id_manufacturer
 * @property integer $active
 * @property string $height
 * @property string $width
 * @property string $fill
 * @property string $duration
 * @property integer $auto
 * @property integer $continuous
 * @property integer $controls
 *
 * The followings are the available model relations:
 * @property Category $idCategory
 * @property Manufacturer $idManufacturer
 * @property Supplier $idSupplier
 * @property SliderDetail[] $sliderDetails
 * @property StoreSlider[] $storeSliders
 */
class Slider extends CActiveRecord {
    public $force = false;
    
    public $foradv = false;
    public $zoneadv;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_slider';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('height, width', 'required'),
            array('active, auto, continuous, controls', 'numerical', 'integerOnly' => true),
            array('id_supplier, id_category, id_manufacturer, height, width, duration', 'length', 'max' => 10),
            array('fill', 'length', 'max' => 7),
            // The following rule is used by search().
            array('zoneadv', 'safe'),
            // @todo Please remove those attributes that should not be searched.
            array('zoneadv, id_slider, id_supplier, id_category, id_manufacturer, active, height, width, fill, duration, auto, continuous, controls', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idCategory' => array(self::BELONGS_TO, 'Category', 'id_category'),
            'idManufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'id_manufacturer'),
            'idSupplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
            'sliderDetails' => array(self::HAS_MANY, 'SliderDetail', 'id_slider'),
            'storeSliders' => array(self::HAS_MANY, 'StoreSlider', 'id_slider'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_slider' => 'Mã trình diễn',
            'id_supplier' => 'Mã nhà cung cấp',
            'id_category' => 'Mã danh mục',
            'id_manufacturer' => 'Mã nhà sản xuất',
            'active' => 'Trạng thái',
            'height' => 'Chiều cao',
            'width' => 'Chiều rộng',
            'fill' => 'Dạng hiển thị',
            'duration' => 'TG hiển thị',
            'auto' => 'Chế độ từ động',
            'continuous' => 'Tiếp diễn',
            'controls' => 'Điều khiển',
            'zoneadv' => 'Khu vực Quảng cáo',
            'foradv' => 'Dành cho Quảng cáo'
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

        $criteria->compare('id_slider', $this->id_slider, true);
        $criteria->compare('id_supplier', $this->id_supplier, true);
        $criteria->compare('id_category', $this->id_category, true);
        $criteria->compare('id_manufacturer', $this->id_manufacturer, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('height', $this->height, true);
        $criteria->compare('width', $this->width, true);
        $criteria->compare('fill', $this->fill, true);
        $criteria->compare('duration', $this->duration, true);
        $criteria->compare('auto', $this->auto);
        $criteria->compare('continuous', $this->continuous);
        $criteria->compare('controls', $this->controls);

        $sort = new CSort;
        $sort->defaultOrder = 'id_supplier, id_category, id_manufacturer ASC';
        $sort->attributes = array(
            'id_supplier' => 'id_supplier',
            'id_category' => 'id_category',
            'id_manufacturer' => 'id_manufacturer',
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
        //force = true. this slider belong to main site
        if($this->force){
            $flag = false;
            $this->id_supplier = $this->id_category = $this->id_manufacturer = null;
        }
        elseif (!isset($this->id_supplier) && !isset($this->id_category) && !isset($this->id_manufacturer)) $flag = true;
        elseif ( ($this->id_supplier == 0) && ($this->id_category == 0) && ($this->id_manufacturer == 0) ) $flag = true;
        else $flag = false;
            
        if(!$this->force && $flag){
            $this->addError('id_supplier', 'Lỗi xảy ra do bạn nhập liệu không đúng');
            $this->addError('id_category', 'Lỗi xảy ra do bạn nhập liệu không đúng');
            $this->addError('id_manufacturer', 'Lỗi xảy ra do bạn nhập liệu không đúng');
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (!isset($this->id_supplier) || ($this->id_supplier == 0))
            $this->id_supplier = null;
        if (!isset($this->id_category) || ($this->id_category == 0))
            $this->id_category = null;
        if (!isset($this->id_manufacturer) || ($this->id_manufacturer == 0))
            $this->id_manufacturer = null;
        return parent::beforeSave();
    }
    
    public function afterSave() {
        $sliderstore = StoreSlider::model()->findByAttributes(array('id_store'=>Config::ID_STORE, 'id_slider'=>  $this->getPrimaryKey()));
        if(($this->force) && ($sliderstore==null)){
            $sliderstore = new StoreSlider;
            $sliderstore->id_store = Config::ID_STORE;
            $sliderstore->id_slider = $this->getPrimaryKey();
            $sliderstore->zone = $this->zoneadv;
            $sliderstore->updateRecord();
        }
        else {
            $sliderstore->zone = $this->zoneadv;
            $sliderstore->updateRecord();
        }
        //dump($sliderstore);exit();
        if((!$this->force) && ($sliderstore!=null)){
            $sliderstore->delete();
        }
        return parent::afterSave();
    } 
    
public function afterFind() {
        $sliderstore = StoreSlider::model()->findByAttributes(array('id_store'=>Config::ID_STORE, 'id_slider'=>  $this->getPrimaryKey()));
        if($sliderstore!=null){
            $this->foradv = true;
            $this->force = true;
            $this->zoneadv = $sliderstore->zone;
        }
        return parent::afterFind();
    } 
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Slider the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
