<?php

/**
 * This is the model class for table "tbl_hot_deal".
 *
 * The followings are the available columns in table 'tbl_hot_deal':
 * @property string $id_hot_deal
 * @property string $id_user
 * @property string $name
 * @property string $description
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property HotDealValue[] $hotDealValues
 * @property ProductHotDeal[] $productHotDeals
 */
class HotDeal extends CActiveRecord {

    public $ex_info;
    
    public $pp_giao_sp;
    public $dc_giao_sp;
    public $pp_thanhtoan;
    
    public $old_pp_giao_sp;
    public $old_dc_giao_sp;
    public $old_pp_thanhtoan;
    
    public $rule;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_hot_deal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_add, pp_giao_sp, dc_giao_sp, pp_thanhtoan, name, description', 'required'),
            array('id_user', 'length', 'max' => 10),
            array('name, description', 'length', 'max' => 45),
            array('id_user, date_upd', 'safe'),
            array('pp_thanhtoan, pp_giao_sp, dc_giao_sp', 'normalizeTags'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rule, pp_thanhtoan, pp_giao_sp, dc_giao_sp, ex_info, id_hot_deal, id_user, name, description, date_add, date_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'hotDealValues' => array(self::HAS_MANY, 'HotDealValue', 'id_hot_deal'),
            'productHotDeals' => array(self::HAS_MANY, 'ProductHotDeal', 'id_hot_deal'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_hot_deal' => 'Mã CT Giá Rẻ',
            'id_user' => 'Mã Nhân Viên',
            'name' => 'Tên Chương Trình',
            'description' => 'Mô Tả',
            'date_add' => 'Ngày Tạo',
            'date_upd' => 'Ngày Cập Nhật',
            'ex_info' => 'Thông tin bổ sung',
            'pp_giao_sp' => 'Phương Thức Giao Hàng',
            'dc_giao_sp' => 'Khu Vực Hổ Trợ Giao Hàng Miễn Phí',
            'pp_thanhtoan' => 'Phương Thức Thanh Toán',
            'rule' => 'Qui luật áp giá'
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

        $criteria->compare('id_hot_deal', $this->id_hot_deal, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, description ASC';
        $sort->attributes = array(
            'name' => 'name',
            'description' => 'description'
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
     * @return HotDeal the static model class
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

    /*
     * http://www.yiiframework.com/forum/index.php/topic/27401-additional-columns-for-cgridview-with-data-provider/
     * http://www.yiiframework.com/wiki/278/cgridview-render-customized-complex-datacolumns/
     */

    public function getStringInfo() {
        $rs = '';
        foreach ($this->hotDealValues as $hotdealvalue) {
            if (isset($hotdealvalue) && !empty($hotdealvalue)) {
                $rs .= '[' . $hotdealvalue->custom_name . ':[<b>' . $hotdealvalue->custom_value . '</b>]] ';
            }
        }
        return $rs;
    }

    /**
     * Normalizes the user-entered tags.
     */
    public function normalizeTags($attribute, $params) {
        $this->{$attribute} = HotDealValue::array2string(array_unique(HotDealValue::string2array($this->$attribute)));
    }

    public function afterSave() {
        $method = new HotDealValue;
        if (isset($this->pp_giao_sp)) {
            $method->id_hot_deal = $this->getPrimaryKey();
            $method->custom_name = 'pp_giao_sp';
            $method->custom_value = HotDealValue::array2string(array_unique(HotDealValue::string2array($this->pp_giao_sp)));
            $method->updateRecord();
        }

        $place = new HotDealValue;
        if (isset($this->dc_giao_sp)) {
            $place->id_hot_deal = $this->getPrimaryKey();
            $place->custom_name = 'dc_giao_sp';
            $place->custom_value = $this->dc_giao_sp;
            $place->updateRecord();
        }

        $bill = new HotDealValue;
        if (isset($this->pp_thanhtoan)) {
            $bill->id_hot_deal = $this->getPrimaryKey();
            $bill->custom_name = 'pp_thanhtoan';
            $bill->custom_value = $this->pp_thanhtoan;
            $bill->updateRecord();
        }

        return parent::afterSave();
    }

    public function afterFind() {
        $methods = HotDealValue::model()->findAllByAttributes(array('id_hot_deal' => $this->getPrimaryKey(), 'custom_name' => 'pp_giao_sp'));
        if ($methods != NULL) {
            $flag = true;
            foreach ($methods as $method) {
                if ($flag) {
                    $this->pp_giao_sp = $method->custom_value;
                    $flag = false;
                } else {
                    $this->pp_giao_sp .= "," . $method->custom_value;
                }
            }
        }

        $places = HotDealValue::model()->findAllByAttributes(array('id_hot_deal' => $this->getPrimaryKey(), 'custom_name' => 'dc_giao_sp'));
        if ($places != NULL) {
            $flag = true;
            foreach ($places as $place) {
                if ($flag) {
                    $this->dc_giao_sp = $place->custom_value;
                    $flag = false;
                } else {
                    $this->dc_giao_sp .= "," . $place->custom_value;
                }
            }
        }

        $bills = HotDealValue::model()->findAllByAttributes(array('id_hot_deal' => $this->getPrimaryKey(), 'custom_name' => 'pp_thanhtoan'));
        if ($bills != NULL) {
            $flag = true;
            foreach ($bills as $bill) {
                if ($flag) {
                    $this->pp_thanhtoan = $bill->custom_value;
                    $flag = false;
                } else {
                    $this->pp_thanhtoan .= "," . $bill->custom_value;
                }
            }
        }
        return parent::afterFind();
    }

}
