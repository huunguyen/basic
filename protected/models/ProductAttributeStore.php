<?php

/**
 * This is the model class for table "tbl_product_attribute_store".
 *
 * The followings are the available columns in table 'tbl_product_attribute_store':
 * @property string $id_product_attribute
 * @property string $id_store
 * @property string $wholesale_price
 * @property string $price
 * @property double $weight
 * @property integer $default_on
 * @property string $minimal_quantity
 * @property string $available_date
 * @property string $date_add
 * @property string $date_upd
 */
class ProductAttributeStore extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_product_attribute_store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product_attribute, id_store, available_date', 'required'),
			array('default_on', 'numerical', 'integerOnly'=>true),
			array('weight', 'numerical'),
			array('id_product_attribute, id_store, minimal_quantity', 'length', 'max'=>10),
			array('wholesale_price, price', 'length', 'max'=>20),
			array('date_add, date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product_attribute, id_store, wholesale_price, price, weight, default_on, minimal_quantity, available_date, date_add, date_upd', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product_attribute' => 'Mã sản phẩm',
			'id_store' => 'Mã chi nhánh',
			'wholesale_price' => 'Giá sỉ',
			'price' => 'Giá lẻ',
			'weight' => 'Nặng',
			'default_on' => 'Default On',
			'minimal_quantity' => 'Số lượng tối thiểu',
			'available_date' => 'Ngày khả dụng',
			'date_add' => 'Ngày tạo',
			'date_upd' => 'Ngày cập nhật',
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
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('wholesale_price',$this->wholesale_price,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('default_on',$this->default_on);
		$criteria->compare('minimal_quantity',$this->minimal_quantity,true);
		$criteria->compare('available_date',$this->available_date,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		$sort = new CSort;
        $sort->defaultOrder = 'id_store, id_product_attribute ASC';
        $sort->attributes = array(
            'id_store' => 'id_store',
            'id_product_attribute' => 'id_product_attribute'
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
	 * @return ProductAttributeStore the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
}
