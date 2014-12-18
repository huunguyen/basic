<?php

/**
 * This is the model class for table "tbl_product_attribute".
 *
 * The followings are the available columns in table 'tbl_product_attribute':
 * @property string $id_product_attribute
 * @property string $id_product
 * @property string $reference
 * @property string $supplier_reference
 * @property string $wholesale_price
 * @property string $price
 * @property integer $quantity
 * @property double $weight
 * @property string $minimal_quantity
 * @property string $date_add
 * @property string $date_upd
 * @property string $available_date
 *
 * The followings are the available model relations:
 * @property Customization[] $customizations
 * @property OrderDetail[] $orderDetails
 * @property Product $idProduct
 * @property Attribute[] $tblAttributes
 * @property Image[] $tblImages
 * @property Store[] $tblStores
 * @property ProductHotDeal[] $productHotDeals
 * @property ProductSupplier[] $productSuppliers
 * @property SpecificPrice[] $specificPrices
 * @property Stock[] $stocks
 * @property StockAvailable[] $stockAvailables
 * @property SupplyOrderDetail[] $supplyOrderDetails
 * @property WarehouseProductLocation[] $warehouseProductLocations
 */
class ProductAttribute extends CActiveRecord {

    public $_list = array();
    public $_old_list = array();
    public $_listimg = array();
    public $_old_listimg = array();

    const TYPE = "pra";

    public $old_img;
    public $img;
    public $thumbnail;
        public $tags;
    public $_oldTags;
    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_available_date;
    public $id_attribute;
    public $id_attribute_group;
    public $id_attributes;
    public $fullname;
public $isSuplier = false;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_product_attribute';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                '_list',
                'common.extensions.validators.ArrayValidator',
                'validator' => 'length',
                'params' => array(
                    'max' => 3,
                ),
                'separateParams' => false,
                'allowEmpty' => false,
            ),
            array('id_product, supplier_reference, date_add', 'required'),
            array('quantity', 'numerical', 'integerOnly' => true),
            array('weight', 'numerical'),
            array('id_product, minimal_quantity', 'length', 'max' => 10),
            array('reference, supplier_reference', 'length', 'max' => 32),
            array('wholesale_price, price', 'length', 'max' => 20),
            //array('available_date', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('_oldTags, tags, date_upd', 'safe'),
            array('tags', 'normalizeTags'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('_oldTags, tags, id_attribute_group, id_attribute, id_product_attribute, id_product, reference, supplier_reference, wholesale_price, price, quantity, weight, minimal_quantity, date_add, date_upd, available_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customizations' => array(self::HAS_MANY, 'Customization', 'id_product_attribute'),
            'orderDetails' => array(self::HAS_MANY, 'OrderDetail', 'product_attribute_id'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'tblAttributes' => array(self::MANY_MANY, 'Attribute', 'tbl_product_attribute_combination(id_product_attribute, id_attribute)'),
            'tblProductAttributeCombinations' => array(self::HAS_MANY, 'ProductAttributeCombination', 'id_product_attribute'),
            'tblImages' => array(self::MANY_MANY, 'Image', 'tbl_product_attribute_image(id_product_attribute, id_image)'),
            'tblProductAttributeImages' => array(self::HAS_MANY, 'ProductAttributeImage', 'id_product_attribute'),
            'tblProductAttributeImagesWithCover' => array(self::HAS_MANY, 'ProductAttributeImage', 'id_product_attribute',
                'on' => 'tblProductAttributeImagesWithCover.cover=1'),
            'tblProductAttributeImagesWithoutCover' => array(self::HAS_MANY, 'ProductAttributeImage', 'id_product_attribute',
                'on' => 'tblProductAttributeImagesWithoutCover.cover=0'),
            'tblStores' => array(self::MANY_MANY, 'Store', 'tbl_product_attribute_store(id_product_attribute, id_store)'),
            'productHotDeals' => array(self::HAS_MANY, 'ProductHotDeal', 'id_product_attribute'),
            'productSuppliers' => array(self::HAS_MANY, 'ProductSupplier', 'id_product_attribute'),
            'specificPrices' => array(self::HAS_MANY, 'SpecificPrice', 'id_product_attribute'),
            'stocks' => array(self::HAS_MANY, 'Stock', 'id_product_attribute'),
            'stockAvailables' => array(self::HAS_MANY, 'StockAvailable', 'id_product_attribute'),
            'supplyOrderDetails' => array(self::HAS_MANY, 'SupplyOrderDetail', 'id_product_attribute'),
            'warehouseProductLocations' => array(self::HAS_MANY, 'WarehouseProductLocation', 'id_product_attribute'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_product_attribute' => 'Mã loại SP',
            'id_product' => 'Mã Sản Phẩm',
            'reference' => '[chứng từ] sản phẩm phân loại',
            'supplier_reference' => '[chứng từ] Nhà cung cấp',
            'wholesale_price' => 'Giá Bán sỉ',
            'price' => 'Giá bán lẻ',
            'quantity' => 'Số lượng',
            'weight' => 'Cân nặng',
            'minimal_quantity' => 'Số lượng tối thiểu',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'available_date' => 'Ngày bắt đầu đặt',
            'id_attribute' => 'Thuộc tính',
            'id_attribute_group' => 'Nhóm thuộc tính',
            'fullname' => 'Tên Chủng Loại',
            'tags' => 'Mẫu tìm kiếm'
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

        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('supplier_reference', $this->supplier_reference, true);
        $criteria->compare('wholesale_price', $this->wholesale_price, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('weight', $this->weight);
        $criteria->compare('minimal_quantity', $this->minimal_quantity, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('available_date', $this->available_date, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_product, reference, supplier_reference, date_add ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'reference' => 'reference',
            'supplier_reference' => 'supplier_reference',
            'date_add' => 'date_add',
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
        $criteria = new CDbCriteria;
        if (isset($id_product)) {
            $criteria->condition = 'id_product=:id_product';
            $criteria->params = array(':id_product' => $id_product);
        } else
            $criteria->compare('id_product_attribute', $this->id_product_attribute, true);

        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('supplier_reference', $this->supplier_reference, true);
        $criteria->compare('wholesale_price', $this->wholesale_price, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('minimal_quantity', $this->minimal_quantity, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('available_date', $this->available_date, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_product, reference, supplier_reference, date_add ASC';
        $sort->attributes = array(
            'id_product' => 'id_product',
            'reference' => 'reference',
            'supplier_reference' => 'supplier_reference',
            'date_add' => 'date_add',
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
     * @return ProductAttribute the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors() {
        return array(
            'AutoTimestampBehavior' => array(
                'class' => 'common.extensions.behaviors.AutoTimestampBehavior',
            //You can optionally set the field name options here
            )
        );
    }
/**
     * Normalizes the user-entered tags.
     */
    public function normalizeTags($attribute, $params) {
        $this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }
    public function getNameProduct() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("id_product_attribute=:id_product_attribute");
        $criteria->params = array(':id_product_attribute' => $this->id_product_attribute);
        $coms = ProductAttributeCombination::model()->findAll($criteria);
        $name = $this->idProduct->name;
        foreach ($coms as $com) {
            $name .= " - [" . $com->idAttribute->idAttributeGroup->name . "]" . $com->idAttribute->name;
        }
        return $name;
    }

    public function beforeValidate() {
        if (!isset($this->available_date) || !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date))) {
            if (isset($this->available_date) && !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date)))
                $this->addError('available_date', 'Ngày nhập không chính xác');
            else
                $this->available_date = null;
        } else {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $available_date = $date->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);

            if ($this->isNewRecord) {
                $this->addError('available_date', ($available_date < $current) ? 'Ngày nhập phải lớn hơn ngày hiện tại' : null);
            } elseif (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_available_date) && ($this->old_available_date != $this->available_date) && ($available_date < $current)) {
                $this->addError('available_date', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
        }
        if(isset($this->price) && isset($this->wholesale_price) && ($this->price<$this->wholesale_price)){
            $this->addError('price', 'Giá bán lẻ không hợp lệ');
            $this->addError('wholesale_price', 'Giá bán sỉ không hợp lệ');
            if($this->price>0) $this->wholesale_price = $this->price;
            elseif($this->wholesale_price>0) $this->price = $this->wholesale_price;
            else $this->wholesale_price = $this->price = 0;
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (isset($this->available_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $this->available_date = $date->format($this->out_format);
        }
        return parent::beforeSave();
    }

    public function addCombination() {
        if (isset($this->_list) && (count($this->_list) > 0)) {
            foreach ($this->_list as $value) {
                $combination = ProductAttributeCombination::model()->findByPk(array('id_attribute' => $value, 'id_product_attribute' => $this->getPrimaryKey()));
                if ($combination === null) {
                    $combination = new ProductAttributeCombination;
                    $combination->id_product_attribute = $this->getPrimaryKey();
                    $combination->id_attribute = $value;
                    $combination->updateRecord();
                }
            }
        }
        return true;
    }

    public function modifyCombination($diff = null) {
        if (isset($diff) && (count($diff) > 0)) {
            foreach ($diff as $value) {
                $combination = ProductAttributeCombination::model()->findByPk(array('id_attribute' => $value, 'id_product_attribute' => $this->getPrimaryKey()));
                if ($combination != null) {
                    $combination->delete();
                }
            }
        }
        return $this->addCombination();
    }

    public function addImage() {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "uploads");

        if ((Yii::app()->user->hasState('uni_id')) && (Yii::app()->user->hasState(Yii::app()->user->getState('uni_id')))) {
            $images = Yii::app()->user->getState(Yii::app()->user->getState('uni_id'));
        } elseif (Yii::app()->user->hasState('images')) {
            $images = Yii::app()->user->getState('images');
        }
        if (isset($images) && is_array($images)) {
            //Here we define the paths where the files will be stored temporarily
            if (!is_dir($path . DIRECTORY_SEPARATOR . self::TYPE)) {
                mkdir($path . DIRECTORY_SEPARATOR . self::TYPE, 0777);
                mkdir($path . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
            } elseif (!is_dir($path . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                mkdir($path . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
            }
            $path = $path . DIRECTORY_SEPARATOR . self::TYPE;
            $items = array();
            $count = 1;
            //var_dump($images);exit();
            foreach ($images as $image) {
                if (is_file($image["path"])) {
                    $imodel = new Image;
                    $imodel->id_product = $this->id_product;
                    $imodel->name = $image["name"];
                    $imodel->legend = "<section><header>{$image['title']}</header><main>{$image['description']}</main></section>";
                    $imodel->position = $count;
                    $imodel->type = $image["mime"];
                    $imodel->size = $image["size"];
                    $imodel->url = $path;
                    if (!$imodel->save(false)) {
                        //Its always good to log something
                        Yii::log("Could not save Image:\n" . CVarDumper::dumpAsString(
                                        $imodel->getErrors()), CLogger::LEVEL_ERROR);
                        //this exception will rollback the transaction
                        //throw new Exception('Could not save Image');
                    } else {
                        $imodel = $imodel->updateRecord();

                        if (rename($image["path"], $path . DIRECTORY_SEPARATOR . $imodel->name)) {
                            chmod($path . DIRECTORY_SEPARATOR . $imodel->name, 0777);
                            if (count($image['more']) > 0) {
                                $arr = explode(".", $imodel->name);
                                $arr2 = explode("/", $arr[0]);
                                $namewithoutext = $arr2[count($arr2) - 1];

                                foreach ($image['more'] as $img) {
                                    $_name = $namewithoutext . substr($img, strrpos($img, '-'));
                                    if (rename($img, $path . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $_name)) {
                                        chmod($path . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $_name, 0777);
                                    }
                                }
                            }
                        }
                        $paimodel = new ProductAttributeImage;
                        $paimodel->id_product_attribute = $this->getPrimaryKey();
                        $paimodel->id_image = $imodel->getPrimaryKey();
                        $paimodel->updateRecord();
                    }
                } else {
                    //You can also throw an execption here to rollback the transaction
                    Yii::log($image["path"] . " is not a file", CLogger::LEVEL_WARNING);
                }

                $count++;
            }
        }
        return true;
    }

    public function modifyImage($diff = null) {
        if (isset($diff) && (count($diff) > 0)) {
            foreach ($diff as $value) {
                $proattimg = ProductAttributeImage::model()->findByPk(array('id_product_attribute' => $this->getPrimaryKey(), 'id_image' => $value));
                if ($proattimg != null) {
                    $proattimg->delete();
                }
            }
        }
        return $this->addImage();
    }

    public function afterSave() {
        if (isset($this->available_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $this->available_date = $date->format($this->out_format);
        }

        if ($this->isNewRecord) {
            if ($this->addCombination()) {
                $uni_id = Yii::app()->user->getState('uni_id');
                if (Yii::app()->user->hasState($uni_id . '_attributeList')) {
                    Yii::app()->user->setState($uni_id . '_attributeList', null);
                }
            }
        } else {
            $diff = array_diff($this->_old_list, $this->_list);
            if (!empty($diff)) {
                $this->modifyCombination($diff);
            }
        }
        if ($this->addImage()) {
            if (Yii::app()->user->hasState(Yii::app()->user->getState('uni_id'))) {
                Yii::app()->user->setState(Yii::app()->user->getState('uni_id'), null);
            }
        }
        $this->modifyIntoStock();
        
        if($this->isSuplier){
            $pro_sup = new ProductSupplier;
            $cus_sup = CustomerSupplier::model()->findByAttributes(array('id_customer' => Yii::app()->user->id));
            if ($cus_sup == null) {
                throw new CHttpException(404, 'Yêu cầu không hợp lệ. Nhà cung cấp này chưa Quản lý Một nhà cung cấp nào trong hệ thống. Vui lòng liên hệ với quản trị hệ thống để thiết lập thông tin lại cho tài khoản này!');
            } else {
                $supplier = Supplier::model()->findByPk($cus_sup->id_supplier);
            }
            $pro_sup->id_supplier = $supplier->id_supplier;
            $pro_sup->id_product = $this->id_product;
            $pro_sup->id_product_attribute = $this->getPrimaryKey();
            $pro_sup->product_supplier_price_te = $this->price;
            $pro_sup->product_supplier_reference = $this->supplier_reference;
            $pro_sup->updateRecord();
        }
        
        Tag::model()->updateProAttFrequency($this->_oldTags, $this->tags, $this->getPrimaryKey());
        return parent::afterSave();
    }

    public function afterFind() {
        if (isset($this->available_date)) {
            $date = DateTime::createFromFormat($this->out_format, $this->available_date);
            $this->old_available_date = $this->available_date = $date->format($this->in_format);
        }

        if (isset($this->tblAttributes)) {
            foreach ($this->tblAttributes as $value) {
                $this->_list[] = $value->id_attribute;
            }
            $this->_old_list = $this->_list;
        }

        if (isset($this->tblImages)) {
            foreach ($this->tblImages as $value) {
                $this->_listimg[] = $value->id_image;
            }
            $this->_old_listimg = $this->_listimg;
        }

        $this->fullname = $this->getNameProduct();
        
        if($_tags = ProductAttributeTag::model()->findAllByAttributes(array('id_product_attribute'=>  $this->getPrimaryKey()))){
            $list = array();
            foreach ($_tags as $value) {
                $list[] = $value->idTag->name;
            }
            $this->tags = Tag::array2string($list);
        }
        $this->_oldTags = $this->tags;
        return parent::afterFind();
    }

    public function modifyIntoStock() {
        $criteria = new CDbCriteria;
        $criteria->compare('id_product', $this->id_product);
        $criteria->addCondition("id_product_attribute IS NULL");
        $stock_product = StockAvailable::model()->find($criteria);
        if ($stock_product === null) {
            $stock_product = new StockAvailable;
            $stock_product->id_product = $this->id_product;
        }

        $criteria2 = new CDbCriteria;
        $criteria2->compare('id_product', $this->id_product);
        $criteria2->compare('id_product_attribute', $this->getPrimaryKey());
        $stock_product_attribute = StockAvailable::model()->find($criteria2);
        if ($stock_product_attribute == null) {
            $stock_product_attribute = new StockAvailable;
            $stock_product_attribute->id_product = $this->id_product;
            $stock_product_attribute->id_product_attribute = $this->getPrimaryKey();
        }
        $stock_product_attribute->quantity = $this->quantity;
        
        $product = Product::model()->findByPk($this->id_product);
        $stock_product_attribute->out_of_stock = $product->out_of_stock;
        $stock_product_attribute->depends_on_stock = $product->stock_management;

        $stock_product->depends_on_stock = $stock_product_attribute->depends_on_stock;
        $stock_product->id_store = $stock_product_attribute->id_store = Config::ID_STORE;
        $stock_product_attribute->updateRecord();

        $stock_product->quantity = $this->sumQuantity($this->id_product);
        $stock_product->updateRecord();
    }

    public function sumQuantity($id_product) {
        $product = Product::model()->findByPk($id_product);
        $sum = 0;
        if (isset($product->productAttributes)) {
            foreach ($product->productAttributes as $attribute) {
                $sum += $attribute->quantity;
            }
        } else {
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $id_product);
            $criteria->addCondition("id_product_attribute IS NOT NULL");
            $productAttributes = ProductAttribute::model()->find($criteria);
            foreach ($productAttributes as $attribute) {
                $sum += $attribute->quantity;
            }
        }
        return $sum;
    }

}
