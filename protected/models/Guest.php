<?php

/**
 * This is the model class for table "tbl_guest".
 *
 * The followings are the available columns in table 'tbl_guest':
 * @property string $id_guest
 * @property string $id_operating_system
 * @property string $id_web_browser
 * @property string $id_customer
 * @property integer $screen_resolution_x
 * @property integer $screen_resolution_y
 *
 * The followings are the available model relations:
 * @property Cart[] $carts
 * @property Connections[] $connections
 * @property WebBrowser $idWebBrowser
 * @property Customer $idCustomer
 * @property OperatingSystem $idOperatingSystem
 * @property SearchWordGuest[] $searchWordGuests
 */
class Guest extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_guest';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('screen_resolution_x, screen_resolution_y', 'numerical', 'integerOnly' => true),
            array('id_operating_system, id_web_browser, id_customer, during_time', 'length', 'max' => 10),
            array('client_ip', 'length', 'max' => 32),
            array('date_join, during_time', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_guest, id_operating_system, id_web_browser, id_customer, screen_resolution_x, screen_resolution_y, client_ip, date_join, during_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'carts' => array(self::HAS_MANY, 'Cart', 'id_guest'),
            'connections' => array(self::HAS_MANY, 'Connections', 'id_guest'),
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idOperatingSystem' => array(self::BELONGS_TO, 'OperatingSystem', 'id_operating_system'),
            'idWebBrowser' => array(self::BELONGS_TO, 'WebBrowser', 'id_web_browser'),
            'searchWordGuests' => array(self::HAS_MANY, 'SearchWordGuest', 'id_guest'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_guest' => 'Id Guest',
            'id_operating_system' => 'Id Operating System',
            'id_web_browser' => 'Id Web Browser',
            'id_customer' => 'Id Customer',
            'screen_resolution_x' => 'Screen Resolution X',
            'screen_resolution_y' => 'Screen Resolution Y',
            'client_ip' => 'Client Ip',
            'date_join' => 'Date Join',
            'during_time' => 'During Time',
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

        $criteria->compare('id_guest', $this->id_guest, true);
        $criteria->compare('id_operating_system', $this->id_operating_system, true);
        $criteria->compare('id_web_browser', $this->id_web_browser, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('screen_resolution_x', $this->screen_resolution_x);
        $criteria->compare('screen_resolution_y', $this->screen_resolution_y);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Guest the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->date_join = date('Y-m-d H:i:s', time());
            $this->client_ip = BrowserHelper::get_client_ip();
        }
        else
        {
            $date_call = date('Y-m-d H:i:s', time());
            $this->during_time = strtotime($date_call) * 1000 - strtotime($this->date_join) * 1000;
        }
        return parent::beforeSave();
    }

    public function updateRecord() {
        $model = self::model()->findByPk($this->id_guest);
        //model is new, so create a copy with the keys set
        if (null === $model)
            $model = new self;
        $model->id_operating_system = $this->id_operating_system;
        $model->id_web_browser = $this->id_web_browser;
        $model->client_ip = BrowserHelper::get_client_ip();
        if (Yii::app()->user->isGuest)
            $model->id_customer = null;
        else
            $model->id_customer = $this->id_customer;
        $model->screen_resolution_x = $this->screen_resolution_x;
        $model->screen_resolution_x = $this->screen_resolution_x;
        $model->save(false);
        return $model;
    }

}
