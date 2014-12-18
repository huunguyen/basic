<?php

/**
 * This is the model class for table "tbl_city".
 *
 * The followings are the available columns in table 'tbl_city':
 * @property string $id_city
 * @property string $id_country
 * @property string $name
 * @property integer $style
 * @property string $iso_code
 * @property integer $active
 * @property string $call_prefix
 * @property string $date_add
 * @property string $date_upd
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Country $idCountry
 * @property Store[] $stores
 * @property Zone[] $zones
 */
class City extends CActiveRecord
{
    public $style_name;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_country, name, iso_code, call_prefix', 'required'),
			array('style, active', 'numerical', 'integerOnly'=>true),
			array('id_country, call_prefix', 'length', 'max'=>10),
			array('name', 'length', 'max'=>64),
			array('iso_code', 'length', 'max'=>7),
			array('slug', 'length', 'max'=>45),
			array('date_add, date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_city, id_country, name, style, iso_code, active, call_prefix, date_add, date_upd, slug', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'id_city'),
			'idCountry' => array(self::BELONGS_TO, 'Country', 'id_country'),
			'districts' => array(self::HAS_MANY, 'District', 'id_city'),
			'stores' => array(self::HAS_MANY, 'Store', 'id_city'),
			'zones' => array(self::HAS_MANY, 'Zone', 'id_city'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_city' => 'Mã thành phố | Tỉnh Thành',
			'id_country' => 'Mã nước',
			'name' => 'Tên',
			'style' => 'Vùng miền Việt nam',
			'iso_code' => 'Mã quốc tế',
			'active' => 'Trạng thái',
			'call_prefix' => 'Mã bưu điện',
			'date_add' => 'Ngày tạo',
			'date_upd' => 'Ngày cập nhật',
			'slug' => 'chuổi',
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

		$criteria->compare('id_city',$this->id_city,true);
		$criteria->compare('id_country',$this->id_country,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('style',$this->style);
		$criteria->compare('iso_code',$this->iso_code,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('call_prefix',$this->call_prefix,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('slug',$this->slug,true);

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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function afterFind() {
            $this->style_name = Lookup::item('TypeCity', $this->style);
            return parent::afterFind();
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
