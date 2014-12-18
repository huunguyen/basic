<?php

/**
 * This is the model class for table "tbl_role".
 *
 * The followings are the available columns in table 'tbl_role':
 * @property string $id_profile
 * @property string $name
 * @property string $alias
 * @property string $level
 * @property string $description
 * @property string $salt
 * @property string $validation_key
 * @property string $date_add
 * @property string $date_upd
 * @property integer $active
 */
class Role extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_profile', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('id_profile, level', 'length', 'max'=>10),
			array('name, alias, salt, validation_key', 'length', 'max'=>45),
			array('description, date_add, date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_profile, name, alias, level, description, salt, validation_key, date_add, date_upd, active', 'safe', 'on'=>'search'),
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
			'id_profile' => 'Id Profile',
			'name' => 'Name',
			'alias' => 'Alias',
			'level' => 'Level',
			'description' => 'Description',
			'salt' => 'Salt',
			'validation_key' => 'Validation Key',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
			'active' => 'Active',
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

		$criteria->compare('id_profile',$this->id_profile,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('validation_key',$this->validation_key,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Role the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
