<?php

/**
 * This is the model class for table "tbl_books_banner".
 *
 * The followings are the available columns in table 'tbl_books_banner':
 * @property string $id_books_banner
 * @property string $id_banner
 * @property string $id_books
 * @property string $id_listcost
 * @property string $name
 * @property string $listcost
 * @property string $date_start_books
 * @property string $dateend_books
 * @property string $cost
 * @property string $position
 */
class BooksBanner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BooksBanner the static model class
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
		return 'tbl_books_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_banner, id_books, id_listcost, date_start_books, dateend_books', 'required'),
			array('id_banner, id_books, id_listcost', 'length', 'max'=>10),
			array('name, cost, position', 'length', 'max'=>128),
			array('listcost', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_books_banner, id_banner, id_books, id_listcost, name, listcost, date_start_books, dateend_books, cost, position', 'safe', 'on'=>'search'),
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
			'id_books_banner' => 'Id Books Banner',
			'id_banner' => 'Id Banner',
			'id_books' => 'Id Books',
			'id_listcost' => 'Id Listcost',
			'name' => 'Name',
			'listcost' => 'Listcost',
			'date_start_books' => 'Date Start Books',
			'dateend_books' => 'Dateend Books',
			'cost' => 'Cost',
			'position' => 'Position',
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

		$criteria->compare('id_books_banner',$this->id_books_banner,true);
		$criteria->compare('id_banner',$this->id_banner,true);
		$criteria->compare('id_books',$this->id_books,true);
		$criteria->compare('id_listcost',$this->id_listcost,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('listcost',$this->listcost,true);
		$criteria->compare('date_start_books',$this->date_start_books,true);
		$criteria->compare('dateend_books',$this->dateend_books,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}