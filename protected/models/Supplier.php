<?php

/**
 * This is the model class for table "tbl_supplier".
 *
 * The followings are the available columns in table 'tbl_supplier':
 * @property string $id_supplier
 * @property string $name
 * @property string $date_add
 * @property string $date_upd
 * @property integer $active
 * @property string $description
 * @property string $description_short
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $slug
 * @property string $logo
 * @property string $address1
 * @property string $address2
 * @property string $latitude
 * @property string $longitude
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Menu[] $menus
 * @property Product[] $products
 * @property ProductSupplier[] $productSuppliers
 * @property Slider[] $sliders
 * @property SupplyOrder[] $supplyOrders
 */
class Supplier extends CActiveRecord {

    const TYPE = "sup";

    public $old_logo;
    public $thumbnail;
    
    public $certificate;
    public $old_certificate;
    public $cer_thumbnail;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_supplier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, date_add, address1', 'required'),
            array('logo', 'required', 'on' => 'create'),
            //array('logo', 'file', 'types' => 'jpeg, jpg, gif, png', 'allowEmpty' => false, 'maxSize'=>1024 * 1024 * 2, 'on' => 'create'), // 2MB
            array('certificate', 'file', 'types' => 'jpeg, jpg, gif, png', 'allowEmpty' => true, 'maxSize'=>1024 * 1024 * 2, 'on' => 'create, update'), // 2MB
            array('active', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('meta_title, meta_keywords, slug, logo, address1, address2, latitude, longitude, phone, fax, email, note', 'length', 'max' => 45),
            array('date_upd, description, description_short, meta_description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_supplier, name, date_add, date_upd, active, description, description_short, meta_title, meta_keywords, meta_description, slug, logo, address1, address2, latitude, longitude, phone, fax, email, note', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'addresses' => array(self::HAS_MANY, 'Address', 'id_supplier'),
            'customerSuppliers' => array(self::HAS_MANY, 'CustomerSupplier', 'id_supplier'),
            'menus' => array(self::HAS_MANY, 'Menu', 'id_supplier'),
            'products' => array(self::HAS_MANY, 'Product', 'id_supplier_default'),
            'productSuppliers' => array(self::HAS_MANY, 'ProductSupplier', 'id_supplier'),
            'sliders' => array(self::HAS_MANY, 'Slider', 'id_supplier'),
            'supplyOrders' => array(self::HAS_MANY, 'SupplyOrder', 'id_supplier'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_supplier' => 'Mã NCC',
            'name' => 'Tên NCC',
            'date_add' => 'Ngày Tạo',
            'date_upd' => 'Ngày Cập Nhật',
            'active' => 'Kích hoạt',
            'description' => 'Mô Tả',
            'description_short' => 'Mô tả ngắn',
            'meta_title' => 'Meta Tựa',
            'meta_keywords' => 'Meta Từ khóa',
            'meta_description' => 'Meta Mô tả',
            'slug' => 'Slug',
            'logo' => 'Logo',
            'old_logo' => 'Logo cũ',
            'address1' => 'Địa chỉ 1',
            'address2' => 'Địa chỉ 2',
            'latitude' => 'Vĩ độ',
            'longitude' => 'Kinh độ',
            'phone' => 'Di động',
            'fax' => 'Fax',
            'email' => 'Thư điện tử',
            'note' => 'Ghi chú',
            'certificate' => 'Giấy chứng nhận',
            'old_certificate' => 'Giấy chứng nhận cũ'
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

        $criteria->compare('id_supplier', $this->id_supplier, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_short', $this->description_short, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('address1', $this->address1, true);
        $criteria->compare('address2', $this->address2, true);
        $criteria->compare('latitude', $this->latitude, true);
        $criteria->compare('longitude', $this->longitude, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('note', $this->note, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_supplier, name ASC';
        $sort->attributes = array(
            'id_supplier' => 'id_supplier',
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

    public function searchByProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            $criteria3->compare('idProduct.active', 1);
            $productsuppliers = ProductSupplier::model()->findAll($criteria3);
            foreach ($productsuppliers as $productsupplier) {
                $values[] = $productsupplier->id_supplier;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_supplier', $values);            
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_supplier, name ASC';
        $sort->attributes = array(
            'id_supplier' => 'id_supplier',
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
            $criteria3->compare('idProduct.active', 1);
            $productsuppliers = ProductSupplier::model()->findAll($criteria3);
            foreach ($productsuppliers as $productsupplier) {
                $values[] = $productsupplier->id_supplier;
            }
        }
        $criteria = new CDbCriteria;

        if (!empty($values))
            $criteria->addNotInCondition('id_supplier', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_supplier, name ASC';
        $sort->attributes = array(
            'id_supplier' => 'id_supplier',
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
    
  public function searchBySupProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            //$criteria3->compare('idProduct.active', 1);
            $productsuppliers = ProductSupplier::model()->findAll($criteria3);
            foreach ($productsuppliers as $productsupplier) {
                $values[] = $productsupplier->id_supplier;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_supplier', $values);            
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_supplier, name ASC';
        $sort->attributes = array(
            'id_supplier' => 'id_supplier',
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

    public function searchByNoSupProduct($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            //$criteria3->compare('idProduct.active', 1);
            $productsuppliers = ProductSupplier::model()->findAll($criteria3);
            foreach ($productsuppliers as $productsupplier) {
                $values[] = $productsupplier->id_supplier;
            }
        }
        $criteria = new CDbCriteria;

        if (!empty($values))
            $criteria->addNotInCondition('id_supplier', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_supplier, name ASC';
        $sort->attributes = array(
            'id_supplier' => 'id_supplier',
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
     * @return Supplier the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->slug = PostHelper::TitleVNtoEN($this->name);
        return parent::beforeValidate();
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_supplier, 'n');
        $this->updateByPk($this->id_supplier, array('slug' => $this->slug));
        return parent::afterSave();
    }

    public function afterFind() {        
        try {
            $this->old_logo = $this->logo;
            if ((!empty($this->logo) || $this->logo != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . $this->logo))) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->logo, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
            
            $this->old_certificate = $this->certificate = ImageHelper::FindImageByPk(self::TYPE, 'cer_'.$this->id_supplier);        
            if ($this->certificate !== null) {
                $this->cer_thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->certificate, self::TYPE, "50x50"));
            } else {
                $this->cer_thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'cer.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        
        
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
