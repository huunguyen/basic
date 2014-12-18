<?php

/**
 * This is the model class for table "tbl_connections_page".
 *
 * The followings are the available columns in table 'tbl_connections_page':
 * @property string $id_connections
 * @property string $id_page
 * @property string $time_start
 * @property string $time_end
 */
class ConnectionsPage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConnectionsPage the static model class
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
		return 'tbl_connections_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_connections, id_page, time_start', 'required'),
			array('id_connections, id_page', 'length', 'max'=>10),
			array('time_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_connections, id_page, time_start, time_end', 'safe', 'on'=>'search'),
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
			'id_connections' => 'Id Connections',
			'id_page' => 'Id Page',
			'time_start' => 'Time Start',
			'time_end' => 'Time End',
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

		$criteria->compare('id_connections',$this->id_connections,true);
		$criteria->compare('id_page',$this->id_page,true);
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('time_end',$this->time_end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}