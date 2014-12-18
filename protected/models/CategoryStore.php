<?php

/**
 * This is the model class for table "tbl_category_store".
 *
 * The followings are the available columns in table 'tbl_category_store':
 * @property string $id_category
 * @property string $id_store
 * @property string $position
 */
class CategoryStore extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CategoryStore the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_category_store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_category, id_store', 'required'),
			array('id_category, id_store, position', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_category, id_store, position', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_category' => 'Id Category',
			'id_store' => 'Id Store',
			'position' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}