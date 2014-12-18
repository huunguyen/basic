<?php

/**
 * This is the model class for table "tbl_advise".
 *
 * The followings are the available columns in table 'tbl_advise':
 * @property string $id_advise
 * @property string $name
 * @property string $style
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property AdviseValue[] $adviseValues
 * @property ProductAdvise[] $productAdvises
 */
class Advise extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_advise';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, date_add', 'required'),
			array('name', 'length', 'max'=>128),
			array('style', 'length', 'max'=>45),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_advise, name, style, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'adviseValues' => array(self::HAS_MANY, 'AdviseValue', 'id_advise'),
			'productAdvises' => array(self::HAS_MANY, 'ProductAdvise', 'id_advise'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_advise' => 'Id Advise',
			'name' => 'Name',
			'style' => 'Style',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
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

		$criteria->compare('id_advise',$this->id_advise,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('style',$this->style,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advise the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
