<?php

/**
 * This is the model class for table "tbl_hot_deal_value".
 *
 * The followings are the available columns in table 'tbl_hot_deal_value':
 * @property string $id_hot_deal_value
 * @property string $id_hot_deal
 * @property string $custom_name
 * @property string $custom_value
 *
 * The followings are the available model relations:
 * @property HotDeal $idHotDeal
 */
class HotDealValue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_hot_deal_value';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_hot_deal', 'required'),
			array('id_hot_deal', 'length', 'max'=>10),
			array('custom_name, custom_value', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_hot_deal_value, id_hot_deal, custom_name, custom_value', 'safe', 'on'=>'search'),
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
			'idHotDeal' => array(self::BELONGS_TO, 'HotDeal', 'id_hot_deal'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_hot_deal_value' => 'Id Hot Deal Value',
			'id_hot_deal' => 'Id Hot Deal',
			'custom_name' => 'Custom Name',
			'custom_value' => 'Custom Value',
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

		$criteria->compare('id_hot_deal_value',$this->id_hot_deal_value,true);
		$criteria->compare('id_hot_deal',$this->id_hot_deal,true);
		$criteria->compare('custom_name',$this->custom_name,true);
		$criteria->compare('custom_value',$this->custom_value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HotDealValue the static model class
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
        $criteria = new CDbCriteria();
            $criteria->compare('id_hot_deal', $this->id_hot_deal);
            $criteria->compare('custom_name', $this->custom_name);
            $criteria->addNotInCondition('custom_value', self::string2array($this->custom_value));
            if ($old_models = self::model()->findAll($criteria)) {
                foreach ($old_models as $old_model) {
                    $old_model->delete();
                }
            }
        $models = array();
        foreach (self::string2array($this->custom_value) as $value) {
            $model = self::model()->findByAttributes(array('id_hot_deal' => $this->id_hot_deal, 'custom_name' => $this->custom_name, 'custom_value' => $value));

            //model is new, so create a copy with the keys set
            if (null === $model) {
                //we don't use clone $this as it can leave off behaviors and events
                $model = new self;
                $model->id_hot_deal = $this->id_hot_deal;
                $model->custom_name = $this->custom_name;
                $model->custom_value = $value;
            }
            $model->save(false);
            $models[] = $model;
        }        
        return $models;
    }
     public static function string2array($tags)
    {
        return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags)
    {
        return implode(', ',$tags);
    }
}
