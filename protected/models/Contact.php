<?php

/**
 * This is the model class for table "tbl_contact".
 *
 * The followings are the available columns in table 'tbl_contact':
 * @property string $id_contact
 * @property string $email
 * @property integer $customer_service
 * @property integer $position
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property CustomerThread[] $customerThreads
 */
class Contact extends CActiveRecord {

    const TYPE = "con";

    public $old_img;
    public $img;
    public $thumbnail;
    public $old_position;
    public $min_position;
    public $max_position;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_contact';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, name, description', 'required'),
            array('customer_service, position', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 128),
            array('name', 'length', 'max' => 45),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_contact, email, customer_service, position, name, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customerThreads' => array(self::HAS_MANY, 'CustomerThread', 'id_contact'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_contact' => 'Mã liên lạc',
            'email' => 'Thư điện tử',
            'customer_service' => 'Loại Dịch vụ khách hàng',
            'position' => 'Vị trí',
            'name' => 'Tên dịch vụ',
            'description' => 'Mô tả',
            'img' => 'Ảnh đại diện',
            'old_img' => 'Ảnh cũ'
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

        $criteria->compare('id_contact', $this->id_contact, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('customer_service', $this->customer_service);
        $criteria->compare('position', $this->position);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);

        $sort = new CSort;
        $sort->defaultOrder = 'name, customer_service, email ASC';
        $sort->attributes = array(
            'name' => 'name',
            'customer_service' => 'customer_service',
            'email' => 'email',
        );
        
        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)).'PageSize', 20),
                'currentPage' => Yii::app()->user->getState(get_class($this).'_page', 0),
            ),
                )
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_contact DESC';
            if (empty($this->position)) {
                if ($contacts = self::model()->findAll($criteria)) {
                    foreach ($contacts as $contact) {
                        $this->position = ++$contact->position;
                        break;
                    }
                } else
                    $this->position = 0;
            }
            else {
                $criteria->compare('position', $this->position, true);
                if ($contacts = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_contact ASC';
                    $contacts2 = self::model()->findAll($criteria2);
                    foreach ($contacts2 as $contact2) {
                        $this->position = ++$contact2->max_position;
                        break;
                    }
                }
            }
        } 
        else 
            {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_contact ASC';
            if (($this->old_position != $this->position)) {
                $criteria->compare('position', $this->position, true);
                //$criteria->compare('id_contact', '<>'.$this->id_contact);
                if ($contacts = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_contact ASC';
                    $contacts2 = self::model()->findAll($criteria2);
                    foreach ($contacts2 as $contact2) {
                        $this->position = ++$contact2->max_position;
                        break;
                    }
                }
            }
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->old_img = $this->img = ImageHelper::FindImageByPk(self::TYPE, $this->id_contact);
        try {
            if ($this->img !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->img, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        $this->old_position = $this->position;
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Contact the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
