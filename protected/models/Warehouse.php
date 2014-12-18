<?php

/**
 * This is the model class for table "tbl_warehouse".
 *
 * The followings are the available columns in table 'tbl_warehouse':
 * @property string $id_warehouse
 * @property string $id_user
 * @property string $reference
 * @property string $name
 * @property integer $active
 * @property string $slug
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Stock[] $stocks
 * @property SupplyOrder[] $supplyOrders
 * @property User $idUser
 * @property Carrier[] $tblCarriers
 * @property WarehouseProductLocation[] $warehouseProductLocations
 */
class Warehouse extends CActiveRecord {

    const TYPE = "war";
    public $logo;
    public $old_logo;
    public $thumbnail;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_warehouse';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, date_add', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('id_user', 'length', 'max' => 10),
            array('reference', 'length', 'max' => 32),
            array('name, slug', 'length', 'max' => 45),
            array('id_user, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_warehouse, id_user, reference, name, active, slug, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'addresses' => array(self::HAS_MANY, 'Address', 'id_warehouse'),
            'address_active'=>array(self::HAS_ONE, 'Address', 'id_warehouse', 'on'=>'address_active.active>=1'),
            'stocks' => array(self::HAS_MANY, 'Stock', 'id_warehouse'),
            'supplyOrders' => array(self::HAS_MANY, 'SupplyOrder', 'id_warehouse'),
            'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
            'tblCarriers' => array(self::MANY_MANY, 'Carrier', 'tbl_warehouse_carrier(id_warehouse, id_carrier)'),
            'warehouseProductLocations' => array(self::HAS_MANY, 'WarehouseProductLocation', 'id_warehouse'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_warehouse' => 'Mã kho hàng',
            'id_user' => 'Mã Quản Lý',
            'reference' => 'Tham khảo',
            'name' => 'Tên Kho Hàng',
            'active' => 'Trạng Thái',
            'slug' => 'Slug',
            'date_add' => 'Ngày Tạo',
            'date_upd' => 'Ngày Cập Nhật',
            'logo' => 'Bản hiệu',
            'old_logo' => 'Bản hiệu cũ'
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

        $criteria->compare('id_warehouse', $this->id_warehouse, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
            $warehouseproductlocations = WarehouseProductLocation::model()->findAll($criteria3);
            foreach ($warehouseproductlocations as $warehouseproductlocation) {
                $values[] = $warehouseproductlocation->id_warehouse;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_warehouse', $values);            
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_warehouse, name ASC';
        $sort->attributes = array(
            'id_warehouse' => 'id_warehouse',
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
            $warehouseproductlocations = WarehouseProductLocation::model()->findAll($criteria3);
            foreach ($warehouseproductlocations as $warehouseproductlocation) {
                $values[] = $warehouseproductlocation->id_warehouse;
            }
        }
        $criteria = new CDbCriteria;

        if (!empty($values))
            $criteria->addNotInCondition('id_warehouse', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_warehouse, name ASC';
        $sort->attributes = array(
            'id_warehouse' => 'id_warehouse',
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
            $warehouseproductlocations = WarehouseProductLocation::model()->findAll($criteria3);
            foreach ($warehouseproductlocations as $warehouseproductlocation) {
                $values[] = $warehouseproductlocation->id_warehouse;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_warehouse', $values);            
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_warehouse, name ASC';
        $sort->attributes = array(
            'id_warehouse' => 'id_warehouse',
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
            $warehouseproductlocations = WarehouseProductLocation::model()->findAll($criteria3);
            foreach ($warehouseproductlocations as $warehouseproductlocation) {
                $values[] = $warehouseproductlocation->id_warehouse;
            }
        }
        $criteria = new CDbCriteria;

        if (!empty($values))
            $criteria->addNotInCondition('id_warehouse', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_warehouse, name ASC';
        $sort->attributes = array(
            'id_warehouse' => 'id_warehouse',
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
     * @return Warehouse the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function beforeValidate() {
        $this->slug = PostHelper::TitleVNtoEN($this->name);
        return parent::beforeValidate();
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_warehouse, 'n');
        $this->updateByPk($this->id_warehouse, array('slug' => $this->slug));
        return parent::afterSave();
    }

    public function afterFind() {
        $this->old_logo = $this->logo = ImageHelper::FindImageByPk(self::TYPE, $this->id_warehouse);     
        try {
            if ((!empty($this->logo) || $this->logo != "") && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . $this->logo))) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->logo, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
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
