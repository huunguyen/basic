<?php

/**
 * This is the model class for table "tbl_frontpage".
 *
 * The followings are the available columns in table 'tbl_frontpage':
 * @property integer $post_id
 * @property integer $ordering
 *
 * The followings are the available model relations:
 * @property TblPost $post
 */
class Frontpage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Frontpage the static model class
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
		return 'tbl_frontpage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id, ordering', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('post_id, ordering', 'safe', 'on'=>'search'),
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
			'post' => array(self::BELONGS_TO, 'TblPost', 'post_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => 'Post_id',
			'ordering' => 'Ordering',
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

		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('ordering',$this->ordering);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}