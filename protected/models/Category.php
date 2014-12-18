<?php

/**
 * This is the model class for table "tbl_category".
 *
 * The followings are the available columns in table 'tbl_category':
 * @property string $id_category
 * @property string $id_parent
 * @property integer $level_depth
 * @property integer $active
 * @property string $date_add
 * @property string $date_upd
 * @property string $position
 * @property integer $is_root_category
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Category $idParent
 * @property Category[] $categories
 * @property CategoryGroup[] $categoryGroups
 * @property CategoryProduct[] $categoryProducts
 * @property GroupReduction[] $groupReductions
 * @property MenuDetail[] $menuDetails
 * @property Post[] $posts
 * @property Product[] $products
 * @property Slider[] $sliders
 */
class Category extends CActiveRecord {

    const TYPE = "cat";

    public $old_img;
    public $img;
    public $thumbnail;
    public $parent_name;
    public $old_position;
    public $min_position;
    public $max_position;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_add, name', 'required'),
            array('level_depth, active, is_root_category', 'numerical', 'integerOnly' => true),
            array('id_parent, position', 'length', 'max' => 10),
            array('name, meta_title, meta_keywords, slug', 'length', 'max' => 45),
            array('date_upd, description, meta_description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_category, id_parent, level_depth, active, date_add, date_upd, position, is_root_category, name, description, meta_title, meta_keywords, meta_description, slug', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idParent' => array(self::BELONGS_TO, 'Category', 'id_parent'),
            'categories' => array(self::HAS_MANY, 'Category', 'id_parent'),
            'categoryGroups' => array(self::HAS_MANY, 'CategoryGroup', 'id_category'),
            'categoryProducts' => array(self::HAS_MANY, 'CategoryProduct', 'id_category'),
            'groupReductions' => array(self::HAS_MANY, 'GroupReduction', 'id_category'),
            'menuDetails' => array(self::HAS_MANY, 'MenuDetail', 'id_category'),
            'posts' => array(self::HAS_MANY, 'Post', 'id_category'),
            'products' => array(self::HAS_MANY, 'Product', 'id_category_default'),
            'sliders' => array(self::HAS_MANY, 'Slider', 'id_category'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_category' => 'Mã danh mục',
            'id_parent' => 'Mã cha',
            'level_depth' => 'Độ sâu tối đa',
            'active' => 'Trạng thái',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'position' => 'Vị trí',
            'is_root_category' => 'Là danh mục gốc',
            'name' => 'Tên danh mục',
            'description' => 'Mô tả',
            'meta_title' => 'Tựa Meta',
            'meta_keywords' => 'Từ khóa meta',
            'meta_description' => 'Mô tả meta',
            'slug' => 'mã slug',
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

        $criteria->compare('id_category', $this->id_category, true);
        $criteria->compare('id_parent', $this->id_parent, true);

        $criteria->with = array('idParent');
        $criteria->compare('idParent.name', $this->parent_name);

        $criteria->compare('level_depth', $this->level_depth);
        $criteria->compare('t.active', 1);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('is_root_category', $this->is_root_category);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('slug', $this->slug, true);

        $sort = new CSort;
        $sort->defaultOrder = 't.id_category, t.name ASC';
        $sort->attributes = array(
            't.id_category' => 't.id_category',
            't.name' => 't.name'
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

    public function searchByProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            //$criteria3->compare('idProduct.active', 1);
            $categoryproducts = CategoryProduct::model()->findAll($criteria3);
            foreach ($categoryproducts as $categoryproduct) {
                $values[] = $categoryproduct->id_category;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_category', $values);            
        //$criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_category, name ASC';
        $sort->attributes = array(
            'id_category' => 'id_category',
            'name' => 'name'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 10),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByNoProduct($id_product = null) {
          // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            //$criteria3->compare('idProduct.active', 1);
            $categoryproducts = CategoryProduct::model()->findAll($criteria3);
            foreach ($categoryproducts as $categoryproduct) {
                $values[] = $categoryproduct->id_category;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addNotInCondition('id_category', $values);            
        //$criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_category, name ASC';
        $sort->attributes = array(
            'id_category' => 'id_category',
            'name' => 'name'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 10),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );       
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->slug = PostHelper::TitleVNtoEN($this->name);
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if ($this->isNewRecord) {            
            $criteria = new CDbCriteria();
            $criteria->compare('active', true);
            $criteria->order = 'position DESC, id_category DESC';
            // process position here. find range position. 
            if (!empty($this->id_parent) || ($this->id_parent >= 1)) {
                $criteria->compare('id_parent', $this->id_parent, true);
            } else
                $criteria->addCondition("id_parent IS NULL");
            if (empty($this->position)) {
                if ($categories = self::model()->findAll($criteria)) {
                    foreach ($categories as $category) {
                        $this->position = ++$category->position;
                        break;
                    }
                } else
                    $this->position = 0;
            }
            else {
                $criteria->compare('position', $this->position, true);
                if ($categories = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->compare('active', true);
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_category ASC';
                    if (!empty($this->id_parent) || ($this->id_parent >= 1)) {
                        $criteria2->compare('id_parent', $this->id_parent, true);
                    } else
                        $criteria2->addCondition("id_parent IS NULL");
                    $categories2 = self::model()->findAll($criteria2);
                    foreach ($categories2 as $category2) {
                        $this->position = ++$category2->max_position;
                        break;
                    }
                }
            }
        } 
        else 
            {
            $criteria = new CDbCriteria();
            $criteria->compare('active', true);
            $criteria->order = 'position DESC, id_category ASC';
            if (($this->old_position != $this->position)) {
                if (!empty($this->id_parent) || ($this->id_parent >= 1)) {
                    $criteria->compare('position', $this->position, true);
                    $criteria->compare('id_parent', $this->id_parent, true);
                    //$criteria->compare('id_category', '<>'.$this->id_category);                    
                    if ($categories = self::model()->findAll($criteria)) {
                        $criteria2 = new CDbCriteria();
                        $criteria2->compare('active', true);
                        $criteria2->select = array('*', 'max(position) as max_position');
                        $criteria2->order = 'position DESC, id_category ASC';
                        $criteria2->compare('id_parent', $this->id_parent, true);
                        $categories2 = self::model()->findAll($criteria2);
                        foreach ($categories2 as $category2) {
                            $this->position = ++$category2->max_position;
                            break;
                        }
                    }
                } else {
                    $criteria->compare('position', $this->position, true);
                    $criteria->addCondition("id_parent IS NULL");
                    //$criteria->compare('id_category', '<>'.$this->id_category);
                    if ($categories = self::model()->findAll($criteria)) {
                        $criteria2 = new CDbCriteria();
                        $criteria2->compare('active', true);
                        $criteria2->select = array('*', 'max(position) as max_position');
                        $criteria2->order = 'position DESC, id_category ASC';
                        $criteria2->addCondition("id_parent IS NULL");
                        $categories2 = self::model()->findAll($criteria2);
                        foreach ($categories2 as $category2) {
                            $this->position = ++$category2->max_position;
                            break;
                        }
                    }
                }
            }
        }
        if (empty($this->meta_title))
            $this->meta_title .= ";" . PostHelper::removeVNtoEN($this->meta_title);
        return parent::beforeSave();
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_category, 'n');
        $this->updateByPk($this->id_category, array('slug' => $this->slug));

        return parent::afterSave();
    }

    public function afterFind() {
        if (!empty($this->id_parent) && ($this->id_parent > 0)) {
            $this->parent_name = $this->idParent->name;
        }

        $this->old_img = $this->img = ImageHelper::FindImageByPk(self::TYPE, $this->id_category);
        try {
            if ($this->img !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->img, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        $this->old_position = $this->position;
        return parent::afterFind();
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'common.extensions.behaviors.AutoTimestampBehavior',
            //You can optionally set the field name options here
            )
        );
    }

}
