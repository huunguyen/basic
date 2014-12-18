<?php

/**
 * This is the model class for table "tbl_action".
 *
 * The followings are the available columns in table 'tbl_action':
 * @property string $id_action
 * @property string $name
 * @property string $action_type
 * @property string $id_template_email
 * @property string $url
 */
class Action extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Action the static model class
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
		return 'tbl_action';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_template_email', 'required'),
			array('name, action_type, url', 'length', 'max'=>45),
			array('id_template_email', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_action, name, action_type, id_template_email, url', 'safe', 'on'=>'search'),
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
			'id_action' => 'Id Action',
			'name' => 'Name',
			'action_type' => 'Action Type',
			'id_template_email' => 'Id Template Email',
			'url' => 'Url',
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

		$criteria->compare('id_action',$this->id_action,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('action_type',$this->action_type,true);
		$criteria->compare('id_template_email',$this->id_template_email,true);
		$criteria->compare('url',$this->url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}