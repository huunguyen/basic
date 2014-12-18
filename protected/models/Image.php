<?php

/**
 * This is the model class for table "tbl_image".
 *
 * The followings are the available columns in table 'tbl_image':
 * @property string $id_image
 * @property string $id_product
 * @property string $name
 * @property string $legend
 * @property integer $position
 * @property integer $cover
 * @property string $type
 * @property string $size
 * @property string $url
 *
 * The followings are the available model relations:
 * @property Product $idProduct
 * @property Attribute[] $tblAttributes
 * @property ImageType[] $imageTypes
 * @property ProductAttribute[] $tblProductAttributes
 */
class Image extends CActiveRecord {
    const TYPE = "pra";
    public $old_position;
    public $min_position;
    public $max_position;
    public $old_name;
    public $thumbnail;
    public $id_product_attribute;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_image';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_product, name', 'required'),
            array('position, cover', 'numerical', 'integerOnly' => true),
            array('id_product', 'length', 'max' => 10),
            array('name, legend, type, size, url', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_product_attribute, id_image, id_product, name, legend, position, cover, type, size, url', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'tblAttributes' => array(self::MANY_MANY, 'Attribute', 'tbl_image_attribute(id_image, id_attribute)'),
            'tblImageAttributes' => array(self::HAS_MANY, 'ImageAttribute', 'id_image'),
            'imageTypes' => array(self::HAS_MANY, 'ImageType', 'id_image'),
            'tblProductAttributeImages' => array(self::HAS_MANY, 'ProductAttributeImage', 'id_image'),
            'tblProductAttributeImagesWithSetCover' => array(self::HAS_MANY, 'ProductAttributeImage', 'id_image', 'on' => 'tblProductAttributeImagesWithSetCover.cover=1'),
            'tblProductAttributeImagesWithUnSetCover' => array(self::HAS_MANY, 'ProductAttributeImage', 'id_image', 'on' => 'tblProductAttributeImagesWithUnSetCover.cover=0'),
            'tblProductAttributes' => array(self::MANY_MANY, 'ProductAttribute', 'tbl_product_attribute_image(id_image, id_product_attribute)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_image' => 'Id Image',
            'id_product' => 'Id Product',
            'name' => 'Name',
            'legend' => 'Legend',
            'position' => 'Position',
            'cover' => 'Cover',
            'type' => 'Type',
            'size' => 'Size',
            'url' => 'Url',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_image', $this->id_image, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('legend', $this->legend, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('cover', $this->cover);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('url', $this->url, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
    public function searchByProductId($id = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id_image', $this->id_image, true);
        $criteria->with = array('idProduct');
        if (isset($id) && $model = Product::model()->findByPk($id)) {
            $criteria->compare('t.id_product', $model->id_product, true);
        } else
            $criteria->compare('t.id_product', $this->id_product, true);

        $criteria->compare('t.name', $this->name, true);

//        $criteria->together = true;
        $sort = new CSort;
        $sort->defaultOrder = 't.id_product, t.name,  idProduct.name ASC';
        $sort->attributes = array(
            'id_product' => 't.id_product',
            'name' => 't.name',
            'idProduct.name' => 'idProduct.name',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByNoProductAttributeId($id_product_attribute) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product_attribute)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 'id_product_attribute=:id_product_attribute';
            $criteria3->params = array(':id_product_attribute' => $id_product_attribute);
            $productattributeimages = ProductAttributeImage::model()->findAll($criteria3);
            foreach ($productattributeimages as $productattributeimage) {
                $values[] = $productattributeimage->id_image;
            }
        }

        $criteria = new CDbCriteria;  
        $model = ProductAttribute::model()->findByPk($id_product_attribute);
        $criteria->condition = 'id_product=:id_product';
        $criteria->params = array(
            ':id_product' => $model->id_product
                );
        $criteria->addNotInCondition('id_image', $values);

        $sort = new CSort;
        $sort->defaultOrder = 't.id_product, t.name ASC';
        $sort->attributes = array(
            'id_product' => 't.id_product',
            'name' => 't.name'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
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
    public function searchByProductAttributeId($id_product_attribute) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('t.id_image', $this->id_image, true);

        $criteria->with = 'tblProductAttributeImages';
        if (isset($id_product_attribute) && $model = ProductAttribute::model()->findByPk($id_product_attribute)) {
            $criteria->compare('tblProductAttributeImages.id_product_attribute', $id_product_attribute, true);
        }
        $criteria->together = true;
        $sort = new CSort;
        $sort->defaultOrder = 't.id_product, t.name ASC';
        $sort->attributes = array(
            'id_product' => 't.id_product',
            'name' => 't.name'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Image the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_product DESC';
            $criteria->compare('id_product', $this->id_product, true);
            // process position here. find range position. 
            $criteria->compare('position', $this->position, true);
            if ($group = self::model()->findAll($criteria)) {
                $criteria2 = new CDbCriteria();
                $criteria2->select = array('*', 'max(position) as max_position');
                $criteria2->compare('id_product', $this->id_product, true);
                $criteria2->order = 'position DESC, id_product ASC';
                $groups2 = self::model()->findAll($criteria2);
                foreach ($groups2 as $group2) {
                    $this->position = ++$group2->max_position;
                    break;
                }
            }
        } else {
            if (($this->old_position != $this->position)) {
                $criteria = new CDbCriteria();
                $criteria->order = 'position DESC, id_product ASC';
                $criteria->compare('id_product', $this->id_product, true);
                $criteria->compare('position', $this->position, true);
                if ($group = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->compare('id_product', $this->id_product, true);
                    $criteria2->order = 'position DESC, id_product ASC';
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

        $this->old_name = $this->name = ImageHelper::FindImageByPk(ProductAttribute::TYPE, $this->id_image);
        try {
            if ($this->name !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . ProductAttribute::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->name, ProductAttribute::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        return parent::afterFind();
    }

    public function updateRecord() {
        $model = self::model()->findByPk(array('id_image' => $this->id_image));
        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_image = $this->id_image;
        }
        $model->name = $this->id_image . "." . ImageHelper::FilenameExtension($this->name);
        $model->url .= DIRECTORY_SEPARATOR . $model->name;
        $model->save(false);
        return $model;
    }

    public function updateCover() {
        $model = self::model()->findByPk(array('id_image' => $this->id_image));
        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_image = $this->id_image;
        }
        $model->cover = $this->cover;
        $criteria = new CDbCriteria;
        $criteria->AddCondition('id_image <>' . $this->id_image);
        $criteria->compare('id_product', $this->id_product);
        $criteria->compare('cover', 1);
        if ($models = Image::model()->findAll($criteria)) {
            foreach ($models as $value) {
                $value->updateByPk($value->id_image, array('cover' => 0));
            }
        }
        return $model->save(false);
    }

}
