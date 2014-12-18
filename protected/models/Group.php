<?php

/**
 * This is the model class for table "tbl_group".
 *
 * The followings are the available columns in table 'tbl_group':
 * @property string $id_group
 * @property string $reduction
 * @property integer $price_display_method
 * @property integer $show_prices
 * @property string $date_add
 * @property string $date_upd
 * @property string $name
 */
class Group extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_add', 'required'),
			array('price_display_method, show_prices', 'numerical', 'integerOnly'=>true),
			array('reduction', 'length', 'max'=>17),
			array('name', 'length', 'max'=>45),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_group, reduction, price_display_method, show_prices, date_add, date_upd, name', 'safe', 'on'=>'search'),
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
			'id_group' => 'Id Group',
			'reduction' => 'Reduction',
			'price_display_method' => 'Price Display Method',
			'show_prices' => 'Show Prices',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
			'name' => 'Name',
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

		$criteria->compare('id_group',$this->id_group,true);
		$criteria->compare('reduction',$this->reduction,true);
		$criteria->compare('price_display_method',$this->price_display_method);
		$criteria->compare('show_prices',$this->show_prices);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Group the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
