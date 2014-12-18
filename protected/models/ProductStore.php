<?php

/**
 * This is the model class for table "tbl_product_store".
 *
 * The followings are the available columns in table 'tbl_product_store':
 * @property string $id_product
 * @property string $id_store
 * @property string $id_category_default
 * @property string $id_tax_rules
 * @property integer $on_sale
 * @property string $minimal_quantity
 * @property string $price
 * @property string $wholesale_price
 * @property string $unity
 * @property string $unit_price_ratio
 * @property string $additional_shipping_cost
 * @property integer $customizable
 * @property integer $text_fields
 * @property integer $active
 * @property integer $available_for_order
 * @property string $available_date
 * @property string $condition
 * @property integer $show_price
 * @property string $date_add
 * @property string $date_upd
 */
class ProductStore extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_product_store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, id_store, id_tax_rules, available_date, date_add', 'required'),
			array('on_sale, customizable, text_fields, active, available_for_order, show_price', 'numerical', 'integerOnly'=>true),
			array('id_product, id_store, id_category_default, id_tax_rules, minimal_quantity', 'length', 'max'=>10),
			array('price, wholesale_price, unit_price_ratio, additional_shipping_cost', 'length', 'max'=>20),
			array('unity', 'length', 'max'=>255),
			array('condition', 'length', 'max'=>11),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product, id_store, id_category_default, id_tax_rules, on_sale, minimal_quantity, price, wholesale_price, unity, unit_price_ratio, additional_shipping_cost, customizable, text_fields, active, available_for_order, available_date, condition, show_price, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'id_product' => 'Id Product',
			'id_store' => 'Id Store',
			'id_category_default' => 'Id Category Default',
			'id_tax_rules' => 'Id Tax Rules',
			'on_sale' => 'On Sale',
			'minimal_quantity' => 'Minimal Quantity',
			'price' => 'Price',
			'wholesale_price' => 'Wholesale Price',
			'unity' => 'Unity',
			'unit_price_ratio' => 'Unit Price Ratio',
			'additional_shipping_cost' => 'Additional Shipping Cost',
			'customizable' => 'Customizable',
			'text_fields' => 'Text Fields',
			'active' => 'Active',
			'available_for_order' => 'Available For Order',
			'available_date' => 'Available Date',
			'condition' => 'Condition',
			'show_price' => 'Show Price',
			'date_add' => 'Date Add',
			'date_upd' => 'Date Upd',
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

		$criteria->compare('id_product',$this->id_product,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('id_category_default',$this->id_category_default,true);
		$criteria->compare('id_tax_rules',$this->id_tax_rules,true);
		$criteria->compare('on_sale',$this->on_sale);
		$criteria->compare('minimal_quantity',$this->minimal_quantity,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('wholesale_price',$this->wholesale_price,true);
		$criteria->compare('unity',$this->unity,true);
		$criteria->compare('unit_price_ratio',$this->unit_price_ratio,true);
		$criteria->compare('additional_shipping_cost',$this->additional_shipping_cost,true);
		$criteria->compare('customizable',$this->customizable);
		$criteria->compare('text_fields',$this->text_fields);
		$criteria->compare('active',$this->active);
		$criteria->compare('available_for_order',$this->available_for_order);
		$criteria->compare('available_date',$this->available_date,true);
		$criteria->compare('condition',$this->condition,true);
		$criteria->compare('show_price',$this->show_price);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductStore the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
