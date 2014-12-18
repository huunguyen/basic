<?php

/**
 * This is the model class for table "tbl_delivery".
 *
 * The followings are the available columns in table 'tbl_delivery':
 * @property string $id_delivery
 * @property string $id_carrier
 * @property string $id_zone
 * @property string $range_price
 * @property string $range_weight
 * @property string $range_distant
 * @property string $price
 * @property string $date_add
 * @property string $date_upd
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Carrier $idCarrier
 * @property RangePrice $rangePrice
 * @property RangeWeight $rangeWeight
 * @property RangeDistant $rangeDistant
 * @property Zone $idZone
 */
class Delivery extends CActiveRecord
{
    public $fullname;
    public $delimiter1;
    public $delimiter2;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_delivery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_carrier, id_zone, price, date_add', 'required'),
			array('id_carrier, id_zone, range_price, range_weight, range_distant', 'length', 'max'=>10),
			array('price', 'length', 'max'=>20),
			array('slug', 'length', 'max'=>45),
			array('date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_delivery, id_carrier, id_zone, range_price, range_weight, range_distant, price, date_add, date_upd, slug', 'safe', 'on'=>'search'),
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
			'idCarrier' => array(self::BELONGS_TO, 'Carrier', 'id_carrier'),
			'rangePrice' => array(self::BELONGS_TO, 'RangePrice', 'range_price'),
			'rangeWeight' => array(self::BELONGS_TO, 'RangeWeight', 'range_weight'),
			'rangeDistant' => array(self::BELONGS_TO, 'RangeDistant', 'range_distant'),
			'idZone' => array(self::BELONGS_TO, 'Zone', 'id_zone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_delivery' => 'Mã Vận chuyển',
			'id_carrier' => 'Mã Nhà Vận chuyển',
                        'id_zone' => 'Mã Khu Vực',
			'range_price' => 'Mã Khoản Giá',
			'range_weight' => 'Mã Khoản Khối Lượng',
			'range_distant' => 'Mã Khoản Quảng Đường',
			'price' => 'Giá Trị (Tiền)',
                        'date_add' => 'Ngày Tạo',
			'date_upd' => 'Ngày Cập Nhật',
			'slug' => 'Slug',
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

		$criteria->compare('id_delivery',$this->id_delivery,true);
		$criteria->compare('id_carrier',$this->id_carrier,true);
		$criteria->compare('id_zone',$this->id_zone,true);
		$criteria->compare('range_price',$this->range_price,true);
		$criteria->compare('range_weight',$this->range_weight,true);
		$criteria->compare('range_distant',$this->range_distant,true);
		$criteria->compare('price',$this->price,true);
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
	 * @return Delivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function afterFind() {
            if(isset($this->id_zone) && ($z = Zone::model()->findByPk($this->id_zone))){
                $this->fullname = $z->name;
            }
            
            if (isset($this->range_weight) && ($w = RangeWeight::model()->findByPk($this->range_weight))){    
                 $this->fullname += $w->name;
            }
            
            if (isset($this->range_distant) && ($d = RangeDistant::model()->findByPk($this->range_distant))){
                $this->fullname += $d->name;
            }
            
            if (isset($this->range_price) && ($p = RangePrice::model()->findByPk($this->range_price))){
                $this->fullname += $p->name;
            }
            
            $this->fullname = "aaaa";
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
