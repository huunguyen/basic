<?php

/**
 * This is the model class for table "tbl_pack".
 *
 * The followings are the available columns in table 'tbl_pack':
 * @property string $id_pack
 * @property string $id_pack_group
 * @property string $id_product
 * @property string $id_product_attribute
 * @property string $quantity
 *
 * The followings are the available model relations:
 * @property Product $idProduct
 * @property ProductAttribute $idProductAttribute
 * @property PackGroup $idPackGroup
 */
class Pack extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_pack';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pack_group, id_product, id_product_attribute', 'required'),
            array('id_pack, id_pack_group, id_product, id_product_attribute, quantity', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_pack, id_pack_group, id_product, id_product_attribute, quantity', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cartRules' => array(self::HAS_MANY, 'CartRule', 'id_pack'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'idProductAttribute' => array(self::BELONGS_TO, 'ProductAttribute', 'id_product_attribute'),
            'idPackGroup' => array(self::BELONGS_TO, 'PackGroup', 'id_pack_group'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_pack' => 'Mã mục trong gói',
            'id_pack_group' => 'Mã gói',
            'id_product' => 'Mã sản phẩm',
            'id_product_attribute' => 'Mã thuộc tính sản phẩm',
            'quantity' => 'Số lượng',
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

        $criteria->compare('id_pack', $this->id_pack, true);
        $criteria->compare('id_pack_group', $this->id_pack_group, true);
        $criteria->compare('id_product', $this->id_product, true);
        $criteria->compare('id_product_attribute', $this->id_product_attribute, true);
        $criteria->compare('quantity', $this->quantity, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_pack_group, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_pack_group' => 'id_pack_group',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute'
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

    public function searchByGroup($id_pack_group) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_pack_group', $id_pack_group);

        $sort = new CSort;
        $sort->defaultOrder = 'id_pack_group, id_product, id_product_attribute ASC';
        $sort->attributes = array(
            'id_pack_group' => 'id_pack_group',
            'id_product' => 'id_product',
            'id_product_attribute' => 'id_product_attribute'
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pack the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
