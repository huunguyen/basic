<?php

/**
 * This is the model class for table "tbl_tag".
 *
 * The followings are the available columns in table 'tbl_tag':
 * @property integer $id_tag
 * @property string $name
 * @property integer $frequency
 */
class Tag extends CActiveRecord
{
    public $id_product;
    public $id_product_attribute;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_tag';
	}

	/**
	 * @return array valid_tagation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required', 'message' => "Yêu cầu nhập thông tin {attribute} đầy đủ."),
			array('frequency', 'numerical', 'integerOnly'=>true),
			array('name, name_en', 'length', 'max'=>128, 'message' => "{attribute} quá dài ( tối đa {max} ký tự )."),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_tag, name, name_en, frequency', 'safe', 'on'=>'search'),
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
			'tblProducts' => array(self::MANY_MANY, 'Product', 'tbl_product_tag(id_tag, id_product)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tag' => 'Mã chính',
			'name' => 'Tên',
                    'name_en' => 'Tên duy nhất',
			'frequency' => 'Tần suất',
		);
	}
    /**
     * Returns tag names and their corresponding weights.
     * Only the tags with the top weights will be returned.
     * @param integer the maximum number of tags that should be returned
     * @return array weights indexed by tag names.
     */
    public function findTagWeights($limit=20)
    {
        $models=$this->findAll(array(
            'order'=>'frequency DESC',
            'limit'=>$limit,
        ));

        $total=0;
        foreach($models as $model)
            $total+=$model->frequency;

        $tags=array();
        if($total>0)
        {
            foreach($models as $model)
                $tags[$model->name]=8+(int)(16*$model->frequency/($total+10));
            ksort($tags);
        }
        return $tags;
    }

    /**
     * Suggests a list of existing tags matching the specified keyword.
     * @param string the keyword to be matched
     * @param integer maximum number of tags to be returned
     * @return array list of matching tag names
     */
    public function suggestTags($keyword,$limit=20)
    {
        $tags=$this->findAll(array(
            'condition'=>'name LIKE :keyword',
            'order'=>'frequency DESC, Name',
            'limit'=>$limit,
            'params'=>array(
                ':keyword'=>"%$keyword%",
            ),
        ));
        $names=array();
        foreach($tags as $tag)
            $names[]=$tag->name;
        return $names;
    }

    public static function string2array($tags)
    {
        return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tags)
    {
        return implode(', ',$tags);
    }
        
    public function updateFrequency($oldTags, $newTags)
    {
        $oldTags=self::string2array($oldTags);
        $newTags=self::string2array($newTags);
        $this->addTags(array_values(array_diff($newTags,$oldTags)));
        $this->removeTags(array_values(array_diff($oldTags,$newTags)));
    }
    
public function updateProductFrequency($oldTags, $newTags, $id_product)
    {
        $oldTags=self::string2array($oldTags);
        $newTags=self::string2array($newTags);
        $this->addProductTags(array_values(array_diff($newTags,$oldTags)), $id_product);
        $this->removeTags(array_values(array_diff($oldTags,$newTags)));
    }
    
    public function updateProAttFrequency($oldTags, $newTags, $id_product_attribute)
    {
        $oldTags=self::string2array($oldTags);
        $newTags=self::string2array($newTags);
        $this->addProAttTags(array_values(array_diff($newTags,$oldTags)), $id_product_attribute);
        $this->removeTags(array_values(array_diff($oldTags,$newTags)));
    }
    
    public function addTags($tags)
    {
        $criteria=new CDbCriteria;
        $criteria->addInCondition('name',$tags);
        $this->updateCounters(array('frequency'=>1),$criteria);
        foreach($tags as $name)
        {
            if(!$this->exists('name=:name',array(':name'=>$name)))
            {
                $tag=new Tag;
                $tag->name=$name;
                $tag->frequency=1;
                $tag->save();
            }
        }
    }
    
public function addProductTags($tags, $id_product)
    {
        $criteria=new CDbCriteria;
        $criteria->addInCondition('name',$tags);
        $this->updateCounters(array('frequency'=>1),$criteria);
        //dump($tags);dump($id_product);exit();
        foreach($tags as $name)
        {
            if(!$this->exists('name=:name',array(':name'=>$name)))
            {
                $tag=new Tag;
                $tag->name=$name;
                $tag->frequency=1;
                if($tag->save()){
                    $pro_tag = new ProductTag;
                    $pro_tag->id_product = $id_product;
                    $pro_tag->id_tag = $tag->getPrimaryKey();
                    $pro_tag->updateRecord();
                }
            }
            elseif($tag=Tag::model()->findByAttributes(array('name'=>$name))){
                $pro_tag = new ProductTag;                
                    $pro_tag->id_product = $id_product;
                    $pro_tag->id_tag = $tag->getPrimaryKey();
                    $pro_tag->updateRecord();
            }
            else{
                $tag=new Tag;
                $tag->name=$name;
                $tag->frequency=1;
                $tag->save(false);
            }
        }
    }
    public function addProAttTags($tags, $id_product_attribute)
    {
        $criteria=new CDbCriteria;
        $criteria->addInCondition('name',$tags);
        $this->updateCounters(array('frequency'=>1),$criteria);
        foreach($tags as $name)
        {
            if(!$this->exists('name=:name',array(':name'=>$name)))
            {
                $tag=new Tag;
                $tag->name=$name;
                $tag->frequency=1;
                if($tag->save()){
                    $proatt_tag = new ProductAttributeTag;
                    $proatt_tag->id_product_attribute = $id_product_attribute;
                    
                    $proatt = ProductAttribute::model()->findByPk($id_product_attribute);
                    $proatt_tag->id_product = $proatt->id_product;
                    
                    $proatt_tag->id_tag = $tag->getPrimaryKey();
                    $proatt_tag->updateRecord();
                }
            }
            elseif($tag=Tag::model()->findByAttributes(array('name'=>$name))){
                $proatt_tag = new ProductAttributeTag;
                    $proatt_tag->id_product_attribute = $id_product_attribute;
                    
                    $proatt = ProductAttribute::model()->findByPk($id_product_attribute);
                    $proatt_tag->id_product = $proatt->id_product;
                    
                    $proatt_tag->id_tag = $tag->getPrimaryKey();
                    $proatt_tag->updateRecord();
            }
            else{
                $tag=new Tag;
                $tag->name=$name;
                $tag->frequency=1;
                $tag->save(false);
            }
        }
    }
    public function removeTags($tags)
    {
        if(empty($tags))
            return;
        $criteria=new CDbCriteria;
        $criteria->addInCondition('name',$tags);
        $this->updateCounters(array('frequency'=>-1),$criteria);
        $this->deleteAll('frequency<=0');
    }
     public function removeProductTags($tags, $id_product)
    {
        if(empty($tags))
            return;
        $criteria=new CDbCriteria;
        $criteria->addInCondition('name',$tags);
        $this->updateCounters(array('frequency'=>-1),$criteria);
        $this->deleteAll('frequency<=0');
    }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return  the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_tag',$this->id_tag);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('frequency',$this->frequency);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function beforeValidate() {
            $this->name_en = PostHelper::TitleVNtoEN($this->name);
            return parent::beforeValidate();
        }
}