<?php

/**
 * This is the model class for table "tbl_slider_detail".
 *
 * The followings are the available columns in table 'tbl_slider_detail':
 * @property string $id_slider_detail
 * @property string $id_slider
 * @property string $image
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $position
 *
 * The followings are the available model relations:
 * @property Slider $idSlider
 */
class SliderDetail extends CActiveRecord {

    const TYPE = "sli";

    public $old_image;
    public $thumbnail;
    public $old_position;
    public $min_position;
    public $max_position;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_slider_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_slider', 'required'),
            array('id_slider, position', 'length', 'max' => 10),
            array('image, url, title, description', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_slider_detail, id_slider, image, url, title, description, position', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idSlider' => array(self::BELONGS_TO, 'Slider', 'id_slider'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_slider_detail' => 'Mã chi tiết trình chiếu',
            'id_slider' => 'Mã trình chiếu',
            'image' => 'Ảnh trình chiếu',
            'url' => 'Liên kết',
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'position' => 'Vị trí',
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

        $criteria->compare('id_slider_detail', $this->id_slider_detail, true);
        $criteria->compare('id_slider', $this->id_slider, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('position', $this->position, true);

        $sort = new CSort;
        $sort->defaultOrder = 'title, image ASC';
        $sort->attributes = array(
            'title' => 'title',
            'image' => 'image'
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
    public function searchBySlider($id_slider) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_slider', $id_slider);
        
        $sort = new CSort;
        $sort->defaultOrder = 'title, image ASC';
        $sort->attributes = array(
            'title' => 'title',
            'image' => 'image'
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

    public function beforeSave() {
        if ($this->isNewRecord) {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_slider_detail DESC';
            $criteria->compare('id_slider', $this->id_slider, true);
            if (!isset($this->position) || ($this->position == 0)) {
                if ($sliders = self::model()->findAll($criteria)) {
                    foreach ($sliders as $slider) {
                        $this->position = ++$slider->position;
                        break;
                    }
                } else
                    $this->position = 0;
            }
            else {
                $criteria->compare('position', $this->position, true);
                if ($sliders = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_slider_detail ASC';
                    $criteria2->compare('id_slider', $this->id_slider, true);
                    $sliders2 = self::model()->findAll($criteria2);
                    foreach ($sliders2 as $slider2) {
                        $this->position = ++$slider2->max_position;
                        break;
                    }
                }
            }
        } else {
            $criteria = new CDbCriteria();
            $criteria->order = 'position DESC, id_slider_detail ASC';
            if (($this->old_position != $this->position)) {
                $criteria->compare('position', $this->position, true);
                $criteria2->compare('id_slider', $this->id_slider, true);
                if ($sliders = self::model()->findAll($criteria)) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->select = array('*', 'max(position) as max_position');
                    $criteria2->order = 'position DESC, id_slider_detail ASC';
                    $criteria2->compare('id_parent', $this->id_parent, true);
                    $sliders2 = self::model()->findAll($criteria2);
                    foreach ($sliders2 as $slider2) {
                        $this->position = ++$slider2->max_position;
                        break;
                    }
                }
            }
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->old_image = $this->image = ImageHelper::FindImageByPk(self::TYPE, $this->id_slider_detail);
        try {
            if ($this->image !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->image, self::TYPE, "50x50"));
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
     * @return SliderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
