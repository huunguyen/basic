<?php

/**
 * This is the model class for table "tbl_group_reduction".
 *
 * The followings are the available columns in table 'tbl_group_reduction':
 * @property integer $id_group_reduction
 * @property string $id_group
 * @property string $id_category
 * @property string $reduction
 */
class GroupReduction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_group_reduction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_group, id_category, reduction', 'required'),
			array('id_group, id_category', 'length', 'max'=>10),
			array('reduction', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_group_reduction, id_group, id_category, reduction', 'safe', 'on'=>'search'),
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
			'id_group_reduction' => 'Id Group Reduction',
			'id_group' => 'Id Group',
			'id_category' => 'Id Category',
			'reduction' => 'Reduction',
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

		$criteria->compare('id_group_reduction',$this->id_group_reduction);
		$criteria->compare('id_group',$this->id_group,true);
		$criteria->compare('id_category',$this->id_category,true);
		$criteria->compare('reduction',$this->reduction,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupReduction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
