<?php

/**
 * This is the model class for table "tbl_comment".
 *
 * The followings are the available columns in table 'tbl_comment':
 * @property string $id_comment
 * @property string $id_post
 * @property string $id_parent
 * @property string $id_user
 * @property string $id_customer
 * @property string $content
 * @property string $attach_file
 * @property string $date_add
 * @property string $date_upd
 * @property string $status
 * @property string $status_reason
 *
 * The followings are the available model relations:
 * @property AnswerCustomer[] $answerCustomers
 * @property Comment $idParent
 * @property Comment[] $comments
 * @property Post $idPost
 * @property Customer $idCustomer
 * @property User $idUser
 */
class Comment extends CActiveRecord {

    const STATUS_DRAFT = "DRAFT";
    const STATUS_PUBLISHED = "PUBLISHED";
    const STATUS_PENDING = "PENDING";
    const STATUS_DELETED = "DELETED";
    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
            array('id_post, id_product, id_parent, id_user, id_customer', 'length', 'max' => 10),
            array('attach_file, status_reason', 'length', 'max' => 255),
            array('status', 'length', 'max' => 9),
            array('date_add, date_upd', 'safe'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_comment, id_post, id_product, id_parent, id_user, id_customer, content, attach_file, date_add, date_upd, status, status_reason', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'answerCustomers' => array(self::HAS_MANY, 'AnswerCustomer', 'id_answer'),
            'idParent' => array(self::BELONGS_TO, 'Comment', 'id_parent'),
            'comments' => array(self::HAS_MANY, 'Comment', 'id_parent'),
            'idPost' => array(self::BELONGS_TO, 'Post', 'id_post'),
            'idCustomer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'idUser' => array(self::BELONGS_TO, 'User', 'id_user'),
            'idProduct' => array(self::BELONGS_TO, 'Product', 'id_product'),
            'commentsCount' => array(self::STAT, 'Comment', 'id_parent', 'condition' => 'status="' . self::STATUS_PUBLISHED . '"'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_comment' => 'Mã phản hồi',
            'id_post' => 'Mã bài đăng',
            'id_product' => 'Mã Sản phẩm',
            'id_parent' => 'Mã phản hồi Cha',
            'id_user' => 'Mã thành viên',
            'id_customer' => 'Mã khách hàng',
            'content' => 'Nội dung',
            'attach_file' => 'File đính kèm',
            'date_add' => 'Ngày tạo',
            'date_upd' => 'Ngày cập nhật',
            'status' => 'Trạng thái',
            'status_reason' => 'Lý do',
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

        $criteria->compare('id_comment', $this->id_comment, true);
        $criteria->compare('id_post', $this->id_post, true);
        $criteria->compare('id_parent', $this->id_parent, true);
        $criteria->compare('id_user', $this->id_user, true);
        $criteria->compare('id_customer', $this->id_customer, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('attach_file', $this->attach_file, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('status_reason', $this->status_reason, true);

         $sort = new CSort;
        $sort->defaultOrder = 'date_add, id_post ASC';
        $sort->attributes = array(
            'date_add' => 'date_add',
            'id_post' => 'id_post'
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
    public function searchByPost($id) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_comment', $this->id_comment, true);
        $criteria->compare('id_post', $id);
        $criteria->compare('id_parent', $this->id_parent, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('status', $this->status, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_parent, content, date_add ASC';
        $sort->attributes = array(
            'id_parent' => 'id_parent',
            'content' => 'content',
            'date_add' => 'date_add'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 2),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function searchByReply($id) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id_comment', $this->id_comment, true);
        $criteria->compare('id_parent', $id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_upd', $this->date_upd, true);
        $criteria->compare('status', $this->status, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_comment, content, date_add ASC';
        $sort->attributes = array(
            'id_comment' => 'id_comment',
            'content' => 'content',
            'date_add' => 'date_add'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 5),
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
        $criteria->compare('content', $this->content, true);

        $sort = new CSort;
        $sort->defaultOrder = 'id_comment, content, date_add ASC';
        $sort->attributes = array(
            'id_comment' => 'id_comment',
            'content' => 'content',
            'date_add' => 'date_add'
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 5),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }

    public function beforeValidate() {
        if (!isset($this->id_post) && !isset($this->id_product)) {
            $this->addError('id_post', 'Lỗi nhập liệu');
            $this->addError('id_product', 'Lỗi nhập liệu');
        } elseif (isset($this->id_post)) {
            $this->id_product = null;
        } else {
            $this->id_post = null;
        }
        return parent::beforeValidate();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comment the static model class
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

    public function replyComment($comment) {
        $comment->id_parent = $this->id_comment;
        $comment->id_post = $this->id_post;
        $comment->status_reason = "Trả lời phản hồi từ quản trị viên.";
        $comment->status = ($this->status == self::STATUS_PUBLISHED) ? $comment->status : $this->status;
        return $comment->save();
    }

}
