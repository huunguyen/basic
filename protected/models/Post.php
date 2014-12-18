<?php

/**
 * This is the model class for table "tbl_post".
 *
 * The followings are the available columns in table 'tbl_post':
 * @property string $id_post
 * @property string $id_user_add
 * @property string $id_user_upd
 * @property string $id_store
 * @property string $id_category
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $attach_file
 * @property string $tags
 * @property string $date_add
 * @property string $date_upd
 * @property integer $counting
 * @property string $comment_state
 * @property string $categories
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 * @property Category $idCategory
 * @property User $idUserAdd
 * @property User $idUserUpd
 * @property Store $idStore
 */
class Post extends CActiveRecord {

    const TYPE = "pst";

    public $old_img;
    public $img;
    public $thumbnail;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public $info;
    public $_oldTags;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_post';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_category, title, slug, content, categories, comment_state, status', 'required'),
            array('counting', 'numerical', 'integerOnly' => true),
            array('id_user_add, id_user_upd, id_store, id_category', 'length', 'max' => 10),
            array('title', 'length', 'max' => 230),
            array('slug, attach_file', 'length', 'max' => 255),
            array('comment_state', 'length', 'max' => 8),
            array('categories', 'length', 'max' => 11),
            array('status', 'length', 'max' => 9),
            array('info, id_user_add, tags, date_add, date_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('info, id_post, id_user_add, id_user_upd, id_store, id_category, title, slug, content, attach_file, tags, date_add, date_upd, counting, comment_state, categories, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'comments' => array(self::HAS_MANY, 'Comment', 'id_post'),
            'idCategory' => array(self::BELONGS_TO, 'Category', 'id_category'),
            'categories' => array(self::MANY_MANY, 'Category', 'tbl_post_category(post_id, category_id)'),
            'idUserAdd' => array(self::BELONGS_TO, 'User', 'id_user_add'),
            'idUserUpd' => array(self::BELONGS_TO, 'User', 'id_user_upd'),
            'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
            //'comments' => array(self::HAS_MANY, 'Comment', 'post_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'condition' => 'comments.status=' . Comment::STATUS_PUBLISHED, 'order' => 'comments.date_add DESC'),
            'commentCount' => array(self::STAT, 'Comment', 'post_id', 'condition' => 'status=' . Comment::STATUS_PUBLISHED),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_post' => 'Mã Bài',
            'id_user_add' => 'Tác giả',
            'id_user_upd' => 'Người cập nhật',
            'id_store' => 'Chi nhánh',
            'id_category' => 'Danh mục',
            'title' => 'Tiêu đề',
            'slug' => 'từ khóa',
            'content' => 'Nội dung',
            'attach_file' => 'Tin đính kèm',
            'tags' => 'Nhãn',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'counting' => 'bộ đếm',
            'comment_state' => 'Loại phản hồi',
            'categories' => 'Loại tin',
            'status' => 'Trạng thái',
            'img' => 'Hình Ảnh',
            'info' => 'Tóm tắt'
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

        $criteria->compare('id_post', $this->id_post, true);
        $criteria->compare('id_store', $this->id_store, true);
        $criteria->compare('id_category', $this->id_category, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('counting', $this->counting);
        $criteria->compare('comment_state', $this->comment_state, true);
        $criteria->compare('categories', $this->categories, true);
        $criteria->compare('status', $this->status, true);

        $sort = new CSort;
        $sort->defaultOrder = 'title, date_add ASC';
        $sort->attributes = array(
            'title' => 'title',
            'date_add' => 'date_add'
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

    public function searchByLastMonth($days = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if (!isset($days) || !is_numeric($days))
            $days = 60 * 60 * 24 * 30; // 30 days
        $begin = date('Y-m-d H:i:s', time() - $days);
        $end = date('Y-m-d H:i:s', time());


        $criteria = new CDbCriteria;
        $criteria->addCondition('("' . $begin . '" < date_add) AND (date_add < "' . $end . '") ');
        $criteria->compare('title', $this->title, true);

        $sort = new CSort;
        $sort->defaultOrder = 'title, date_add ASC';
        $sort->attributes = array(
            'title' => 'title',
            'date_add' => 'date_add'
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
     * Normalizes the user-entered tags.
     */
    public function normalizeTags($attribute, $params) {
        $this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }

    /**
     * This is invoked when a record is populated with data from a find() call.
     */
    protected function afterFind() {
        $this->old_img = $this->img = ImageHelper::FindImageByPk(self::TYPE, $this->getPrimaryKey());
        if ($this->img !== null) {
            $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->img, self::TYPE, "50x50"));
        } else {
            $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
        }

        $findInfoOkie = false;
        if (preg_match('/<section id="info" class="info"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
            $this->info = $info[1];
            $findInfoOkie = true;
        } elseif (preg_match('/<section\s+id="info"\s+class="info"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
            $this->info = $info[1];
            $findInfoOkie = true;
        }

        $findMainBodyOkie = false;
        if ($findInfoOkie) {
            if (preg_match('/<section id="mainbody" class="mainbody"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
                $this->content = $info[1];
                $findMainBodyOkie = true;
            } elseif (preg_match('/<section\s+id="mainbody"\s+class="mainbody"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
                $this->content = $info[1];
                $findMainBodyOkie = true;
            }
            if ($findMainBodyOkie)
                $this->content = preg_replace('@<section(.*)>@siU', '', $this->content);
        }

        if ((!$findInfoOkie) || (!$findMainBodyOkie)) {
            $items = explode("<!--end_info_and_start_mainbody-->", $this->content);
            $this->info = ($findInfoOkie) ? $this->info : $items[0];
            $this->content = ($findMainBodyOkie) ? $this->content : $items[1];
            $this->content = preg_replace('@<section(.*)>@siU', '', $this->content);
        }

        $this->_oldTags = $this->tags;
        return parent::afterFind();
    }

    /**
     * Adds a new comment to this post.
     * This method will set status and post_id of the comment accordingly.
     * @param Comment the comment to be added
     * @return boolean whether the comment is saved successfully
     */
    public function addComment($comment) {
        $comment->post_id = $this->id;
        return $comment->save();
    }

    public function beforeValidate() {
        $this->slug = PostHelper::TitleVNtoEN($this->title);
        return parent::beforeValidate();
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->id_user_add = Yii::app()->user->id;
        } else {
            $this->id_user_upd = Yii::app()->user->id;
        }
        $this->content = '<section id="info" class="info">' . $this->info . '</section>' . "<!--end_info_and_start_mainbody-->" . '<section id="mainbody" class="mainbody">' . $this->content . '</section>';
        return parent::beforeSave();
    }

    /**
     * This is invoked after the record is saved.
     */
    protected function afterSave() {
        Tag::model()->updateFrequency($this->_oldTags, $this->tags);

        $this->old_img = $this->img = ImageHelper::FindImageByPk(self::TYPE, $this->getPrimaryKey());
        if ($this->img != null) {
            $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias("uploads") . DIRECTORY_SEPARATOR . self::TYPE . DIRECTORY_SEPARATOR . "thumbnail" . DIRECTORY_SEPARATOR . ImageHelper::GetThumbnail($this->img, self::TYPE, "50x50"));
        } else {
            $this->thumbnail = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'logo.png');
        }

        $findInfoOkie = false;
        if (preg_match('/<section id="info" class="info"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
            $this->info = $info[1];
            $findInfoOkie = true;
        } elseif (preg_match('/<section\s+id="info"\s+class="info"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
            $this->info = $info[1];
            $findInfoOkie = true;
        }

        $findMainBodyOkie = false;
        if ($findInfoOkie) {
            if (preg_match('/<section id="mainbody" class="mainbody"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
                $this->content = $info[1];
                $findMainBodyOkie = true;
            } elseif (preg_match('/<section\s+id="mainbody"\s+class="mainbody"[^>]*>(.*)<\/section>/msiU', $this->content, $info)) {
                $this->content = $info[1];
                $findMainBodyOkie = true;
            }
            if ($findMainBodyOkie)
                $this->content = preg_replace('@<section(.*)>@siU', '', $this->content);
        }

        if ((!$findInfoOkie) || (!$findMainBodyOkie)) {
            $items = explode("<!--end_info_and_start_mainbody-->", $this->content);
            $this->info = ($findInfoOkie) ? $this->info : $items[0];
            $this->content = ($findMainBodyOkie) ? $this->content : $items[1];
            $this->content = preg_replace('@<section(.*)>@siU', '', $this->content);
        }
        return parent::afterSave();
    }

    /**
     * This is invoked after the record is deleted.
     */
    protected function afterDelete() {
        Tag::model()->updateFrequency($this->tags, '');
        return parent::afterDelete();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Post the static model class
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
