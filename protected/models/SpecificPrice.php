<?php

/**
 * This is the model class for table "tbl_specific_price".
 *
 * The followings are the available columns in table 'tbl_specific_price':
 * @property string $id_specific_price
 * @property string $id_specific_price_rule
 * @property string $id_cart
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $id_customer
 * @property string $price
 * @property integer $from_quantity
 * @property string $reduction
 * @property string $reduction_type
 * @property string $from
 * @property string $to
 *
 * The followings are the available model relations:
 * @property ProductAttribute $idProductAttribute
 * @property SpecificPriceRule $idSpecificPriceRule
 * @property Cart $idCart
 * @property Product $idProduct
 * @property Customer $idCustomer
 */
class SpecificPrice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_specific_price';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_cart, id_product, id_customer, price, from_quantity, reduction, reduction_type, from, to', 'required'),
			array('from_quantity', 'numerical', 'integerOnly'=>true),
			array('id_cart_rule, id_specific_price_rule, id_cart, id_product, id_product_attribute, id_customer, reduction_type', 'length', 'max'=>10),
			array('price, reduction', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_specific_price, id_cart_rule, id_specific_price_rule, id_cart, id_product, id_product_attribute, id_customer, price, from_quantity, reduction, reduction_type, from, to', 'safe', 'on'=>'search'),
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
			'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
			'idSpecificPriceRule' => array(self::BELONGS_TO, 'SpecificPriceRule', 'id_specific_price_rule'),
			'idCart' => array(self::BELONGS_TO, 'Cart', 'id_cart'),
			'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
			'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
                    'idCartRule' => array(self::BELONGS_TO, 'CartRule', 'id_cart_rule'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_specific_price' => 'Mã đặc tả giá',
			'id_specific_price_rule' => 'Mã qui luật đặc tả giá',
                    'id_cart_rule' => 'Mã qui luật giỏ hàng',
			'id_cart' => 'Mã giỏ hàng',
			'id_product' => 'Mã sản phẩm',
			'id_product_attribute' => 'Mã thuộc tính sản phẩm',
			'id_customer' => 'Mã khách hàng',
			'price' => 'Giá',
			'from_quantity' => 'Từ số lượng',
			'reduction' => 'Khoản giảm',
			'reduction_type' => 'Loại giảm',
			'from' => 'Từ ngày',
			'to' => 'Đến ngày',
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

		$criteria->compare('id_specific_price',$this->id_specific_price,true);
		$criteria->compare('id_specific_price_rule',$this->id_specific_price_rule,true);
		$criteria->compare('id_cart',$this->id_cart,true);
		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_product_attribute',$this->id_product_attribute,true);
		$criteria->compare('id_customer',$this->id_customer,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('from_quantity',$this->from_quantity);
		$criteria->compare('reduction',$this->reduction,true);
		$criteria->compare('reduction_type',$this->reduction_type,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);

		$sort = new CSort;
        $sort->defaultOrder = 'id_specific_price_rule, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_specific_price_rule' => 'id_specific_price_rule',
            'id_product' => 'id_product',
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

        public function searchByCart($id_cart)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->compare('id_cart',$id_cart);

		$sort = new CSort;
        $sort->defaultOrder = 'id_specific_price_rule, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_specific_price_rule' => 'id_specific_price_rule',
            'id_product' => 'id_product',
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
	 * @return SpecificPrice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
