<?php

/**
 * This is the model class for table "tbl_detail".
 *
 * The followings are the available columns in table 'tbl_detail':
 * @property string $id_detail
 * @property string $id_user
 * @property string $id_customer
 * @property string $lastname
 * @property string $firstname
 * @property string $question
 * @property string $answer
 * @property string $share_state
 * @property string $date_add
 * @property string $date_upd
 * @property string $company
 * @property string $birthday
 * @property string $note
 * @property string $site
 * @property string $gender
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Customer $idCustomer
 * @property User $idUser
 */
class Detail extends CActiveRecord {

    public $in_format = 'd/m/Y';
    public $out_format = 'Y-m-d';
    public $old_birthday;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('share_state, lastname, firstname,date_add, gender', 'required'),
            array('id_detail, id_user, id_customer, id_address_default', 'length', 'max' => 10),
            array('lastname, firstname', 'length', 'max' => 64),
            array('question, site', 'length', 'max' => 255),
            array('answer, company', 'length', 'max' => 45),
            array('share_state', 'length', 'max' => 16),
            array('gender', 'length', 'max' => 16),
            array('birthday', 'type', 'type' => 'date', 'allowEmpty' => true, 'message' => '{attribute}: không phải ngày!', 'dateFormat' => 'd/M/yyyy'),
            array('date_upd, birthday, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_detail, id_user, id_customer, lastname, firstname, question, answer, share_state, date_add, date_upd, company, birthday, note, site, gender, id_address_default', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'addresses' => array(self::HAS_MANY, 'Address', 'id_detail'),
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
            'idAddressDefault' => array(self::BELONGS_TO, 'Address', 'id_address_default'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_detail' => 'Mã chi tiết',
            'id_user' => 'Mã người dùng',
            'id_customer' => 'Mã khách hàng',
            'lastname' => 'Họ',
            'firstname' => 'Tên',
            'question' => 'Câu hỏi mật',
            'answer' => 'Câu trả lời',
            'share_state' => 'Tầm vực chia sẽ',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'company' => 'Công ty',
            'birthday' => 'Ngày sinh',
            'note' => 'Ghi chú',
            'site' => 'Web site',
            'gender' => 'Giới tính',
            'id_address_default' => 'Địa chỉ chính',
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

        $criteria->compare('id_detail', $this->id_detail, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('firstname', $this->firstname, true);
        $criteria->compare('question', $this->question, true);
        $criteria->compare('answer', $this->answer, true);
        $criteria->compare('share_state', $this->share_state, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('gender', $this->gender, true);

        $sort = new CSort;
        $sort->defaultOrder = 'lastname, firstname, gender ASC';
        $sort->attributes = array(
            'lastname' => 'lastname',
            'firstname' => 'firstname',
            'gender' => 'gender',
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
        if (!isset($this->birthday) || !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->birthday))) {
            if (!empty($this->birthday) && !(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->birthday))) {
                $this->birthday = null;
                //$this->addError('birthday', 'Ngày nhập không chính xác. Bạn nên sử dụng tools đã cung cấp để thiết lập ngày bán sản phẩm.');
            } else
                $this->birthday = null;
        } else {
            $date = DateTime::createFromFormat($this->in_format, $this->birthday);
            $birthday = $date->format($this->out_format);
            $today = new DateTime('now');
            $current = $today->format($this->out_format);

            if ($this->isNewRecord && ($birthday > $current)) {
                $this->addError('birthday', 'Ngày nhập phải lớn hơn ngày hiện tại');
            } elseif (isset($this->old_birthday) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->old_birthday) && ($this->old_birthday != $this->birthday) && ($birthday > $current)) {
                $this->addError('birthday', 'Ngày nhập phải lớn hơn ngày hiện tại');
            }
        }

        return parent::beforeValidate();
    }

    public function beforeSave() {
        if (isset($this->birthday)) {
            $date = DateTime::createFromFormat($this->in_format, $this->birthday);
            $this->birthday = $date->format($this->out_format);
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        if (isset($this->birthday) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $this->birthday)) {
            $date = DateTime::createFromFormat($this->in_format, $this->birthday);
            $this->birthday = $date->format($this->out_format);
        }
        return parent::afterSave();
    }

    public function afterFind() {
        if (isset($this->birthday)) {
            //dump($this->birthday);exit();
            $date = DateTime::createFromFormat($this->out_format, $this->birthday);
            $this->old_birthday = $this->birthday = $date->format($this->in_format);
        }
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Detail the static model class
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
