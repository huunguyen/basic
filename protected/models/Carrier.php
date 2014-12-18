<?php

/**
 * This is the model class for table "tbl_carrier".
 *
 * The followings are the available columns in table 'tbl_carrier':
 * @property string $id_carrier
 * @property string $name
 * @property string $url
 * @property integer $active
 * @property integer $deleted
 * @property integer $shipping_handling
 * @property integer $range_behavior
 * @property integer $is_free
 * @property integer $shipping_external
 * @property integer $need_range
 * @property integer $shipping_method
 * @property string $position
 * @property integer $max_width
 * @property integer $max_height
 * @property integer $max_depth
 * @property integer $max_weight
 * @property integer $grade
 * @property string $delay
 * @property string $slug
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property CarrierGroup[] $carrierGroups
 * @property Cart[] $carts
 * @property CartRule[] $tblCartRules
 * @property Delivery[] $deliveries
 * @property OrderCarrier[] $orderCarriers
 * @property Orders[] $orders
 * @property Product[] $tblProducts
 * @property Warehouse[] $tblWarehouses
 */
class Carrier extends CActiveRecord {

    const TYPE = "car";

    public $logo;
    public $old_logo;
    public $thumbnail;
    public $billing; /* 0 = Tổng tiền hoặc 1 = Tổng cân nặng 2 = Tổng Khoản Cách */
    public $old_position;
    public $min_position;
    public $max_position;
    public $wxhxd_weight;
    public $old_range_behavior;
    public $city;
    public $cities;
    public $zone;
    public $zones;
    public $zone_behavior = 1;
    public $warehouses;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_carrier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, date_add', 'required'),
            array('active, deleted, shipping_handling, range_behavior, is_free, shipping_external, need_range, shipping_method, max_width, max_height, max_depth, max_weight, grade', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('url', 'length', 'max' => 255),
            array('position', 'length', 'max' => 10),
            array('delay, slug', 'length', 'max' => 45),
            array('date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_carrier, name, url, active, deleted, shipping_handling, range_behavior, is_free, shipping_external, need_range, shipping_method, position, max_width, max_height, max_depth, max_weight, grade, delay, slug, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'carrierGroups' => array(self::HAS_MANY, 'CarrierGroup', 'id_carrier'),
            'tblZones' => array(self::MANY_MANY, 'Zone', 'tbl_carrier_zone(id_carrier, id_zone)'),
            'carts' => array(self::HAS_MANY, 'Cart', 'id_carrier'),
            'tblCartRules' => array(self::MANY_MANY, 'CartRule', 'tbl_cart_rule_carrier(id_carrier, id_cart_rule)'),
            'deliveries' => array(self::HAS_MANY, 'Delivery', 'id_carrier'),
            'orderCarriers' => array(self::HAS_MANY, 'OrderCarrier', 'id_carrier'),
            'orders' => array(self::HAS_MANY, 'Orders', 'id_carrier'),
            'tblProducts' => array(self::MANY_MANY, 'Product', 'tbl_product_carrier(id_carrier, id_product)'),
            'carrierProducts' => array(self::HAS_MANY, 'ProductCarrier', 'id_carrier'),
            'rangeDistants' => array(self::HAS_MANY, 'RangeDistant', 'id_carrier'),
            'rangePrices' => array(self::HAS_MANY, 'RangePrice', 'id_carrier'),
            'rangeWeights' => array(self::HAS_MANY, 'RangeWeight', 'id_carrier'),
            'tblWarehouses' => array(self::MANY_MANY, 'Warehouse', 'tbl_warehouse_carrier(id_carrier, id_warehouse)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_carrier' => 'Mã Nhà Vận chuyển',
            'name' => 'Tên Nhà Vận chuyển',
            'url' => 'Nơi kiểm tra | Theo Dõi',
            'active' => 'Kích hoạt',
            'deleted' => 'Xóa',
            'shipping_handling' => 'Xử lý vận chuyển',
            'range_behavior' => 'Tiền | KL&KC',
            'is_free' => 'Vận Chuyển Miễn Phí',
            'shipping_external' => 'Dịch vụ ngoài Hệ Thống',
            'need_range' => 'Yêu Cầu Định Nghĩa Khoản',
            'shipping_method' => 'Phương Thức Vận Chuyển',
            'position' => 'Vị Trí',
            'max_width' => 'Chiều Rộng Tối Đa (CM)',
            'max_height' => 'Chiều Cao Tối Đa (CM)',
            'max_depth' => 'Chiều Sâu Tối Đa (CM)',
            'max_weight' => 'Sức Nặng Tối Đa (KG)',
            'grade' => 'Mức Đánh Giá',
            'delay' => 'Nơi Vận Chuyển - Thời Gian',
            'slug' => 'Slug',
            'date_add' => 'Ngày Tạo',
            'date_upd' => 'Ngày Cập Nhật',
            'zone_behavior' => 'Hành Vi Tạo Vùng mới',
            'city' => 'Tỉnh Thành & Thành Phố',
            'cities' => 'Các Tỉnh Thành & Thành Phố',
            'zone' => 'Vùng Miền & Khu Vực',
            'zones' => 'Các Vùng Miền & Khu Vực',
            'logo' => 'Ảnh đại diễn',
            'warehouses' => 'Kho lưu trữ'
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

        $criteria->compare('id_carrier', $this->id_carrier, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('shipping_handling', $this->shipping_handling);
        $criteria->compare('range_behavior', $this->range_behavior);
        $criteria->compare('is_free', $this->is_free);
        $criteria->compare('shipping_external', $this->shipping_external);
        $criteria->compare('need_range', $this->need_range);
        $criteria->compare('shipping_method', $this->shipping_method);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('max_width', $this->max_width);
        $criteria->compare('max_height', $this->max_height);
        $criteria->compare('max_depth', $this->max_depth);
        $criteria->compare('max_weight', $this->max_weight);
        $criteria->compare('grade', $this->grade);
        $criteria->compare('delay', $this->delay, true);
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
            //$criteria3->compare('idProduct.active', 1);
            $productcarriers = ProductCarrier::model()->findAll($criteria3);
            foreach ($productcarriers as $productcarrier) {
                $values[] = $productcarrier->id_carrier;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_carrier', $values); 
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_carrier, name ASC';
        $sort->attributes = array(
            'id_carrier' => 'id_carrier',
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
            $productcarriers = ProductCarrier::model()->findAll($criteria3);
            foreach ($productcarriers as $productcarrier) {
                $values[] = $productcarrier->id_carrier;
            }
        }
        $criteria = new CDbCriteria;

        if (!empty($values))
            $criteria->addNotInCondition('id_carrier', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_carrier, name ASC';
        $sort->attributes = array(
            'id_carrier' => 'id_carrier',
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
            $productcarriers = ProductCarrier::model()->findAll($criteria3);
            foreach ($productcarriers as $productcarrier) {
                $values[] = $productcarrier->id_carrier;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_carrier', $values); 
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_carrier, name ASC';
        $sort->attributes = array(
            'id_carrier' => 'id_carrier',
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
            $criteria3->compare('idProduct.active', 1);
            $productcarriers = ProductCarrier::model()->findAll($criteria3);
            foreach ($productcarriers as $productcarrier) {
                $values[] = $productcarrier->id_carrier;
            }
        }
        $criteria = new CDbCriteria;

        if (!empty($values))
            $criteria->addNotInCondition('id_carrier', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_carrier, name ASC';
        $sort->attributes = array(
            'id_carrier' => 'id_carrier',
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
     * @return Carrier the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->slug = PostHelper::TitleVNtoEN($this->name);
            $criteria = new CDbCriteria();
            $criteria->compare('active', true);
            $criteria->order = 'position DESC, id_carrier DESC';
            // process position here. find range position. 
            if (empty($this->position)) {
                // resort position in table before insert an new row
                self::model()->resortPosition();
                if ($carriers = self::model()->findAll($criteria)) {
                    foreach ($carriers as $carrier) {
                        $this->position = ++$carrier->position;
                        break;
                    }
                } else
                    $this->position = 0;
            }
            else {
                $criteria->compare('position', $this->position, true);
                if ($carriers = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->compare('active', true);
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_carrier DESC';
                    $carriers2 = self::model()->findAll($criteria2);
                    foreach ($carriers2 as $carrier2) {
                        $this->position = ++$carrier2->max_position;
                        break;
                    }
                }
            }
        } else {
            $criteria = new CDbCriteria();
            $criteria->compare('active', true);
            $criteria->order = 'position DESC, id_category ASC';
            if (($this->old_position != $this->position)) {
                $criteria->compare('position', $this->position, true);
                if ($carriers = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->compare('active', true);
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_category ASC';
                    $carriers2 = self::model()->findAll($criteria2);
                    foreach ($carriers2 as $carrier2) {
                        $this->position = ++$carrier2->max_position;
                        break;
                    }
                }
            }
            // range_behavior's updated? disable an old row and add a new row
            if (!empty($this->old_range_behavior) && !empty($this->deliveries) && ($this->old_range_behavior != $this->range_behavior)) {
                $this->id_carrier = null;
            }
        }

        return parent::beforeSave();
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_carrier, 'n');
        $this->updateByPk($this->id_carrier, array('slug' => $this->slug));
        return parent::afterSave();
    }

    public function afterFind() {
        $this->old_logo = $this->logo = ImageHelper::FindImageByPk(self::TYPE, $this->id_carrier);
        $this->old_range_behavior = $this->range_behavior;
        try {
            if ($this->logo !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->logo, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        $this->old_position = $this->position;
        $this->wxhxd_weight = '(' . $this->max_width . ' x ' . $this->max_height . ' x ' . $this->max_depth . ')(CM) <br/>(' . $this->max_weight . ' KG)';
        
        if($warehouses = WarehouseCarrier::model()->findAllByAttributes(array('id_carrier' => $this->getPrimaryKey()))){
            foreach ($warehouses as $warehouse) {
                $this->warehouses[] = $warehouse->id_warehouse;
            }
            
        }
        
        if($zones = CarrierZone::model()->findAllByAttributes(array('id_carrier' => $this->getPrimaryKey()))){
            foreach ($zones as $zone) {
                $this->zones[] = $zone->id_zone;
            }
            
        }
        return parent::afterFind();
    }

    protected function resortPosition($newposition = null, $newmodel = null) {
        $criteria = new CDbCriteria();
        $criteria->compare('active', true);
        $criteria->order = 'position DESC, id_carrier DESC';
        if ($this->isNewRecord) {
            if ($carriers = self::model()->findAll($criteria)) {
                $position = 0;
                foreach ($carriers as $carrier) {
                    $carrier->position = $position++;
                    $carrier->updateByPk($carrier->id_carrier, array('position' => $carrier->position));
                    break;
                }
            }
        }
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'common.extensions.behaviors.AutoTimestampBehavior',
            //You can optionally set the field name options here
            )
        );
    }

    /*
     * http://www.yiiframework.com/forum/index.php/topic/27401-additional-columns-for-cgridview-with-data-provider/
     * http://www.yiiframework.com/wiki/278/cgridview-render-customized-complex-datacolumns/
     */

    public function getStringZones() {
        $rs = '';
        foreach ($this->tblZones as $zone) {
            if (isset($zone) && !empty($zone)) {
                $city = City::model()->findByPk($zone->id_city);
                $rs .= '[' . $city->name . ':[<b>' . $zone->name . '</b>]] ';
            }
        }
        return $rs;
    }

}
