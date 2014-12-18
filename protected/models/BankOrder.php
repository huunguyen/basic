<?php

/**
 * This is the model class for table "tbl_bank_order".
 *
 * The followings are the available columns in table 'tbl_bank_order':
 * @property string $id_bank
 * @property string $id_order
 * @property string $code_bank
 */
class BankOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_bank_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_bank, id_order', 'required'),
			array('id_bank, id_order', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_bank_order,id_bank, id_order', 'safe', 'on'=>'search'),
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
                    'idBank' => array(self::BELONGS_TO, 'Bank', 'id_bank'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_bank' => 'Id Bank',
			'id_order' => 'Id Order',
			'code_bank' => 'Code Bank',
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

		$criteria->compare('id_bank',$this->id_bank,true);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('code_bank',$this->code_bank,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BankOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
