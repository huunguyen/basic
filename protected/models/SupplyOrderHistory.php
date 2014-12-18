<?php

/**
 * This is the model class for table "tbl_supply_order_history".
 *
 * The followings are the available columns in table 'tbl_supply_order_history':
 * @property string $id_supply_order_history
 * @property string $id_supply_order
 * @property string $id_user
 * @property string $id_supply_order_state
 * @property string $date_add
 *
 * The followings are the available model relations:
 * @property SupplyOrder $idSupplyOrder
 * @property User $idUser
 * @property SupplyOrderState $idSupplyOrderState
 */
class SupplyOrderHistory extends CActiveRecord {

    public $user_lastname;
    public $user_firstname;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_supply_order_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_supply_order, id_supply_order_state, date_add', 'required'),
            array('id_supply_order, id_user, id_supply_order_state', 'length', 'max' => 10),
            array('id_user, id_customer, user_lastname, user_firstname', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_supply_order_history, id_supply_order, id_user, id_customer, id_supply_order_state, date_add', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idSupplyOrder' => array(self::BELONGS_TO, 'SupplyOrder', 'id_supply_order'),
            'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
            'idSupplyOrderState' => array(self::BELONGS_TO, 'SupplyOrderState', 'id_supply_order_state'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_supply_order_history' => 'Mã lịch sử giao dịch',
            'id_supply_order' => 'Mã đơn hàng',
            'id_user' => 'Mã người dùng',
            'id_customer' => 'Mã nhà cung cấp',
            'id_supply_order_state' => 'Mã trạng thái',
            'date_add' => 'Ngày tạo',
            'user_lastname' => 'Tên người dùng',
            'user_firstname' => 'Họ người dùng',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supply_order_history', $this->id_supply_order_history, true);
        $criteria->compare('id_supply_order', $this->id_supply_order, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_supply_order_state', $this->id_supply_order_state, true);
        $criteria->compare('date_add', $this->date_add, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeValidate() {
        $this->date_add = new CDbExpression('NOW()');
        return parent::beforeValidate();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SupplyOrderHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
