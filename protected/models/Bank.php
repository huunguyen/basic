<?php

/**
 * This is the model class for table "tbl_bank".
 *
 * The followings are the available columns in table 'tbl_bank':
 * @property string $id_bank
 * @property string $fullname
 * @property string $name
 * @property string $description
 * @property string $code
 */
class Bank extends CActiveRecord {
    const TYPE = "bak";
    public $old_img;
    public $img;
    public $thumbnail;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_bank';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fullname, name, description, code', 'required'),
            array('fullname, name, description', 'length', 'max' => 250),
            array('active', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 16),
            array('id_user_add, id_user_upd', 'length', 'max' => 10),
            array('id_user_add,date_add,date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('active,id_bank, fullname, name, description, code', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->date_add=date('Y-m-d H:i:s');
            $this->id_user_add = Yii::app()->user->id;
        } else {
            $this->date_upd=date('Y-m-d H:i:s');
            $this->id_user_upd = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_bank' => 'Id Bank',
            'fullname' => 'Tên chủ khoản',
            'name' => 'Tên ngân hàng',
            'description' => 'Thông tin',
            'code' => 'Số tài khoản',
            'img' => 'Ảnh đại diện',
            'old_img' => 'Ảnh đại diện',
        );
    }

    public function afterFind() {
        $this->old_img = $this->img = ImageHelper::FindImageByPk(self::TYPE, $this->id_bank);
        try {
            if ($this->img !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR .$this->img);
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }

        return parent::afterFind();
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

        $criteria->compare('id_bank', $this->id_bank, true);
        $criteria->compare('fullname', $this->fullname, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('code', $this->code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Bank the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
