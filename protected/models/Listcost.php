<?php

/**
 * This is the model class for table "tbl_listcost".
 *
 * The followings are the available columns in table 'tbl_listcost':
 * @property integer $id_listcost
 * @property string $name
 * @property string $position
 * @property string $cost
 * @property string $ext
 * @property string $start_apply_time
 * @property string $oldcost
 * @property string $oldstart_apply_time
 * @property string $oldend_apply_time
 * @property string $salt
 * @property string $date_add
 * @property string $date_update
 * @property integer $id_user_add
 * @property integer $id_user_upd
 * @property string $status
 * @property string $categories
 */
class Listcost extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Listcost the static model class
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
		return 'tbl_listcost';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, position, cost, oldcost, salt, date_add, id_user_add', 'required'),
			array('id_user_add, id_user_upd', 'numerical', 'integerOnly'=>true),
			array('name, position, cost, oldcost, salt', 'length', 'max'=>128),
			array('ext', 'length', 'max'=>3),
			array('status', 'length', 'max'=>9),
			array('categories', 'length', 'max'=>6),
			array('start_apply_time, oldstart_apply_time, oldend_apply_time, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_listcost, name, position, cost, ext, start_apply_time, oldcost, oldstart_apply_time, oldend_apply_time, salt, date_add, date_update, id_user_add, id_user_upd, status, categories', 'safe', 'on'=>'search'),
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
			'id_listcost' => 'Id Listcost',
			'name' => 'Name',
			'position' => 'Position',
			'cost' => 'Cost',
			'ext' => 'Ext',
			'start_apply_time' => 'Start Apply Time',
			'oldcost' => 'Oldcost',
			'oldstart_apply_time' => 'Oldstart Apply Time',
			'oldend_apply_time' => 'Oldend Apply Time',
			'salt' => 'Salt',
			'date_add' => 'Date Add',
			'date_update' => 'Date Update',
			'id_user_add' => 'Id User Add',
			'id_user_upd' => 'Id User Upd',
			'status' => 'Status',
			'categories' => 'Categories',
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

		$criteria->compare('id_listcost',$this->id_listcost);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('ext',$this->ext,true);
		$criteria->compare('start_apply_time',$this->start_apply_time,true);
		$criteria->compare('oldcost',$this->oldcost,true);
		$criteria->compare('oldstart_apply_time',$this->oldstart_apply_time,true);
		$criteria->compare('oldend_apply_time',$this->oldend_apply_time,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('id_user_add',$this->id_user_add);
		$criteria->compare('id_user_upd',$this->id_user_upd);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('categories',$this->categories,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}