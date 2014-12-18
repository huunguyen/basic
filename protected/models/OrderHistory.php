<?php

/**
 * This is the model class for table "tbl_order_history".
 *
 * The followings are the available columns in table 'tbl_order_history':
 * @property string $id_order_history
 * @property string $id_user
 * @property string $id_order
 * @property string $id_order_state
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property User $idUser
 * @property Orders $idOrder
 * @property OrderState $idOrderState
 */
class OrderHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_order_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_order, id_order_state, date_add', 'required'),
			array('id_order, id_order_state', 'length', 'max'=>10),
			array('id_user, date_upd', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_order_history, id_user, id_order, id_order_state, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
			'idOrder' => array(self::BELONGS_TO, 'Orders', 'id_order'),
			'idOrderState' => array(self::BELONGS_TO, 'OrderState', 'id_order_state'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_order_history' => 'Id Order History',
			'id_user' => 'Id User',
			'id_order' => 'Id Order',
			'id_order_state' => 'Id Order State',
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

		$criteria->compare('id_order_history',$this->id_order_history,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('id_order',$this->id_order,true);
		$criteria->compare('id_order_state',$this->id_order_state,true);
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
	 * @return OrderHistory the static model class
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
         /**
     * Uses the primary keys set on a new record to either create or update
     * a record with those keys to have the last_access value set to the same value
     * as the current unsaved model.
     *
     * Returns the model with the updated last_access. Success can be checked by
     * examining the isNewRecord property.
     *
     * IMPORTANT: This method does not modify the existing model.
     * */
    public function updateRecord() {
        if(isset($this->id_user))
            $model = self::model()->findByPk(array('id_order' => $this->id_order, 'id_order_state' => $this->id_order_state, 'id_user' => $this->id_user));
        else
            $model = self::model()->findByPk(array('id_order' => $this->id_order, 'id_order_state' => $this->id_order_state));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_order = $this->id_order;
            $model->id_order_state = $this->id_order_state;
            if(isset($this->id_user)) $model->id_user = $this->id_user;
            else $model->id_user = null;
        }
        $model->save(false);
        return $model;
    }
}
