<?php

/**
 * This is the model class for table "tbl_product".
 *
 * The followings are the available columns in table 'tbl_product':
 * @property string $id_product
 * @property string $id_supplier_default
 * @property string $id_manufacturer
 * @property string $id_category_default
 * @property string $id_tax
 * @property integer $on_sale
 * @property integer $quantity
 * @property string $minimal_quantity
 * @property string $price
 * @property string $wholesale_price
 * @property string $unity
 * @property string $unit_price_ratio
 * @property string $additional_shipping_cost
 * @property string $reference
 * @property string $supplier_reference
 * @property double $width
 * @property double $height
 * @property double $depth
 * @property double $weight
 * @property string $out_of_stock
 * @property integer $customizable
 * @property integer $text_fields
 * @property integer $active
 * @property integer $available_for_order
 * @property string $available_date
 * @property string $condition
 * @property integer $show_price
 * @property string $date_add
 * @property string $date_upd
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $description_short
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 *
 * The followings are the available model relations:
 * @property Accessory[] $accessories
 * @property Accessory[] $accessories1
 * @property Cart[] $tblCarts
 * @property CategoryProduct[] $categoryProducts
 * @property Compare[] $tblCompares
 * @property CustomerThread[] $customerThreads
 * @property Customization[] $customizations
 * @property CustomizationField[] $customizationFields
 * @property Feature[] $tblFeatures
 * @property Image[] $images
 * @property OrderDetail[] $orderDetails
 * @property Pack[] $packs
 * @property Category $idCategoryDefault
 * @property Supplier $idSupplierDefault
 * @property Manufacturer $idManufacturer
 * @property Tax $idTax
 * @property ProductAdvise[] $productAdvises
 * @property ProductAttribute[] $productAttributes
 * @property Carrier[] $tblCarriers
 * @property ProductHotDeal[] $productHotDeals
 * @property ProductSale $productSale
 * @property Store[] $tblStores
 * @property ProductSupplier[] $productSuppliers
 * @property Tag[] $tblTags
 * @property ProductTax[] $productTaxes
 * @property Rate $rate
 * @property SpecificPrice[] $specificPrices
 * @property Stock[] $stocks
 * @property StockAvailable[] $stockAvailables
 * @property SupplyOrderDetail[] $supplyOrderDetails
 * @property ViewedProduct[] $viewedProducts
 * @property WarehouseProductLocation[] $warehouseProductLocations
 */
class Product extends CActiveRecord {

    const TYPE = "pro";

    public $old_img;
    public $img;
    public $thumbnail;
    public $tags;
    public $_oldTags;
    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_available_date;
    public $old_quantity;
    public $isSuplier = false;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, id_supplier_default, id_manufacturer, id_category_default, date_add, id_tax', 'required'),
            array('is_feature, on_sale, quantity, customizable, text_fields, active, available_for_order, show_price', 'numerical', 'integerOnly' => true),
            array('width, height, depth', 'numerical'),
            array('weight', 'numerical',
                'integerOnly' => false,
                'min' => 0,
                'max' => 1000,
                'tooSmall' => 'Giá trị nhỏ nhất là zero',
                'tooBig' => 'Giá trị lớn nhất là 1 tấn'),
            array('id_supplier_default, id_manufacturer, id_category_default, id_tax, minimal_quantity, out_of_stock', 'length', 'max' => 10),
            array('price, wholesale_price, unit_price_ratio, additional_shipping_cost', 'length', 'max' => 20),
            array('unity', 'length', 'max' => 255),
            array('reference, supplier_reference', 'length', 'max' => 128),
            array('condition', 'length', 'max' => 11),
            array('slug, name, meta_title, meta_keywords', 'length', 'max' => 128),
            array('available_date', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('tags', 'normalizeTags'),
            array('is_feature, _oldTags, tags, date_upd, description, description_short, meta_description, stock_management', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('is_feature, _oldTags, tags, id_product, id_supplier_default, id_manufacturer, id_category_default, id_tax, on_sale, quantity, minimal_quantity, price, wholesale_price, unity, unit_price_ratio, additional_shipping_cost, reference, supplier_reference, width, height, depth, weight, out_of_stock, customizable, text_fields, active, available_for_order, available_date, condition, show_price, date_add, date_upd, slug, name, description, description_short, meta_title, meta_keywords, meta_description, stock_management', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'accessories' => array(self::HAS_MANY, 'Accessory', 'id_product_2'),
            'accessories1' => array(self::HAS_MANY, 'Accessory', 'id_product_1'),
            'tblCarts' => array(self::MANY_MANY, 'Cart', 'tbl_cart_product(id_product, id_cart)'),
            'categoryProducts' => array(self::HAS_MANY, 'CategoryProduct', 'id_product'),
            'tblCompares' => array(self::MANY_MANY, 'Compare', 'tbl_compare_product(id_product, id_compare)'),
            'customerThreads' => array(self::HAS_MANY, 'CustomerThread', 'id_product'),
            'customizations' => array(self::HAS_MANY, 'Customization', 'id_product'),
            'customizationFields' => array(self::HAS_MANY, 'CustomizationField', 'id_product'),
            'tblFeatures' => array(self::MANY_MANY, 'Feature', 'tbl_feature_product(id_product, id_feature)'),
            'featureProducts' => array(self::HAS_MANY, 'FeatureProduct', 'id_product'),
            'images' => array(self::HAS_MANY, 'Image', 'id_product'),
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'product_id'),
            'packs' => array(self::HAS_MANY, 'Pack', 'id_product_item'),
            'idCategoryDefault' => array(self::BELONGS_TO, 'Category', 'id_category_default'),
            'idSupplierDefault' => array(self::BELONGS_TO, 'Supplier', 'id_supplier_default'),
            'idManufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'id_manufacturer'),
            'idTax' => array(self::BELONGS_TO, 'Tax', 'id_tax'),
            'productAdvises' => array(self::HAS_MANY, 'ProductAdvise', 'id_product'),
            'productAttributes' => array(self::HAS_MANY, 'ProductAttribute', 'id_product'),
            'tblCarriers' => array(self::MANY_MANY, 'Carrier', 'tbl_product_carrier(id_product, id_carrier)'),
            'productCarriers' => array(self::HAS_MANY, 'ProductCarrier', 'id_product'),
            'productHotDeals' => array(self::HAS_MANY, 'ProductHotDeal', 'id_product'),
            'productSale' => array(self::HAS_ONE, 'ProductSale', 'id_product'),
            'tblStores' => array(self::MANY_MANY, 'Store', 'tbl_product_store(id_product, id_store)'),
            'productSuppliers' => array(self::HAS_MANY, 'ProductSupplier', 'id_product'),
            'tblTags' => array(self::MANY_MANY, 'Tag', 'tbl_product_tag(id_product, id_tag)'),
            'productTaxes' => array(self::HAS_MANY, 'ProductTax', 'id_product'),
            'rate' => array(self::HAS_ONE, 'Rate', 'id_product'),
            'specificPrices' => array(self::HAS_MANY, 'SpecificPrice', 'id_product'),
            'stocks' => array(self::HAS_MANY, 'Stock', 'id_product'),
            'stockAvailables' => array(self::HAS_MANY, 'StockAvailable', 'id_product'),
            'supplyOrderDetails' => array(self::HAS_MANY, 'SupplyOrderDetail', 'id_product'),
            'viewedProducts' => array(self::HAS_MANY, 'ViewedProduct', 'id_product'),
            'warehouseProductLocations' => array(self::HAS_MANY, 'WarehouseProductLocation', 'id_product'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_product' => 'Mã SP',
            'id_supplier_default' => 'Mã NCC',
            'id_manufacturer' => 'Mã NSX',
            'id_category_default' => 'Mã D.Mục',
            'id_tax' => 'Mã Thuế',
            'on_sale' => 'Mở bán',
            'quantity' => 'Số Lượng',
            'minimal_quantity' => 'Số Lượng Tối Thiểu',
            'price' => 'Giá Bán',
            'wholesale_price' => 'Giá Sỉ',
            'unity' => 'Đơn vị',
            'unit_price_ratio' => 'Giá/Đơn Vị',
            'additional_shipping_cost' => 'Giá cộng thêm',
            'reference' => 'Chứng từ',
            'supplier_reference' => '[Chứng từ] Nhà cung cấp',
            'width' => 'Chiều Rộng',
            'height' => 'Chiều Cao',
            'depth' => 'Chiều Sâu',
            'weight' => 'Cân Nặng [Trọng lượng]',
            'out_of_stock' => 'Được phép vượt lô hàng',
            'customizable' => 'Cho phép tùy biến',
            'text_fields' => 'Số Trường Tùy Biến',
            'active' => 'Trạng thái',
            'available_for_order' => 'Cho phép đặt hàng',
            'available_date' => 'Ngày bắt đầu đặt',
            'condition' => 'Loại hàng',
            'show_price' => 'Hiển thị Giá',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày Cập nhật',
            'slug' => 'Slug',
            'name' => 'Tên Sản Phẩm',
            'description' => 'Mô tả',
            'description_short' => 'Mô tả ngắn',
            'meta_title' => 'Meta Tựa',
            'meta_keywords' => 'Meta Từ Khóa',
            'meta_description' => 'Meta Mô tả',
            'tags' => 'Mẫu tìm kiếm',
            'img' => 'Ảnh đại diện',
            'old_img' => 'Ảnh đại diện',
            'stock_management' => 'Quản lý Nhập Hàng',
            'is_feature' => 'Sản phẩm nổi bật',
            'old_quantity' => 'SL hiện có(*) Ngoài Stock'
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

        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_supplier_default', $this->id_supplier_default, true);
        $criteria->compare('id_manufacturer', $this->id_manufacturer, true);
        $criteria->compare('id_category_default', $this->id_category_default, true);
        $criteria->compare('id_tax', $this->id_tax, true);
        $criteria->compare('on_sale', $this->on_sale);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('minimal_quantity', $this->minimal_quantity, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('wholesale_price', $this->wholesale_price, true);
        $criteria->compare('unity', $this->unity, true);
        $criteria->compare('unit_price_ratio', $this->unit_price_ratio, true);
        $criteria->compare('additional_shipping_cost', $this->additional_shipping_cost, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('supplier_reference', $this->supplier_reference, true);
        $criteria->compare('width', $this->width);
        $criteria->compare('height', $this->height);
        $criteria->compare('depth', $this->depth);
        $criteria->compare('weight', $this->weight);
        $criteria->compare('out_of_stock', $this->out_of_stock, true);
        $criteria->compare('customizable', $this->customizable);
        $criteria->compare('text_fields', $this->text_fields);
        $criteria->compare('active', $this->active);
        $criteria->compare('available_for_order', $this->available_for_order);
        $criteria->compare('available_date', $this->available_date, true);
        $criteria->compare('condition', $this->condition, true);
        $criteria->compare('show_price', $this->show_price);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_short', $this->description_short, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('stock_management', $this->stock_management, true);
        $sort = new CSort;
        $sort->defaultOrder = 'date_add, name, active ASC';
        $sort->attributes = array(
            'name' => 'name',
            'date_add' => 'date_add',
            'active' => 'active',
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

    public function searchByAccessory($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product_1=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct1';
            $criteria3->together = true;
            $criteria3->compare('idProduct1.active', 1);
            $accessories = Accessory::model()->findAll($criteria3);
            foreach ($accessories as $accessory) {
                $values[] = $accessory->id_product_2;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_product', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_product, name ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'name' => 'name'
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

    public function searchByNoAccessory($id_product = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        $values[] = $id_product;
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product_1=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct1';
            $criteria3->together = true;
            $criteria3->compare('idProduct1.active', 1);
            $accessories = Accessory::model()->findAll($criteria3);
            foreach ($accessories as $accessory) {
                $values[] = $accessory->id_product_2;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addNotInCondition('id_product', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_product, name ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'name' => 'name'
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

    public function searchByInStock() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->select = '*, MAX(t.id_product_attribute) max_id_product_attribute';
            $criteria3->group = 't.id_product';
            $criteria3->order = 't.id_store DESC, t.id_product DESC, max_id_product_attribute DESC';

            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            $criteria3->compare('idProduct.active', 1);
            $availables = StockAvailable::model()->findAll($criteria3);
            foreach ($availables as $available) {
                $values[] = $available->id_product;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_product', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_product, name ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'name' => 'name'
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

    public function searchByOutStock() {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        $values[] = $id_product;
        if (isset($id_product)) {
            $criteria3 = new CDbCriteria();
            $criteria3->condition = 't.id_product_1=:id_product';
            $criteria3->params = array(':id_product' => $id_product);
            $criteria3->with = 'idProduct1';
            $criteria3->together = true;
            $criteria3->compare('idProduct1.active', 1);
            $accessories = Accessory::model()->findAll($criteria3);
            foreach ($accessories as $accessory) {
                $values[] = $accessory->id_product_2;
            }
        }
        $criteria = new CDbCriteria;

        $criteria->addNotInCondition('id_product', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_product, name ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'name' => 'name'
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

    public function searchBySupplier($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_supplier)) {
            $criteria3 = new CDbCriteria();
            //$criteria3->select = '*, MAX(t.id_product_attribute) max_id_product_attribute';
            $criteria3->group = 't.id_product';
            $criteria3->order = 't.id_product DESC';

            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            $criteria3->compare('id_supplier', $id_supplier);
            $availables = ProductSupplier::model()->findAll($criteria3);
            foreach ($availables as $available) {
                $values[] = $available->id_product;
            }

            $criteria2 = new CDbCriteria();
            $criteria2->compare('id_supplier_default', $id_supplier);
            $availables = self::model()->findAll($criteria2);
            foreach ($availables as $available) {
                if (!in_array($available->id_product, $values))
                    $values[] = $available->id_product;
                else
                    continue;
            }
        }

        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_product', $values);
        $criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_product, name ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'name' => 'name'
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
    
public function searchAllForSupplier($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $values = array();
        if (isset($id_supplier)) {
            $criteria3 = new CDbCriteria();
            //$criteria3->select = '*, MAX(t.id_product_attribute) max_id_product_attribute';
            $criteria3->group = 't.id_product';
            $criteria3->order = 't.id_product DESC';

            $criteria3->with = 'idProduct';
            $criteria3->together = true;
            $criteria3->compare('id_supplier', $id_supplier);
            $availables = ProductSupplier::model()->findAll($criteria3);
            foreach ($availables as $available) {
                $values[] = $available->id_product;
            }

            $criteria2 = new CDbCriteria();
            $criteria2->compare('id_supplier_default', $id_supplier);
            $availables = self::model()->findAll($criteria2);
            foreach ($availables as $available) {
                if (!in_array($available->id_product, $values))
                    $values[] = $available->id_product;
                else
                    continue;
            }
        }

        $criteria = new CDbCriteria;

        $criteria->addInCondition('id_product', $values);
        //$criteria->compare('active', 1);
        $sort = new CSort;
        $sort->defaultOrder = 'id_product, name ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'name' => 'name'
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
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->slug = PostHelper::TitleVNtoEN($this->name);
        if (!isset($this->available_date) || !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date))) {
            if (!empty($this->available_date) && !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date))) {
                $this->available_date = null;
                //$this->addError('available_date', 'Ngày nhập không chính xác. Bạn nên sử dụng tools đã cung cấp để thiết lập ngày bán sản phẩm.');
            } else
                $this->available_date = null;
        } else {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $available_date = $date->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);

            if ($this->isNewRecord && ($available_date < $current)) {
                $this->addError('available_date', 'Ngày nhập phải lớn hơn ngày hiện tại');
             } elseif (isset($this->old_available_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_available_date) && ($this->old_available_date != $this->available_date) && ($available_date < $current)) {
                $this->addError('available_date', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
        }
        if (isset($this->price) && isset($this->wholesale_price) && ($this->price < $this->wholesale_price)) {
            $this->addError('price', 'Giá bán lẻ không hợp lệ');
            $this->addError('wholesale_price', 'Giá bán sỉ không hợp lệ');
            if ($this->price > 0)
                $this->wholesale_price = $this->price;
            elseif ($this->wholesale_price > 0)
                $this->price = $this->wholesale_price;
            else
                $this->wholesale_price = $this->price = 0;
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (isset($this->available_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $this->available_date = $date->format($this->out_format);
        }
        if($this->scenario == "addQuantity"){
            $this->quantity += $this->old_quantity;
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_product, 'n');
        $this->updateByPk($this->id_product, array('slug' => $this->slug));
        if (isset($this->available_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $this->available_date = $date->format($this->out_format);
        }
        $this->modifyIntoStock();      
        Tag::model()->updateProductFrequency($this->_oldTags, $this->tags, $this->getPrimaryKey());
        
        return parent::afterSave();
    }
/**
     * Normalizes the user-entered tags.
     */
    public function normalizeTags($attribute, $params) {
        $this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }
    public function modifyIntoStock() {
        $criteria = new CDbCriteria;
        $criteria->compare('id_product', $this->id_product);
        $criteria->addCondition("id_product_attribute IS NULL");
        $stock_product = StockAvailable::model()->find($criteria);
        if ($stock_product == null) {
            $stock_product = new StockAvailable;
            $stock_product->id_product = $this->id_product;
        }
        $stock_product->id_store = Config::ID_STORE;
        if (($this->isNewRecord) || (!isset($this->productAttributes))) {
            $stock_product->quantity = $this->quantity;
        } else {
            $stock_product->quantity = $this->sumQuantity($this->getPrimaryKey());
        }
        $stock_product->depends_on_stock = $this->stock_management;
        $stock_product->out_of_stock = $this->out_of_stock;
        $stock_product->updateRecord();
    }

    public function sumQuantity($id_product) {
        $sum = 0;
        if (isset($this->productAttributes)) {
            foreach ($this->productAttributes as $attribute) {
                $sum += $attribute->quantity;
            }
        } else {
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $this->id_product);
            $criteria->addCondition("id_product_attribute IS NOT NULL");
            $productAttributes = ProductAttribute::model()->find($criteria);
            foreach ($productAttributes as $attribute) {
                $sum += $attribute->quantity;
            }
        }
        return $sum;
    }

    public function afterFind() {
        if (isset($this->available_date)) {
            $date = DateTime::createFromFormat($this->out_format, $this->available_date);
            $this->old_available_date = $this->available_date = $date->format($this->in_format);
        }
        $this->old_img = $this->img = ImageHelper::FindImageByPk(self::TYPE, $this->id_product);
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

        if (isset($this->quantity)) {
            $this->old_quantity = $this->quantity;
        }
        
        if($_tags = ProductTag::model()->findAllByAttributes(array('id_product'=>  $this->getPrimaryKey()))){
            $list = array();
            foreach ($_tags as $value) {
                $list[] = $value->idTag->name;
            }
            $this->tags = Tag::array2string($list);
        }
        $this->_oldTags = $this->tags;
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
