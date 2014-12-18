<?php

/**
 * This is the model class for table "tbl_category_group".
 *
 * The followings are the available columns in table 'tbl_category_group':
 * @property string $id_category
 * @property string $id_group
 *
 * The followings are the available model relations:
 * @property Category $idCategory
 * @property Group $idGroup
 */
class CategoryGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_category_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_category, id_group', 'required'),
			array('id_category, id_group', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_category, id_group', 'safe', 'on'=>'search'),
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
			'idCategory' => array(self::BELONGS_TO, 'Category', 'id_category'),
			'idGroup' => array(self::BELONGS_TO, 'Group', 'id_group'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_category' => 'Id Category',
			'id_group' => 'Id Group',
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

		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('id_group',$this->id_group,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
