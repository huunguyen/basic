<?php

/**
 * This is the model class for table "tbl_supply_order".
 *
 * The followings are the available columns in table 'tbl_supply_order':
 * @property string $id_supply_order
 * @property string $id_supplier
 * @property string $supplier_name
 * @property string $id_warehouse
 * @property string $id_supply_order_state
 * @property string $reference
 * @property string $date_add
 * @property string $date_upd
 * @property string $date_delivery_expected
 * @property string $total_te
 * @property string $total_tax
 * @property string $total_ti
 *
 * The followings are the available model relations:
 * @property StockMvt[] $stockMvts
 * @property Supplier $idSupplier
 * @property Warehouse $idWarehouse
 * @property SupplyOrderState $idSupplyOrderState
 * @property SupplyOrderDetail[] $supplyOrderDetails
 * @property SupplyOrderHistory[] $supplyOrderHistories
 */
class SupplyOrder extends CActiveRecord {

    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_date_delivery_expected;
    public $total_te_string;
    public $isUser = true;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_supply_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_supplier, id_warehouse, id_supply_order_state, reference', 'required'),
            array('id_supplier, id_warehouse, id_supply_order_state', 'length', 'max' => 10),
            array('reference', 'length', 'max' => 64),
            array('total_te, total_tax, total_ti', 'length', 'max' => 20),
            array('date_delivery_expected', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('date_delivery_expected, date_add, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('total_te_string, id_supply_order, id_supplier, id_warehouse, id_supply_order_state, reference, date_add, date_upd, date_delivery_expected, total_te, total_tax, total_ti', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'stockMvts' => array(self::HAS_MANY, 'StockMvt', 'id_supply_order'),
            'idSupplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
            'idWarehouse' => array(self::BELONGS_TO, 'Warehouse', 'id_warehouse'),
            'idSupplyOrderState' => array(self::BELONGS_TO, 'SupplyOrderState', 'id_supply_order_state'),
            'supplyOrderDetails' => array(self::HAS_MANY, 'SupplyOrderDetail', 'id_supply_order'),
            'supplyOrderHistories' => array(self::HAS_MANY, 'SupplyOrderHistory', 'id_supply_order'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_supply_order' => 'Mã đơn hàng',
            'id_supplier' => 'Mã nhà cung cấp',
            'supplier_name' => 'Tên nhà cung cấp',
            'id_warehouse' => 'Mã kho hàng',
            'id_supply_order_state' => 'Mã trạng thái',
            'reference' => 'Tham khảo',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'date_delivery_expected' => 'Ngày giao hàng',
            'total_te' => 'Tổng tiền chưa thuế',
            'total_te_string' => 'Tổng tiền bằng chữ',
            'total_tax' => 'Tổng thuế',
            'total_ti' => 'Tổng tiền gồm thuế',
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

        $criteria->compare('id_supply_order', $this->id_supply_order, true);
        $criteria->compare('id_supplier', $this->id_supplier, true);
        $criteria->compare('id_warehouse', $this->id_warehouse, true);
        $criteria->compare('id_supply_order_state', $this->id_supply_order_state, true);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('date_delivery_expected', $this->date_delivery_expected, true);
        $criteria->compare('total_te', $this->total_te, true);
        $criteria->compare('total_tax', $this->total_tax, true);
        $criteria->compare('total_ti', $this->total_ti, true);

        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supplier, id_warehouse, id_supply_order_state, date_add ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supplier' => 'id_supplier',
            'id_warehouse' => 'id_warehouse',
            'id_supply_order_state' => 'id_supply_order_state',
            'date_add' => 'date_add',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchBySupplier($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supplier', $id_supplier);

        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supplier, id_warehouse, id_supply_order_state, date_add ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supplier' => 'id_supplier',
            'id_warehouse' => 'id_warehouse',
            'id_supply_order_state' => 'id_supply_order_state',
            'date_add' => 'date_add',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchnew($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supply_order_state', 3);
        $criteria->compare('id_supplier', $id_supplier);
        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supplier, id_warehouse, id_supply_order_state, date_add ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supplier' => 'id_supplier',
            'id_warehouse' => 'id_warehouse',
            'id_supply_order_state' => 'id_supply_order_state',
            'date_add' => 'date_add',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchaccept($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_supply_order_state', 4);
        $criteria->compare('id_supplier', $id_supplier);
        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supplier, id_warehouse, id_supply_order_state, date_add ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supplier' => 'id_supplier',
            'id_warehouse' => 'id_warehouse',
            'id_supply_order_state' => 'id_supply_order_state',
            'date_add' => 'date_add',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchdelivery($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supply_order_state', 5);
        $criteria->compare('id_supplier', $id_supplier);
        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supplier, id_warehouse, id_supply_order_state, date_add ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supplier' => 'id_supplier',
            'id_warehouse' => 'id_warehouse',
            'id_supply_order_state' => 'id_supply_order_state',
            'date_add' => 'date_add',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchcancel($id_supplier) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_supply_order_state', 7);
        $criteria->compare('id_supplier', $id_supplier);
        $sort = new CSort;
        $sort->defaultOrder = 'reference, id_supplier, id_warehouse, id_supply_order_state, date_add ASC';
        $sort->attributes = array(
            'reference' => 'reference',
            'id_supplier' => 'id_supplier',
            'id_warehouse' => 'id_warehouse',
            'id_supply_order_state' => 'id_supply_order_state',
            'date_add' => 'date_add',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function beforeValidate() {

        if (!isset($this->date_delivery_expected) || !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->date_delivery_expected))) {
            if (!empty($this->date_delivery_expected) && !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->date_delivery_expected))) {
                $this->date_delivery_expected = null;
                $this->addError('date_delivery_expected', 'Ngày nhập không chính xác. Bạn nên sử dụng tools đã cung cấp để thiết lập ngày bán sản phẩm.');
            } else
                $this->date_delivery_expected = null;
        } else {
            $date = DateTime::createFromFormat($this->in_format, $this->date_delivery_expected);
            $date_delivery_expected = $date->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);

            if ($this->isNewRecord && ($date_delivery_expected < $current)) {
                $this->addError('date_delivery_expected', 'Ngày nhập phải lớn hơn ngày hiện tại');
            } elseif (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_date_delivery_expected) && ($this->old_date_delivery_expected != $this->date_delivery_expected) && ($date_delivery_expected < $current)) {
                $this->addError('date_delivery_expected', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (isset($this->date_delivery_expected)) {
            $date = DateTime::createFromFormat($this->in_format, $this->date_delivery_expected);
            $this->date_delivery_expected = $date->format($this->out_format);
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if (isset($this->date_delivery_expected) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->date_delivery_expected)) {
            $date = DateTime::createFromFormat($this->in_format, $this->date_delivery_expected);
            $this->date_delivery_expected = $date->format($this->out_format);
        }
        /*         * ***************************************************************** */
        // save state for monitor in system
        $history = new SupplyOrderHistory;
        $history->id_supply_order = $this->getPrimaryKey();
        if ($this->isUser && ($user = User::model()->findByPk(Yii::app()->user->id))) {
            $history->id_user = Yii::app()->user->id;
        } elseif (!$this->isUser && ($user = Customer::model()->findByPk(Yii::app()->user->id))) {
            $history->id_customer = Yii::app()->user->id;
        } else {
            $history->id_user = $history->id_customer = null;
        }

        $history->id_supply_order_state = $this->id_supply_order_state;
        //dump($history);exit();
        $history->save(false);
        /*         * ***************************************************************** */
        return parent::afterSave();
    }

    public function afterFind() {
        if (isset($this->date_delivery_expected)) {
            $date = DateTime::createFromFormat($this->out_format, $this->date_delivery_expected);
            $this->old_date_delivery_expected = $this->date_delivery_expected = $date->format($this->in_format);
        }
        $this->total_te_string = FinanceHelper::changeNumberToString($this->total_te);
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SupplyOrder the static model class
     */
    public static function model($className = __CLASS__) {
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
