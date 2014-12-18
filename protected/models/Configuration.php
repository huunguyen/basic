<?php

/**
 * This is the model class for table "tbl_configuration".
 *
 * The followings are the available columns in table 'tbl_configuration':
 * @property string $id_configuration
 * @property string $id_store_group
 * @property string $id_store
 * @property string $name
 * @property string $value
 * @property string $date_add
 * @property string $date_upd
 *
 * The followings are the available model relations:
 * @property Store $idStore
 * @property StoreGroup $idStoreGroup
 */
class Configuration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_configuration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, value', 'required'),
			array('id_store_group, id_store', 'length', 'max'=>10),
			array('name', 'length', 'max'=>128),
                     array('name', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'on' => 'create, update, insert',
                'message' => 'Tên phải là ký tự, số ,ký tự "_" và không được có khoảng trắng. '),
                    array('value', 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/u', 'on' => 'create, update, insert',
                'message' => 'Gía trị chỉ được gõ ký tự, số ,ký tự "_-" và không được có khoảng trắng. '),
			array('description, value, date_upd, date_add', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_configuration, id_store_group, id_store, name, value, date_add, date_upd', 'safe', 'on'=>'search'),
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
			'idStore' => array(self::BELONGS_TO, 'Store', 'id_store'),
			'idStoreGroup' => array(self::BELONGS_TO, 'StoreGroup', 'id_store_group'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_configuration' => 'Mã thiết lập',
			'id_store_group' => 'Mã nhóm',
			'id_store' => 'Mã chi nhánh [Site]',
			'name' => 'Tên',
			'value' => 'Giá trị',
                    'description' => 'Mô tả',
			'date_add' => 'Ngày tạo',
			'date_upd' => 'Ngày cập nhật',
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

		$criteria->compare('id_configuration',$this->id_configuration,true);
		$criteria->compare('id_store_group',$this->id_store_group,true);
		$criteria->compare('id_store',$this->id_store,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		$sort = new CSort;
        $sort->defaultOrder = 'date_upd, date_add, name, value ASC';
        $sort->attributes = array(            
            'date_upd' => 'date_upd',
            'date_add' => 'date_add',
            'name' => 'name',
            'value' => 'value'
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

	public function searchByBranch(Store $store)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_store',$store->id_store,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		$sort = new CSort;
        $sort->defaultOrder = 'name, value ASC';
        $sort->attributes = array(
            'name' => 'name',
            'value' => 'value'
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
        
public function searchByGroup(StoreGroup $storegroup)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_store_group',$storegroup->id_store_group,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_upd',$this->date_upd,true);

		$sort = new CSort;
        $sort->defaultOrder = 'name, value ASC';
        $sort->attributes = array(
            'name' => 'name',
            'value' => 'value'
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
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Configuration the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
