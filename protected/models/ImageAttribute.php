<?php
/**
 * This is the model class for table "tbl_image_attribute".
 *
 * The followings are the available columns in table 'tbl_image_attribute':
 * @property string $id_image
 * @property string $id_attribute
 * @property integer $cover
 */
class ImageAttribute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_image_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_image, id_attribute', 'required'),
			array('cover', 'numerical', 'integerOnly'=>true),
			array('id_image, id_attribute', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_image, id_attribute, cover', 'safe', 'on'=>'search'),
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
                    'idAttribute' => array(self::BELONGS_TO, 'Attribute', 'id_attribute'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_image' => 'Id Image',
			'id_attribute' => 'Id Attribute',
			'cover' => 'Cover',
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

		$criteria->compare('id_image',$this->id_image,true);
		$criteria->compare('id_attribute',$this->id_attribute,true);
		$criteria->compare('cover',$this->cover);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImageAttribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
