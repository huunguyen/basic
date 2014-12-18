<?php

/**
 * This is the model class for table "tbl_store".
 *
 * The followings are the available columns in table 'tbl_store':
 * @property string $id_store
 * @property string $id_store_group
 * @property string $id_city
 * @property string $id_theme
 * @property integer $active
 * @property string $name
 * @property string $address1
 * @property string $address2
 * @property string $latitude
 * @property string $longitude
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $note
 * @property string $date_add
 * @property string $date_upd
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Cart[] $carts
 * @property Configuration[] $configurations
 * @property Connections[] $connections
 * @property CustomerThread[] $customerThreads
 * @property Menu[] $menus
 * @property PageViewed[] $pageVieweds
 * @property Post[] $posts
 * @property ProductAttribute[] $tblProductAttributes
 * @property Product[] $tblProducts
 * @property Referrer[] $tblReferrers
 * @property SearchWord[] $searchWords
 * @property StockAvailable[] $stockAvailables
 * @property Theme $idTheme
 * @property StoreGroup $idStoreGroup
 * @property City $idCity
 * @property StoreSlider[] $storeSliders
 * @property Theme[] $tblThemes
 */
class Store extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address1, date_add, date_upd', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('id_store_group, id_city, id_theme', 'length', 'max'=>10),
			array('name, address1, address2, email', 'length', 'max'=>128),
			array('latitude, longitude', 'length', 'max'=>11),
			array('phone, fax', 'length', 'max'=>16),
			array('slug', 'length', 'max'=>45),
			array('note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_store, id_store_group, id_city, id_theme, active, name, address1, address2, latitude, longitude, phone, fax, email, note, date_add, date_upd, slug', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Address', 'id_store'),
			'carts' => array(self::HAS_MANY, 'Cart', 'id_store'),
			'configurations' => array(self::HAS_MANY, 'Configuration', 'id_store'),
			'connections' => array(self::HAS_MANY, 'Connections', 'id_store'),
			'customerThreads' => array(self::HAS_MANY, 'CustomerThread', 'id_store'),
			'menus' => array(self::HAS_MANY, 'Menu', 'id_store'),
			'pageVieweds' => array(self::HAS_MANY, 'PageViewed', 'id_store'),
			'posts' => array(self::HAS_MANY, 'Post', 'id_store'),
			'tblProductAttributes' => array(self::MANY_MANY, 'ProductAttribute', 'tbl_product_attribute_store(id_store, id_product_attribute)'),
			'tblProducts' => array(self::MANY_MANY, 'Product', 'tbl_product_store(id_store, id_product)'),
			'tblReferrers' => array(self::MANY_MANY, 'Referrer', 'tbl_referrer_store(id_store, id_referrer)'),
			'searchWords' => array(self::HAS_MANY, 'SearchWord', 'id_store'),
			'stockAvailables' => array(self::HAS_MANY, 'StockAvailable', 'id_store'),
			'idTheme' => array(self::BELONGS_TO, 'Theme', 'id_theme'),
			'idStoreGroup' => array(self::BELONGS_TO, 'StoreGroup', 'id_store_group'),
			'idCity' => array(self::BELONGS_TO, 'City', 'id_city'),
			'storeSliders' => array(self::HAS_MANY, 'StoreSlider', 'id_store'),
			'tblThemes' => array(self::MANY_MANY, 'Theme', 'tbl_theme_specific(id_store, id_theme)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_store' => 'Mã chi nhánh',
			'id_store_group' => 'Mã nhóm chi nhánh',
			'id_city' => 'Mã thành phố',
			'id_theme' => 'Mã mẫu',
			'active' => 'Trạng thái',
			'name' => 'Tên chi nhánh',
			'address1' => 'Địa chỉ chính',
			'address2' => 'Địa chỉ phụ',
			'latitude' => 'Kinh độ - Tọa độ',
			'longitude' => 'Vĩ độ - Tọa độ',
			'phone' => 'Số di động',
			'fax' => 'Số fax',
			'email' => 'Thư điện tử',
			'note' => 'Ghi chú',
			'date_add' => 'Ngày tạo',
			'date_upd' => 'Ngày cập nhật',
			'slug' => 'Mã liên kết',
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

		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('id_store_group',$this->id_store_group,true);
		$criteria->compare('id_city',$this->id_city,true);
		$criteria->compare('id_theme',$this->id_theme,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address1',$this->address1,true);
		$criteria->compare('address2',$this->address2,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);
		$criteria->compare('slug',$this->slug,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Store the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
           
    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->slug = PostHelper::TitleVNtoEN($this->name);
        }
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_store, 'n');
        $this->updateByPk($this->id_store, array('slug' => $this->slug));
        return parent::afterSave();
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
