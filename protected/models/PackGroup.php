<?php

/**
 * This is the model class for table "tbl_pack_group".
 *
 * The followings are the available columns in table 'tbl_pack_group':
 * @property string $id_pack_group
 * @property string $name
 * @property string $description
 * @property string $description_short
 * @property string $date_add
 * @property string $date_upd
 * @property string $total_paid
 * @property string $total_paid_real
 * @property integer $available_for_order
 * @property string $available_date
 * @property integer $active
 * @property string $reduction_type
 * @property string $reduction
 *
 * The followings are the available model relations:
 * @property Pack[] $packs
 */
class PackGroup extends CActiveRecord {

    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_available_date;
    public $total_save;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_pack_group';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description_short, description', 'required'),
            array('available_for_order, active', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 128),
            array('description_short', 'length', 'max' => 255),
            array('total_paid, total_paid_real', 'length', 'max' => 17),
            array('reduction_type', 'length', 'max' => 10),
            array('reduction', 'length', 'max' => 20),
            array('available_date', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('date_upd, date_add, reduction_type, reduction', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('total_save, id_pack_group, name, description, description_short, date_add, date_upd, total_paid, total_paid_real, available_for_order, available_date, active, reduction_type, reduction', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'packs' => array(self::HAS_MANY, 'Pack', 'id_pack_group'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_pack_group' => 'Mã gói',
            'name' => 'Tên',
            'description' => 'Mô tả',
            'description_short' => 'Mô tả ngắn',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'total_paid' => 'Tổng trả',
            'total_paid_real' => 'Tổng thực trả',
            'available_for_order' => '[Mở/Đóng] Đặt hàng',
            'available_date' => 'Ngày BĐ đặt hàng',
            'active' => 'Trạng thái [Mở/Đóng]',
            'reduction_type' => 'Loại giảm',
            'reduction' => 'Khoản giảm',
            'total_save' => 'Khoản tiết kiệm'
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

        $criteria->compare('id_pack_group', $this->id_pack_group, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_short', $this->description_short, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('total_paid', $this->total_paid, true);
        $criteria->compare('total_paid_real', $this->total_paid_real, true);
        $criteria->compare('available_for_order', $this->available_for_order);
        $criteria->compare('available_date', $this->available_date, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('reduction_type', $this->reduction_type, true);
        $criteria->compare('reduction', $this->reduction, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, available_date, date_add ASC';
        $sort->attributes = array(
            'name' => 'name',
            'available_date' => 'available_date',
            'date_add' => 'date_add'
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

    public function searchByDate($available_date) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_pack_group', $this->id_pack_group, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_short', $this->description_short, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('total_paid', $this->total_paid, true);
        $criteria->compare('total_paid_real', $this->total_paid_real, true);
        $criteria->compare('available_for_order', $this->available_for_order);
        $criteria->compare('available_date', $this->available_date, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('reduction_type', $this->reduction_type, true);
        $criteria->compare('reduction', $this->reduction, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, available_date, date_add ASC';
        $sort->attributes = array(
            'name' => 'name',
            'available_date' => 'available_date',
            'date_add' => 'date_add'
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

    public function beforeValidate() {
        if (!isset($this->available_date) || !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date))) {
            if (!(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date))) {
                $this->available_date = null;
                //$this->addError('available_date', 'Ngày nhập không chính xác. Bạn nên sử dụng tools đã cung cấp để thiết lập ngày bán sản phẩm.');
            }
        } else {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $available_date = $date->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);

            if ($this->isNewRecord && ($available_date < $current)) {
                $this->addError('available_date', 'Ngày nhập phải lớn hơn ngày hiện tại');
            } elseif (isset($this->old_available_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_available_date) && ($this->old_available_date != $this->available_date) && ($available_date < $current)) {
                $this->addError('available_date', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
        }
        if ($this->isNewRecord) {
            $this->total_paid = $this->total_paid_real = $this->total_save = 0;
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (isset($this->available_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $this->available_date = $date->format($this->out_format);
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if (isset($this->available_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->available_date)) {
            $date = DateTime::createFromFormat($this->in_format, $this->available_date);
            $this->available_date = $date->format($this->out_format);
        }
        return parent::afterSave();
    }

    public function afterFind() {
        if (isset($this->available_date)) {
            $date = DateTime::createFromFormat($this->out_format, $this->available_date);
            $this->old_available_date = $this->available_date = $date->format($this->in_format);
        }
        return parent::afterFind();
    }

    public function getListProduct() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("id_pack_group=:id_pack_group");
        $criteria->params = array(':id_pack_group' => $this->id_pack_group);
        $packs = Pack::model()->findAll($criteria);
        foreach ($packs as $pack) {
            if (isset($pack->idProductAttribute)) {
                $name .= " [" . $pack->idProductAttribute->fullname . "] ";
            } else {
                $name .= " [" . $pack->idProduct->name . "] ";
            }
        }
        return isset($name) ? $name : "...";
    }

    public function modifyTotalPaid() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("id_pack_group=:id_pack_group");
        $criteria->params = array(':id_pack_group' => $this->id_pack_group);
        $packs = Pack::model()->findAll($criteria);
        $total = 0;
        foreach ($packs as $pack) {
            if (isset($pack->idProductAttribute)) {
                $total += $pack->idProductAttribute->price*$pack->quantity;
            } else {
                $total += $pack->idProduct->price*$pack->quantity;
            }
        }
        $this->total_paid = round($total, -3);
        return round($total, -3);
    }

    public function modifyTotalRealPaid() {
        $criteria = new CDbCriteria;
        $criteria->addCondition("id_pack_group=:id_pack_group");
        $criteria->params = array(':id_pack_group' => $this->id_pack_group);
        $packs = Pack::model()->findAll($criteria);
        $total = 0;
        foreach ($packs as $pack) {
            if (isset($pack->idProductAttribute)) {
                $total += $pack->idProductAttribute->price*$pack->quantity;
            } else {
                $total += $pack->idProduct->price*$pack->quantity;
            }
        }

        if (isset($this->reduction_type) && ($this->reduction_type == 'percentage')) {
            $total = round($total - $total * ($this->reduction / 100), -3);
        } elseif (isset($this->reduction_type) && ($this->reduction_type == 'amount')) {
            $total = $total - $this->reduction;
        } else {
            return $this->total_paid_real = $this->total_paid;
        }
        $this->total_paid_real = $total;
        return $total;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PackGroup the static model class
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
