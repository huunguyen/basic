<?php

/**
 * This is the model class for table "tbl_auth_assignment".
 *
 * The followings are the available columns in table 'tbl_auth_assignment':
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 */
class AuthAssignment extends CActiveRecord
{
    public $str_roles;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_auth_assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, userid', 'required'),
			array('itemname', 'length', 'max'=>64),
			array('userid', 'length', 'max'=>10),
			array('bizrule, data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('str_roles, itemname, userid, bizrule, data', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'idUser' => array(self::BELONGS_TO, 'User', 'userid'),
                    'idAuthItem' => array(self::BELONGS_TO, 'AuthItem', 'itemname'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemname' => 'Itemname',
			'userid' => 'Userid',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		$sort = new CSort;
        $sort->defaultOrder = 'userid, itemname ASC';
        $sort->attributes = array(
            'userid' => 'userid',
            'itemname' => 'itemname',
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
          
        public function getStringAllRTOByParent() {
            $roles = array();
            $this->findAllRTOByParent($this->itemname, $roles);
            $rs = "";
            foreach ($roles as $role) {
                $rs .= "[".$role."] ";
            }
            return $rs;
        }
        
        public function afterFind() {
            $this->str_roles = $this->getStringAllRTOByParent();
            return parent::afterFind();
        }

        /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthAssignment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
