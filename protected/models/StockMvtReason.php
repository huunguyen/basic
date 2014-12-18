<?php

/**
 * This is the model class for table "tbl_stock_mvt_reason".
 *
 * The followings are the available columns in table 'tbl_stock_mvt_reason':
 * @property string $id_stock_mvt_reason
 * @property integer $sign
 * @property string $date_add
 * @property string $date_upd
 * @property integer $deleted
 * @property string $name
 *
 * The followings are the available model relations:
 * @property StockMvt[] $stockMvts
 */
class StockMvtReason extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_stock_mvt_reason';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_add, date_upd, name', 'required'),
            array('sign, deleted', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_stock_mvt_reason, sign, date_add, date_upd, deleted, name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'stockMvts' => array(self::HAS_MANY, 'StockMvt', 'id_stock_mvt_reason'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_stock_mvt_reason' => 'Mã Chuyển Stock',
            'sign' => 'Dấu hiệu',
            'date_add' => 'Ngày Tạo',
            'date_upd' => 'Ngày Cập Nhật',
            'deleted' => 'Được xóa',
            'name' => 'Tên - Nội Dung',
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

        $criteria->compare('id_stock_mvt_reason', $this->id_stock_mvt_reason, true);
        $criteria->compare('sign', $this->sign);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StockMvtReason the static model class
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
