<?php

/**
 * This is the model class for table "tbl_banner".
 *
 * The followings are the available columns in table 'tbl_banner':
 * @property string $id_banner
 * @property integer $id_user_add
 * @property integer $id_user_upd
 * @property integer $id_store
 * @property string $title
 * @property string $type
 * @property string $date_add
 * @property string $date_upd
 * @property string $content
 */
class Banner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banner the static model class
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
		return 'tbl_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
			array('id_user_add, id_user_upd, id_store', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>10),
			array('title, date_add, date_upd', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_banner, id_user_add, id_user_upd, id_store, title, type, date_add, date_upd, content', 'safe', 'on'=>'search'),
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
			'id_banner' => 'Id Banner',
			'id_user_add' => 'Id User Add',
			'id_user_upd' => 'Id User Upd',
			'id_store' => 'Id Store',
			'title' => 'Title',
			'type' => 'Type',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
			'content' => 'Content',
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

		$criteria->compare('id_banner',$this->id_banner,true);
		$criteria->compare('id_user_add',$this->id_user_add);
		$criteria->compare('id_user_upd',$this->id_user_upd);
		$criteria->compare('id_store',$this->id_store);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}