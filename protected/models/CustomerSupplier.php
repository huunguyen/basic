<?php

/**
 * This is the model class for table "tbl_customer_supplier".
 *
 * The followings are the available columns in table 'tbl_customer_supplier':
 * @property string $tbl_customer_supplier
 * @property string $id_customer
 * @property string $id_supplier
 * @property string $title
 * @property string $date_add
 * @property string $date_upd
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Customer $idCustomer
 * @property Supplier $idSupplier
 */
class CustomerSupplier extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_customer_supplier';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_customer, id_supplier', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('id_customer, id_supplier', 'length', 'max' => 10),
            array('title', 'length', 'max' => 128),
            array('date_add, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('tbl_customer_supplier, id_customer, id_supplier, title, date_add, date_upd, active', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idSupplier' => array(self::BELONGS_TO, 'Supplier', 'id_supplier'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tbl_customer_supplier' => 'Tbl Customer Supplier',
            'id_customer' => 'Id Customer',
            'id_supplier' => 'Id Supplier',
            'title' => 'Title',
            'date_add' => 'Date Add',
            'date_upd' => 'Date Upd',
            'active' => 'Active',
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

        $criteria->compare('tbl_customer_supplier', $this->tbl_customer_supplier, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('id_supplier', $this->id_supplier, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerSupplier the static model class
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
        $model = self::model()->findByAttributes(array('id_customer' => $this->id_customer, 'id_supplier' => $this->id_supplier));

        //model is new, so create a copy with the keys set
        if (null === $model) {
            //we don't use clone $this as it can leave off behaviors and events
            $model = new self;
            $model->id_customer = $this->id_customer;
            $model->id_supplier = $this->id_supplier;
        }
        $model->save(false);
        return $model;
    }

}
