<?php

/**
 * This is the model class for table "tbl_specific_price_rule".
 *
 * The followings are the available columns in table 'tbl_specific_price_rule':
 * @property string $id_specific_price_rule
 * @property string $name
 * @property string $price
 * @property integer $from_quantity
 * @property string $reduction
 * @property string $reduction_type
 * @property string $from
 * @property string $to
 *
 * The followings are the available model relations:
 * @property ProductHotDeal[] $productHotDeals
 * @property SpecificPrice[] $specificPrices
 */
class SpecificPriceRule extends CActiveRecord {

    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d H:i:s';
    public $old_from;
    public $old_to;
    public $fullname;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_specific_price_rule';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, from_quantity, reduction, reduction_type', 'required'),
            array('from_quantity', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('price, reduction', 'length', 'max' => 20),
            array('from, to', 'type', 'type' => 'date', 'allowEmpty' => false, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('from, to, reduction_type', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('fullname, id_specific_price_rule, name, price, from_quantity, reduction, reduction_type, from, to', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productHotDeals' => array(self::HAS_MANY, 'ProductHotDeal', 'id_specific_price_rule'),
            'specificPrices' => array(self::HAS_MANY, 'SpecificPrice', 'id_specific_price_rule'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_specific_price_rule' => 'Mã Qui Luật Giá',
            'name' => 'Tên Qui Luật',
            'price' => 'Giá',
            'from_quantity' => 'Từ Số Lượng',
            'reduction' => 'Giá Trị Giảm',
            'reduction_type' => 'Loại Giảm Giá',
            'from' => 'Từ Ngày',
            'to' => 'Đến Ngày',
            'fullname' => 'Tên đầy đủ'
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

        $criteria->compare('id_specific_price_rule', $this->id_specific_price_rule, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('from_quantity', $this->from_quantity);
        $criteria->compare('reduction', $this->reduction, true);
        $criteria->compare('reduction_type', $this->reduction_type, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, reduction_type, price ASC';
        $sort->attributes = array(
            'name' => 'name',
            'price' => 'price',
            'reduction_type' => 'reduction_type'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 5),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SpecificPriceRule the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function comparedate() {
        if (isset($this->from, $this->to) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->from) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->to)) {
            $date1 = DateTime::createFromFormat($this->in_format, $this->from);
            $from = $date1->format($this->out_format);
            $date2 = DateTime::createFromFormat($this->in_format, $this->to);
            $to = $date2->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);
            if ((strcmp($from, $current) >= 0) && (strcmp($to, $current) >= 0) && (strcmp($from, $to) <= 0))
                return true;
            else {
                if ((strcmp($from, $current) < 0)) {
                    $this->addError('from', 'Ngày nhập phải lớn hơn ngày hiện tại');
                }

                if ((strcmp($to, $from) < 0)) {
                    $this->addError('to', 'Ngày nhập phải lớn hơn ngày hiện tại hoặc Ngày bắt đầu');
                }
                return false;
            }
        } else {
            if (!empty($this->from) && !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->from))) {
                $this->addError('from', 'Ngày nhập không chính xác. Bạn nên sử dụng tools đã cung cấp để thiết lập ngày bán sản phẩm.');
            }
            if (!empty($this->to) && !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->to))) {
                $this->addError('to', 'Ngày nhập không chính xác. Bạn nên sử dụng tools đã cung cấp để thiết lập ngày bán sản phẩm.');
            }
            return false;
        }
    }

    public function beforeValidate() {
        if ($this->comparedate()) {
            $date1 = DateTime::createFromFormat($this->in_format, $this->from);
            $from = $date1->format($this->out_format);
            $date2 = DateTime::createFromFormat($this->in_format, $this->to);
            $to = $date2->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);
            if (!$this->isNewRecord && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_from) && ($this->old_from != $this->from) && ($from < $current)) {
                $this->addError('from', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
            if (!$this->isNewRecord && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_to) && ($this->old_to != $this->from) && ($from < $current)) {
                $this->addError('to', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
        } else {
            if (!$this->isNewRecord) {
                $this->from = $this->old_from;
                $this->to = $this->old_to;
            }
        }
        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (isset($this->from, $this->to)) {
            $date1 = DateTime::createFromFormat($this->in_format, $this->from);
            $this->from = $date1->format($this->out_format);
            $date2 = DateTime::createFromFormat($this->in_format, $this->to);
            $this->to = $date2->format($this->out_format);
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if (isset($this->from) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->from)) {
            $date = DateTime::createFromFormat($this->in_format, $this->from);
            $this->from = $date->format($this->out_format);
        }
        if (isset($this->to) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->to)) {
            $date = DateTime::createFromFormat($this->in_format, $this->to);
            $this->to = $date->format($this->out_format);
        }
        return parent::afterSave();
    }

    public function afterFind() {
        if (isset($this->from, $this->to)) {
            $date1 = DateTime::createFromFormat($this->out_format, $this->from);
            $this->old_from = $this->from = $date1->format($this->in_format);
            $date2 = DateTime::createFromFormat($this->out_format, $this->to);
            $this->old_to = $date2->format($this->in_format);
        }
        $this->fullname = $this->name.' ['.$this->reduction.'] '.((strcasecmp($this->reduction_type, 'percentage')==0)?'%':'VND');
        return parent::afterFind();
    }

}
