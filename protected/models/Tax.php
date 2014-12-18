<?php

/**
 * This is the model class for table "tbl_tax".
 *
 * The followings are the available columns in table 'tbl_tax':
 * @property string $id_tax
 * @property string $name
 * @property string $description
 * @property string $rate
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property OrderDetailTax[] $orderDetailTaxes
 * @property Product[] $products
 * @property ProductTax[] $productTaxes
 */
class Tax extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_tax';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, rate', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description', 'length', 'max'=>255),
			array('rate', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tax, name, description, rate, active', 'safe', 'on'=>'search'),
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
			'orderDetailTaxes' => array(self::HAS_MANY, 'OrderDetailTax', 'id_tax'),
			'products' => array(self::HAS_MANY, 'Product', 'id_tax'),
			'productTaxes' => array(self::HAS_MANY, 'ProductTax', 'id_tax'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tax' => 'Id Tax',
			'name' => 'Name',
			'description' => 'Description',
			'rate' => 'Rate',
			'active' => 'Active',
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

		$criteria->compare('id_tax',$this->id_tax,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('active',$this->active);

        $sort = new CSort;
        $sort->defaultOrder = 't.name ASC';
        $sort->attributes = array(
            'name' => 't.name'
        );
        
        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)).'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this).'_page', 0),
            ),
                )
        );	
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tax the static model class
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
