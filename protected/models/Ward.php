<?php

/**
 * This is the model class for table "tbl_ward".
 *
 * The followings are the available columns in table 'tbl_ward':
 * @property string $id_ward
 * @property string $name
 * @property string $iso_code
 * @property string $id_district
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property District $idDistrict
 */
class Ward extends CActiveRecord
{
    public $style;
    public $id_city;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_ward';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, id_district', 'required'),
			array('id_ward, id_district', 'length', 'max'=>10),
			array('name, date_upd', 'length', 'max'=>45),
			array('iso_code', 'length', 'max'=>7),
			array('style, id_city, date_add', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('style, id_city, id_ward, name, iso_code, id_district, date_add, date_upd', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idDistrict' => array(self::BELONGS_TO, 'District', 'id_district'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ward' => 'Mã Phường | Xã',
			'name' => 'Tên',
			'iso_code' => 'Mã quốc tế',
			'id_district' => 'Mã Quận | Huyện',
			'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
                    'style' => 'Vùng | Miền Việt Nam',
                    'id_city' => 'Mã Tỉnh | Thành phố'
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_ward',$this->id_ward,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('iso_code',$this->iso_code,true);
		$criteria->compare('id_district',$this->id_district,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

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
        
public function beforeSave() {
        if ((!isset($this->iso_code) || ($this->iso_code == "")) && ($city = City::model()->findByPk($this->id_city))) {
            $this->iso_code = $city->iso_code;
        }
        elseif ((!isset($this->iso_code) || ($this->iso_code == "")) && ($district = District::model()->findByPk($this->id_district))) {
            $this->iso_code = $district->iso_code;
        }
        return parent::beforeSave();
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ward the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
