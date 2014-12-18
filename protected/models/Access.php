<?php

/**
 * This is the model class for table "tbl_access".
 *
 * The followings are the available columns in table 'tbl_access':
 * @property string $id_profile
 * @property string $id_tab
 * @property integer $view
 * @property integer $add
 * @property integer $edit
 * @property integer $delete
 */
class Access extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Access the static model class
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
		return 'tbl_access';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_profile, id_tab, view, add, edit, delete', 'required'),
			array('view, add, edit, delete', 'numerical', 'integerOnly'=>true),
			array('id_profile, id_tab', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_profile, id_tab, view, add, edit, delete', 'safe', 'on'=>'search'),
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
			'id_tab' => 'Id Tab',
			'view' => 'View',
			'add' => 'Add',
			'edit' => 'Edit',
			'delete' => 'Delete',
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

		$criteria->compare('id_profile',$this->id_profile,true);
		$criteria->compare('id_tab',$this->id_tab,true);
		$criteria->compare('view',$this->view);
		$criteria->compare('add',$this->add);
		$criteria->compare('edit',$this->edit);
		$criteria->compare('delete',$this->delete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}