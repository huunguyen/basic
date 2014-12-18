<?php

/**
 * This is the model class for table "tbl_range_distant".
 *
 * The followings are the available columns in table 'tbl_range_distant':
 * @property string $id_range_distant
 * @property string $id_carrier
 * @property string $delimiter1
 * @property string $delimiter2
 *
 * The followings are the available model relations:
 * @property Delivery[] $deliveries
 * @property Carrier $idCarrier
 */
class RangeDistant extends CActiveRecord
{
    public $name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_range_distant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_carrier, delimiter1, delimiter2', 'required'),
			array('id_carrier', 'length', 'max'=>10),
			array('delimiter1, delimiter2', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_range_distant, id_carrier, delimiter1, delimiter2', 'safe', 'on'=>'search'),
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
			'deliveries' => array(self::HAS_MANY, 'Delivery', 'range_distant'),
			'idCarrier' => array(self::BELONGS_TO, 'Carrier', 'id_carrier'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_range_distant' => 'Mã Khoản Khối Lượng',
			'id_carrier' => 'Mã Nhà Vận chuyển',
			'delimiter1' => 'Khoản Cách Từ',
			'delimiter2' => 'Khoản Cách Đến',
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

		$criteria->compare('id_range_distant',$this->id_range_distant,true);
		$criteria->compare('id_carrier',$this->id_carrier,true);
		$criteria->compare('delimiter1',$this->delimiter1,true);
		$criteria->compare('delimiter2',$this->delimiter2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
public function afterFind() {
            $this->name = 'KC Tu '.$this->delimiter1.' đến KC '.$this->delimiter2;
            return parent::afterFind();
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RangeDistant the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
