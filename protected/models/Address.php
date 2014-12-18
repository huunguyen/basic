<?php

/**
 * This is the model class for table "tbl_address".
 *
 * The followings are the available columns in table 'tbl_address':
 * @property string $id_address
 * @property string $id_city
 * @property string $id_detail
 * @property string $id_manufacturer
 * @property string $id_supplier
 * @property string $id_warehouse
 * @property string $id_store
 * @property string $slug
 * @property string $company
 * @property string $fullname
 * @property string $address1
 * @property string $address2
 * @property string $phone
 * @property string $mobile
 * @property string $date_add
 * @property string $date_upd
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Warehouse $idWarehouse
 * @property City $idCity
 * @property Manufacturer $idManufacturer
 * @property Supplier $idSupplier
 * @property Store $idStore
 * @property Detail $idDetail
 * @property Cart[] $carts
 * @property Cart[] $carts1
 * @property Customization[] $customizations
 * @property Orders[] $orders
 * @property Orders[] $orders1
 */
class Address extends CActiveRecord {
    public $fulladdress;
    const ISPHONE = 1;
    const ISMOBILE = 1;
    public $style;
    //public $id_district;
    //public $id_ward;
    public $district;
    public $ward;
    public $zone;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_address';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array("id_city,address1,id_zone, mobile, date_add,fullname", "required", "message" => "<p style='color: red'>không được để trống {attribute}.</p>"),
            array('active', 'numerical', 'integerOnly' => true),
            array('id_city, id_detail, id_manufacturer, id_supplier, id_warehouse, id_store, id_zone, id_district, id_ward', 'length', 'max' => 10),
            array('slug', 'length', 'max' => 32),
            array('company, fullname', 'length', 'max' => 255),
            array('address1, address2', 'length', 'max' => 128),
            array('phone, mobile', 'length', 'max' => 13,'min'=>9),
            array('phone,mobile', 'match', 'pattern' => '/^([+]?[0-9 ]+)$/', 'message' => "<p style='color: red'>Điện thoại không chính xác</p>"),
            //array('mobile', 'mobileInVietNam', 'isMobile'=>self::ISMOBILE),
            //array('phone', 'phoneInVietNam', 'isPhone'=>self::ISPHONE),
            array('company, fullname, date_upd, id_store, id_zone, id_district, id_ward', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_address, id_city, id_zone, id_district, id_ward, id_detail, id_manufacturer, id_supplier, id_warehouse, id_store, slug, company, fullname, address1, address2, phone, mobile, date_add, date_upd, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idWarehouse' => array(self::BELONGS_TO, 'Warehouse', 'id_warehouse'),
            'idCity' => array(self::BELONGS_TO, 'City', 'id_city'),
            'idManufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'id_manufacturer'),
            'idSupplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
            'idDetail' => array(self::BELONGS_TO, 'Detail', 'id_detail'),
            'idZone' => array(self::BELONGS_TO, 'Zone', 'id_zone'),
            'idDistrict' => array(self::BELONGS_TO, 'District', 'id_district'),
            'idWard' => array(self::BELONGS_TO, 'Ward', 'id_ward'),
            'carts' => array(self::HAS_MANY, 'Cart', 'id_address_delivery'),
            'carts1' => array(self::HAS_MANY, 'Cart', 'id_address_invoice'),
            'customizations' => array(self::HAS_MANY, 'Customization', 'id_address_delivery'),
            'orders' => array(self::HAS_MANY, 'Orders', 'id_address_invoice'),
            'orders1' => array(self::HAS_MANY, 'Orders', 'id_address_delivery'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_address' => 'Mã địa chỉ',
            'id_city' => 'Mã tỉnh thành',
            'id_zone' => 'Mã vùng',
            'id_district' => 'Mã Quận | Huyện',
            'id_ward' => 'Mã Phường | Xã',
            'id_detail' => 'Mã chi tiết',
            'id_manufacturer' => 'Mã nhà sản xuất',
            'id_supplier' => 'Mã nhà cung cấp',
            'id_warehouse' => 'Mã kho hàng',
            'id_store' => 'Mã chi nhánh',
            'slug' => 'Slug',
            'company' => 'Công ty',
            'fullname' => 'Tên đầy đủ',
            'address1' => 'Địa chỉ 1',
            'address2' => 'Địa chỉ 2',
            'phone' => 'Số Cố định',
            'mobile' => 'Số di động',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'active' => 'Trạng thái',
            'style' => 'Miền Ở VN'
        );
    }
    
public function mobileInVietNam($attribute,$params){
    $formats = array(
        '###.###.####', '####.###.###',
        '###-###-####', '####-###-###',
        '####.###.####', '####-###-####',
    
           '#####.###.####', '#####-###-####',
           '+####.###.####', '+####-###-####',
    
        '(##)##.###.####','(##)##-###-####',
        '(###)##.###.####','(###)##-###-####',
    
        '##.##.###.####', '##-##-###-####','##-##.###.###','##.##-###-###',
    
        '####.####.####', '####-####-####', '(###) ####.####', '(###) ####-####', '(#####)####.####', '(#####)####-####',
    
        '##########', '###########', '############','#############','+###########','+#############'
    );

    $format = trim(preg_replace('/[0-9]/', '#', $this->$attribute));
    //dump($this->$attribute);dump($format);exit();
    if(!in_array($format, $formats)){
        $this->addError($attribute, 'Số di động không đúng định dạng ở việt nam!');
    }
}
public function phoneInVietNam($attribute,$params){
    $formats = array(
        '###.###.####', '####.###.###',
        '###-###-####', '####-###-###',
        '####.###.####', '####-###-####',
    
           '#####.###.####', '#####-###-####',
           '+####.###.####', '+####-###-####',
    
        '(##)##.###.####','(##)##-###-####',
        '(###)##.###.####','(###)##-###-####',
    
        '##.##.###.####', '##-##-###-####','##-##.###.###','##.##-###-###',
    
        '####.####.####', '####-####-####', '(###) ####.####', '(###) ####-####', '(#####)####.####', '(#####)####-####',
    
        '##########', '###########', '############','#############','+###########','+#############'
    );

    $format = trim(preg_replace('/[0-9]/', '#', $this->$attribute));
    //dump($this->$attribute);dump($format);exit();
    if(!in_array($format, $formats)){
        $this->addError($attribute, 'Số di động không đúng định dạng ở việt nam!');
    }
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

        $criteria=new CDbCriteria;

		$criteria->compare('id_address',$this->id_address,true);
		$criteria->compare('id_detail',$this->id_detail,true);
		$criteria->compare('id_manufacturer',$this->id_manufacturer,true);
		$criteria->compare('id_supplier',$this->id_supplier,true);
		$criteria->compare('id_warehouse',$this->id_warehouse,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('id_city',$this->id_city,true);
		$criteria->compare('id_zone',$this->id_zone,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('active',$this->active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Address the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->phone = preg_replace('/\s+/', '', $this->phone);
        $this->mobile = preg_replace('/\s+/', '', $this->mobile);
        if(isset($this->company) && ($this->company!="")){
            $this->fullname = $this->company;
        }
        elseif (isset($this->id_customer) && ($this->id_customer!=0)) {
            if ($customer = Customer::model()->findByPk($this->id_customer)) {
                if(isset($customer->details) && !empty($customer->details)){
                    $this->fullname = $customer->details->firstname;
                    $this->fullname .= $customer->details->lastname;
                }
                else
                {
                    $this->fullname = $customer->email;
                }                
            }
        }        
        elseif (isset($this->id_warehouse) && ($this->id_warehouse!=0)) {
            if ($warehouse = Warehouse::model()->findByPk($this->id_warehouse)) {
                $this->fullname = 'Warehouse';
                $this->company = $warehouse->name;
            }
        } 
        elseif (isset($this->id_supplier) && ($this->id_supplier!=0)) {
            if ($supplier = Supplier::model()->findByPk($this->id_supplier)) 
                {
                $this->fullname = 'Supplier';
                $this->company = $supplier->name;
            }
        } 
        elseif (isset($this->id_manufacturer) && ($this->id_manufacturer!=0)) {
            if ($manufacturer = Manufacturer::model()->findByPk($this->id_manufacturer)) {
                $this->fullname = 'Manufacturer';
                $this->company = $manufacturer->name;
            }
        } 
        elseif (isset($this->id_store) && ($store = Store::model()->findByPk($this->id_store))) {
            $this->fullname = 'Store';
            $this->company = $store->name;
        } 
        else {
            $this->company = $this->fullname = $this->fullname;
        }        
        if (!isset($this->id_store) || ($this->id_store==0)) {
            $this->id_store = Config::ID_STORE;
        }
        $this->district = District::model()->findByPk($this->id_district);
        $this->zone     = Zone::model()->findByPk($this->id_zone);
        if(($this->district ==null) && ($this->zone==null)){
            $this->addError('id_district', 'Quận Huyện Chưa được chọn!');
            $this->addError('id_zone', 'Vùng Chưa được chọn!');
        }
        
        if(!isset($this->id_ward) || ($this->id_ward=="") || ($this->id_ward==0)) $this->id_ward = null;
        $this->slug = PostHelper::TitleVNtoEN($this->fullname);
        return parent::beforeValidate();
    }
    
    public function beforeSave() {
        if (!isset($this->id_store) || ($this->id_store==0)) {
            $this->id_store = Config::ID_STORE;
        }
        
        if(($this->district ==null) && ($this->zone!=null)){
            // them quan huyen tu vung.
            $district = District::model()->findByAttributes(array('name'=>  $this->zone->name));
            if($district==null) {
                $district = new District;
                $district->id_city = $this->zone->id_city;
                $district->name = $this->zone->name;
                $district->save();
                $this->id_district = $district->getPrimaryKey();
                $this->id_ward = null;
            }
        }
        elseif(($this->district !=null) && ($this->zone==null)){
            // them vung tu quan huyen
            $zone = Zone::model()->findByAttributes(array('name'=>  $this->district->name));
            if($zone==null) {
                $zone = new District;
                $zone->id_city = $this->district->id_city;
                $zone->name = $this->district->name;
                $zone->save();
                $this->id_zone = $zone->getPrimaryKey();
            }
        }
        
        return parent::beforeSave();
    }

    public function afterSave() {        
        $this->slug = PostHelper::TitleVNtoEN($this->fullname) . "_" . PostHelper::id4slug($this->id_address, 'n');
        $this->updateByPk($this->id_address, array('slug' => $this->slug));
        return parent::afterSave();
    }
    
    public function afterFind() {
        $this->fulladdress="<b>$this->fullname</b><br/>$this->address1<br/>$this->phone";
        
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
