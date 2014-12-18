<?php

/**
 * This is the model class for table "tbl_store_slider".
 *
 * The followings are the available columns in table 'tbl_store_slider':
 * @property string $id_store_slider
 * @property string $id_store
 * @property string $id_slider
 * @property string $zone
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Slider $idSlider
 * @property Store $idStore
 */
class StoreSlider extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_store_slider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_store, id_slider', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('id_store, id_slider', 'length', 'max'=>10),
			array('zone', 'length', 'max'=>128),
                    array('zone', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_store_slider, id_store, id_slider, zone, active', 'safe', 'on'=>'search'),
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
			'idSlider' => array(self::BELONGS_TO, 'Slider', 'id_slider'),
			'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_store_slider' => 'Mã Trình Diễn Quảng Cáo',
			'id_store' => 'Mã chi nhánh',
			'id_slider' => 'Mã trình diễn',
			'zone' => 'Khu vực Trình diễn',
			'active' => 'Trạng thái',
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

		$criteria->compare('id_store_slider',$this->id_store_slider,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('id_slider',$this->id_slider,true);
		$criteria->compare('zone',$this->zone,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StoreSlider the static model class
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
        $model = self::model()->findByAttributes(array('id_store' => $this->id_store, 'id_slider' => $this->id_slider));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_store = $this->id_store;
            $model->id_slider = $this->id_slider;            
        }
        $model->zone = $this->zone;
        $model->save(false);
        return $model;
    }
}
