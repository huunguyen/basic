<?php
/**
 * This is the model class for table "tbl_manufacturer".
 *
 * The followings are the available columns in table 'tbl_manufacturer':
 * @property string $id_manufacturer
 * @property string $name
 * @property string $date_add
 * @property string $date_upd
 * @property integer $active
 * @property string $description
 * @property string $description_short
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property Address[] $addresses
 * @property Menu[] $menus
 * @property Product[] $products
 * @property Slider[] $sliders
 */
class Manufacturer extends CActiveRecord {

    const TYPE = "man";
    public $logo;
    public $old_logo;
    public $thumbnail;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_manufacturer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, date_add, date_upd', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('meta_title, meta_keywords, meta_description, slug', 'length', 'max' => 45),
            array('description, description_short', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_manufacturer, name, date_add, date_upd, active, description, description_short, meta_title, meta_keywords, meta_description, slug', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'addresses' => array(self::HAS_MANY, 'Address', 'id_manufacturer'),
            'menus' => array(self::HAS_MANY, 'Menu', 'id_manufacturer'),
            'products' => array(self::HAS_MANY, 'Product', 'id_manufacturer'),
            'sliders' => array(self::HAS_MANY, 'Slider', 'id_manufacturer'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_manufacturer' => 'Mã nhà sản xuất',
            'name' => 'Tên',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'active' => 'Trạng thái',
            'description' => 'Mô tả',
            'description_short' => 'Mô tả ngắn',
            'meta_title' => 'Meta Tiêu đề',
            'meta_keywords' => 'Meta Từ khóa',
            'meta_description' => 'Meta Mô tả',
            'slug' => 'Slug',
            'logo' => 'Ảnh đại diễn'
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

        $criteria->compare('id_manufacturer', $this->id_manufacturer, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_short', $this->description_short, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('slug', $this->slug, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_manufacturer, name ASC';
        $sort->attributes = array(
            'id_manufacturer' => 'id_manufacturer',
            'name' => 'name'
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
     * @return Manufacturer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeValidate() {
        $this->slug = PostHelper::TitleVNtoEN($this->name);
        return parent::beforeValidate();
    }

    public function afterSave() {
        $this->slug = PostHelper::TitleVNtoEN($this->name) . "_" . PostHelper::id4slug($this->id_manufacturer, 'n');
        $this->updateByPk($this->id_manufacturer, array('slug' => $this->slug));
        return parent::afterSave();
    }

    public function afterFind() {
        $this->old_logo = $this->logo = ImageHelper::FindImageByPk(self::TYPE, $this->id_manufacturer);        
        try {
            if ($this->logo !== null) {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->logo, self::TYPE, "50x50"));
            } else {
                $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        return parent::afterFind();
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
