<?php

/**
 * This is the model class for table "tbl_auth_item".
 *
 * The followings are the available columns in table 'tbl_auth_item':
 * @property string $name
 * @property string $title
 * @property string $salt
 * @property integer $level
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property User[] $tblUsers
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren1
 */
class AuthItem extends CActiveRecord {

    public $old_name;
    public $str_roles;
    public $str_role;
    public $str_task;
    public $str_operator;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_auth_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type', 'required'),
            array('level, type', 'numerical', 'integerOnly' => true),
            array('name, title', 'length', 'max' => 64),
            array('salt', 'length', 'max' => 255),
            array('description, bizrule, data', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('old_name, str_roles, str_role, str_task, str_operator, name, title, salt, level, type, description, bizrule, data', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tblUsers' => array(self::MANY_MANY, 'User', 'tbl_auth_assignment(itemname, userid)'),
            'authItemChildren' => array(self::HAS_MANY, 'AuthItemChild', 'parent'),
            'authItemChildren1' => array(self::HAS_MANY, 'AuthItemChild', 'child'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'name' => 'Name',
            'title' => 'Title',
            'salt' => 'Salt',
            'level' => 'Level',
            'type' => 'Type',
            'description' => 'Description',
            'bizrule' => 'Bizrule',
            'data' => 'Data',
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

        $criteria->compare('name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        $sort = new CSort;
        $sort->defaultOrder = 'type, name ASC';
        $sort->attributes = array(
            'type' => 'type',
            'name' => 'name',
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
    public function searchByType($type = 0) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('type', $type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        $sort = new CSort;
        $sort->defaultOrder = 'type, name ASC';
        $sort->attributes = array(
            'type' => 'type',
            'name' => 'name',
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
    
public function searchByParent($parent, $type = 0) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $roles = array();
        $this->findAllOByParent($parent, $roles);
        
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);        
        $criteria->addInCondition('name', $roles);
        
        $criteria->compare('title', $this->title, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('type', $type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        $sort = new CSort;
        $sort->defaultOrder = 'type, name ASC';
        $sort->attributes = array(
            'type' => 'type',
            'name' => 'name',
        );

        $sort->applyOrder($criteria);
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($this));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState($uni_id . lcfirst(get_class($this)) . 'PageSize', 3),
                'currentPage' => Yii::app()->user->getState(get_class($this) . '_page', 0),
            ),
                )
        );
    }
    public function searchByNoParent($parent, $type = 0) {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $roles = array();
        $this->findAllOByParent($parent, $roles);
        
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);        
        $criteria->addNotInCondition('name', $roles);
        
        $criteria->compare('title', $this->title, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('type', $type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule, true);
        $criteria->compare('data', $this->data, true);

        $sort = new CSort;
        $sort->defaultOrder = 'type, name ASC';
        $sort->attributes = array(
            'type' => 'type',
            'name' => 'name',
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
    public function findAllRTOByParent($parent, &$roles) {
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $n => $authitemchild) {
                // if this role exist in array. we not need find its childs
                if (!in_array($n, $roles)) {
                    $roles[] = $n;
                    if ($auth->getItemChildren($authitemchild->name)) {
                        $this->findAllRTOByParent($authitemchild->name, $roles);
                    }
                }
            }
        }
        return $roles;
    }

    public function findAllRByParent($parent, &$roles) {
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $n => $authitemchild) {
                // if this role exist in array. we not need find its childs
                if (!in_array($n, $roles) && ($authitemchild->type == 2)) {
                    $roles[] = $n;
                    if ($auth->getItemChildren($authitemchild->name)) {
                        $this->findAllRByParent($authitemchild->name, $roles);
                    }
                }
            }
        }
        return $roles;
    }

    public function findAllTByParent($parent, &$roles) {
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $n => $authitemchild) {
                // if this role exist in array. we not need find its childs
                if (!in_array($n, $roles) && ($authitemchild->type == 1)) {
                    $roles[] = $n;
                    if ($auth->getItemChildren($authitemchild->name)) {
                        $this->findAllTByParent($authitemchild->name, $roles);
                    }
                }
            }
        }
        return $roles;
    }

    public function findAllOByParent($parent, &$roles) {
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $n => $authitemchild) {
                // if this role exist in array. we not need find its childs
                if (!in_array($n, $roles) && ($authitemchild->type == 0)) {
                    $roles[] = $n;
                    if ($auth->getItemChildren($authitemchild->name)) {
                        $this->findAllOByParent($authitemchild->name, $roles);
                    }
                }
            }
        }
        return $roles;
    }

    public function getStrRTOByParent() {
        $roles = array();
        $this->findAllRTOByParent($this->name, $roles);
        $rs = "";
        foreach ($roles as $role) {
            $rs .= "[" . $role . "] ";
        }
        return $rs;
    }

    public function getStrRTOByPType($type = -1) {
        $roles = array();
        $rs = "";
        switch ($type) {
            case 0:
                $this->findAllOByParent($this->name, $roles);
                foreach ($roles as $role) {
                    $rs .= "[" . $role . "] ";
                }
                break;
            case 1:
                $this->findAllTByParent($this->name, $roles);
                foreach ($roles as $role) {
                    $rs .= "[" . $role . "] ";
                }
                break;
            case 2:
                $this->findAllRByParent($this->name, $roles);
                foreach ($roles as $role) {
                    $rs .= "[" . $role . "] ";
                }
                break;
            default :
                $rs = "";
                break;
        }
        return $rs;
    }

    public function beforeValidate() {
        $auth = Yii::app()->authManager;
        if ($this->isNewRecord) {
            $item = $auth->getAuthItem($this->name);
            if ($item !== null)
                $this->addError('name', '{attribute} Quyền này đã có trong hệ thống.');
        }
        return parent::beforeValidate();
    }

    public function copyRole($old, $new) {
        return true;
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave() {
        $auth = Yii::app()->authManager;
        if (!$this->isNewRecord && isset($this->old_name) && ($this->old_name !== $this->name)) {
            if ($item = $auth->getAuthItem($this->old_name)) {
                $this->copyRole($this->old_name, $this->name);
            }
        }
        return parent::beforeSave();
    }

    public function afterFind() {
        $this->str_roles = $this->getStrRTOByParent();

        $this->str_role = $this->getStrRTOByPType($type = 2);
        $this->str_task = $this->getStrRTOByPType($type = 1);
        $this->str_operator = $this->getStrRTOByPType($type = 0);

        $this->old_name = $this->name;
        return parent::afterFind();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AuthItem the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
