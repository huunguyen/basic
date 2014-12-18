<?php

/**
 * This is the model class for table "tbl_answer".
 *
 * The followings are the available columns in table 'tbl_answer':
 * @property string $id_answer
 * @property string $id_post
 * @property string $id_parent
 * @property string $content
 * @property string $attach_file
 * @property string $create_time
 * @property string $update_time
 * @property string $id_user_add
 * @property string $id_user_upd
 * @property string $status
 */
class Answer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Answer the static model class
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
		return 'tbl_answer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_post, id_parent, content, id_user_add, id_user_upd', 'required'),
			array('id_post, id_parent, id_user_add, id_user_upd', 'length', 'max'=>10),
			array('status', 'length', 'max'=>7),
			array('attach_file, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_answer, id_post, id_parent, content, attach_file, create_time, update_time, id_user_add, id_user_upd, status', 'safe', 'on'=>'search'),
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
			'id_answer' => 'Id Answer',
			'id_post' => 'Id Post',
			'id_parent' => 'Id Parent',
			'content' => 'Content',
			'attach_file' => 'Attach File',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'id_user_add' => 'Id User Add',
			'id_user_upd' => 'Id User Upd',
			'status' => 'Status',
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

		$criteria->compare('id_answer',$this->id_answer,true);
		$criteria->compare('id_post',$this->id_post,true);
		$criteria->compare('id_parent',$this->id_parent,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('attach_file',$this->attach_file,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('id_user_add',$this->id_user_add,true);
		$criteria->compare('id_user_upd',$this->id_user_upd,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}