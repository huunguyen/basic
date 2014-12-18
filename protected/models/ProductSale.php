<?php

/**
 * This is the model class for table "tbl_product_sale".
 *
 * The followings are the available columns in table 'tbl_product_sale':
 * @property string $id_product
 * @property string $quantity
 * @property string $sale_nbr
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Product $idProduct
 */
class ProductSale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_product_sale';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_product, date_upd', 'required'),
			array('id_product, quantity, sale_nbr', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_product, quantity, sale_nbr, date_upd', 'safe', 'on'=>'search'),
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
			'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_product' => 'Id Product',
			'quantity' => 'Quantity',
			'sale_nbr' => 'Sale Nbr',
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
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('sale_nbr',$this->sale_nbr,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
