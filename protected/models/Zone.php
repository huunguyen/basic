<?php

/**
 * This is the model class for table "tbl_zone".
 *
 * The followings are the available columns in table 'tbl_zone':
 * @property string $id_zone
 * @property string $id_city
 * @property string $name
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Carrier[] $tblCarriers
 * @property City $idCity
 */
class Zone extends CActiveRecord {

    public $nameCity;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_zone';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_city, name', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('id_city', 'length', 'max' => 10),
            array('name', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_zone, id_city, name, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
			'addresses' => array(self::HAS_MANY, 'Address', 'id_zone'),
			'tblCarriers' => array(self::MANY_MANY, 'Carrier', 'tbl_carrier_zone(id_zone, id_carrier)'),
			'deliveries' => array(self::HAS_MANY, 'Delivery', 'id_zone'),
			'idCity' => array(self::BELONGS_TO, 'City', 'id_city'),
		);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_zone' => 'Mã Khu Vực',
            'id_city' => 'Mã Thành Phố',
            'nameCity' => 'Tên Tỉnh | Thành Phố',
            'name' => 'Tên KV | Vùng',
            'active' => 'Kích Hoạt',
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

        $criteria->compare('id_zone', $this->id_zone, true);
        $criteria->compare('t.id_city', $this->id_city, true);
        $criteria->with = 'idCity';
        $criteria->compare('idCity.name', $this->nameCity, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.active', $this->active);

        $sort = new CSort;
        $sort->defaultOrder = 't.name, t.id_city ASC';
        $sort->attributes = array(
            'name' => 't.name',
            'idCity.name' => 'idCity.name',
            'active' => 't.active',
        );
        
        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)).'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this).'_page', 0),
            ),
                )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Zone the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
