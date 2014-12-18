<?php

/**
 * This is the model class for table "tbl_category_product".
 *
 * The followings are the available columns in table 'tbl_category_product':
 * @property string $id_category
 * @property string $id_product
 * @property string $position
 *
 * The followings are the available model relations:
 * @property Category $idCategory
 * @property Product $idProduct
 */
class CategoryProduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_category_product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_category, id_product', 'required'),
			array('id_category, id_product, position', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_category, id_product, position', 'safe', 'on'=>'search'),
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
			'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_category' => 'Mã phân mục',
			'id_product' => 'Mã sản phẩm',
			'position' => 'Vị trí',
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
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategoryProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
          /**
     * Uses the primary keys set on a new record to either create or update
     * a record with those keys to have the last_access value set to the same value
     * as the current unsaved model.
     *
     * Returns the model with the updated last_access. Success can be checked by
     * examining the isNewRecord property.
     *
     * IMPORTANT: This method does not modify the existing model.
     * */
    public function updateRecord() {
        $model = self::model()->findByAttributes(array('id_category' => $this->id_category, 'id_product' => $this->id_product));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_category = $this->id_category;
            $model->id_product = $this->id_product;
        }
        $model->save(false);
        return $model;
    }
}
