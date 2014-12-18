<?php

/**
 * This is the model class for table "tbl_image_type".
 *
 * The followings are the available columns in table 'tbl_image_type':
 * @property string $id_image_type
 * @property string $id_image
 * @property string $name
 * @property string $width
 * @property string $height
 * @property integer $products
 * @property integer $categories
 * @property integer $manufacturers
 * @property integer $suppliers
 *
 * The followings are the available model relations:
 * @property Image $idImage
 */
class ImageType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_image_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, width, height', 'required'),
			array('products, categories, manufacturers, suppliers', 'numerical', 'integerOnly'=>true),
			array('id_image, width, height', 'length', 'max'=>10),
			array('name', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_image_type, id_image, name, width, height, products, categories, manufacturers, suppliers', 'safe', 'on'=>'search'),
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
			'idImage' => array(self::BELONGS_TO, 'Image', 'id_image'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_image_type' => 'Id Image Type',
			'id_image' => 'Id Image',
			'name' => 'Name',
			'width' => 'Width',
			'height' => 'Height',
			'products' => 'Products',
			'categories' => 'Categories',
			'manufacturers' => 'Manufacturers',
			'suppliers' => 'Suppliers',
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

		$criteria->compare('id_image_type',$this->id_image_type,true);
		$criteria->compare('id_image',$this->id_image,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('products',$this->products);
		$criteria->compare('categories',$this->categories);
		$criteria->compare('manufacturers',$this->manufacturers);
		$criteria->compare('suppliers',$this->suppliers);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImageType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
