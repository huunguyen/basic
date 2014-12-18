<?php

/**
 * This is the model class for table "tbl_district".
 *
 * The followings are the available columns in table 'tbl_district':
 * @property string $id_district
 * @property string $name
 * @property string $id_city
 * @property string $iso_code
 * @property string $date_add
 * @property string $date_upd
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property City $idCity
 * @property Ward[] $wards
 * @property ZoneDistrict $zoneDistrict
 */
class District extends CActiveRecord {

    public $style;
    public $pre_name;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_district';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, id_city', 'required'),
            array('name, slug', 'length', 'max' => 45),
            array('id_city', 'length', 'max' => 10),
            array('iso_code', 'length', 'max' => 7),
            array('pre_name, style, date_add, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('pre_name, style, id_district, name, id_city, iso_code, date_add, date_upd, slug', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idCity' => array(self::BELONGS_TO, 'City', 'id_city'),
            'wards' => array(self::HAS_MANY, 'Ward', 'id_district'),
            'zoneDistrict' => array(self::HAS_ONE, 'ZoneDistrict', 'id_zone_district'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_district' => 'Mã Quận | Huyện',
            'name' => 'Tên',
            'id_city' => 'Mã thành phố',
            'iso_code' => 'Mã quốc tế',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'slug' => 'Slug',
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

        $criteria->compare('id_district', $this->id_district, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('id_city', $this->id_city, true);
        $criteria->compare('iso_code', $this->iso_code, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('slug', $this->slug, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, date_add ASC';
        $sort->attributes = array(
            'name' => 'name',
            'date_add' => 'date_add'
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
        if ($city = City::model()->findByPk($this->id_city)) {
            $this->slug = PostHelper::TitleVNtoEN($city->name . "_" . $this->name);
        } else
            $this->slug = PostHelper::TitleVNtoEN($this->name);
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if ((!isset($this->iso_code) || ($this->iso_code == "")) && ($city = City::model()->findByPk($this->id_city))) {
            $this->iso_code = $city->iso_code;
        }
        return parent::beforeSave();
    }
    
    public function afterSave() {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        $criteria->compare('id_city', $this->id_city, true);
        $zone = Zone::model()->find($criteria);
        if($zone==null){
            $zone = new Zone;
            $zone->name = $this->name;
            $zone->id_city = $this->id_city;
            $zone->active = 1;
            $zone->save(false);
            
        }
        
        $zonedist = new ZoneDistrict;
        $zonedist->id_zone = $zone->getPrimaryKey();
        $zonedist->id_district = $this->getPrimaryKey();
        $zonedist->updateRecord();
        return parent::afterSave();
    }
    public function afterFind() {
        if($city = City::model()->findByPk($this->id_city)){
            $this->pre_name = $city->name."_".$this->name;
        }
        else $this->pre_name = $this->name."_".$this->name;
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return District the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'common.extensions.behaviors.AutoTimestampBehavior',
            //You can optionally set the field name options here
            )
        );
    }

}
