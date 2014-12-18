<?php

/**
 * This is the model class for table "tbl_zone_district".
 *
 * The followings are the available columns in table 'tbl_zone_district':
 * @property string $id_zone_district
 * @property string $id_zone
 * @property string $id_district
 *
 * The followings are the available model relations:
 * @property District $idZoneDistrict
 * @property Zone $idZone
 */
class ZoneDistrict extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_zone_district';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_zone, id_district', 'required'),
			array('id_zone, id_district', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_zone_district, id_zone, id_district', 'safe', 'on'=>'search'),
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
			'idZoneDistrict' => array(self::BELONGS_TO, 'District', 'id_zone_district'),
			'idZone' => array(self::BELONGS_TO, 'Zone', 'id_zone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_zone_district' => 'Id Zone District',
			'id_zone' => 'Id Zone',
			'id_district' => 'Id District',
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

		$criteria->compare('id_zone_district',$this->id_zone_district,true);
		$criteria->compare('id_zone',$this->id_zone,true);
		$criteria->compare('id_district',$this->id_district,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ZoneDistrict the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
     * Uses the primary keys set on a new record to either create or update
     * a record with those keys to have the last_access value set to the same value
     * as the current unsaved model.
     *
     * Returns the model with the updated last_access. Success can be checked by
     * examining the isNewRecord property.
     *
     * IMPORTANT: This method does not modify the existing model.
     * */
    public function updateRecord() {
        $model = self::model()->findByAttributes(array('id_zone' => $this->id_zone, 'id_district' => $this->id_district));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_zone = $this->id_zone;
            $model->id_district = $this->id_district;
        }
        $model->save(false);
        return $model;
    }
}
