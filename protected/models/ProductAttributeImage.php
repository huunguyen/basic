<?php

/**
 * This is the model class for table "tbl_product_attribute_image".
 *
 * The followings are the available columns in table 'tbl_product_attribute_image':
 * @property string $id_product_attribute
 * @property string $id_image
 * @property integer $cover
 */
class ProductAttributeImage extends CActiveRecord
{
        public $old_position;
    public $min_position;
    public $max_position;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_product_attribute_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product_attribute, id_image', 'required'),
			array('cover', 'numerical', 'integerOnly'=>true),
			array('id_product_attribute, id_image, position', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product_attribute, id_image, cover, position', 'safe', 'on'=>'search'),
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
                    'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product_attribute' => 'Mã Thuộc Tính Sản Phẩm',
			'id_image' => 'Mã Ảnh',
			'cover' => 'Ảnh Bìa',
			'position' => 'Vị Trí',
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

		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('id_image',$this->id_image,true);
		$criteria->compare('cover',$this->cover);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductAttributeImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_product_attribute DESC';
            $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
            // process position here. find range position. 
            $criteria->compare('position', $this->position, true);
            if ($group = self::model()->findAll($criteria)) {
                $criteria2 = new CDbCriteria();
                $criteria2->select = array('*', 'max(position) as max_position');
                $criteria2->compare('id_product_attribute', $this->id_product_attribute, true);
                $criteria2->order = 'position DESC, id_product_attribute ASC';
                $groups2 = self::model()->findAll($criteria2);
                foreach ($groups2 as $group2) {
                    $this->position = ++$group2->max_position;
                    break;
                }
            }
        } else {
            if (($this->old_position != $this->position)) {
                $criteria = new CDbCriteria();
                $criteria->order = 'position DESC, id_product_attribute ASC';
                $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
                $criteria->compare('position', $this->position, true);
                if ($group = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->compare('id_product_attribute', $this->id_product_attribute, true);
                    $criteria2->order = 'position DESC, id_product_attribute ASC';
                    $groups2 = self::model()->findAll($criteria2);
                    foreach ($groups2 as $group2) {
                        $this->position = ++$group2->max_position;
                        break;
                    }
                }
            }
        }
        return parent::beforeSave();
    }
    public function afterFind() {
        $this->old_position = $this->position;        
        return parent::afterFind();
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
        $model = self::model()->findByPk(array('id_image' => $this->id_image, 'id_product_attribute' => $this->id_product_attribute));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_image = $this->id_image;
            $model->id_product_attribute = $this->id_product_attribute;
        }
        $model->save(false);
        return $model;
    }
    
    public function updateCover() {
        $model = self::model()->findByPk(array('id_image' => $this->id_image, 'id_product_attribute' => $this->id_product_attribute));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_image = $this->id_image;  
            $model->id_product_attribute = $this->id_product_attribute;  
        }
        $model->cover = $this->cover;
        $criteria = new CDbCriteria;
        $criteria->compare('id_product_attribute', $this->id_product_attribute);
        $criteria->compare('cover', 1);
        if($models = ProductAttributeImage::model()->findAll($criteria)) {
            foreach ($models as $value) {
                $value->updateByPk(array('id_image' => $value->id_image, 'id_product_attribute' => $value->id_product_attribute), array('cover'=>0));
            }
        } 
        return $model->save(false);
    }
}
