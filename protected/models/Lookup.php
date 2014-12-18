<?php

class Lookup extends CActiveRecord {

    /**
     * The followings are the available columns in table 'tbl_lookup':
     * @var integer $id
     * @var string $object_type
     * @var integer $code
     * @var string $name_en
     * @var string $name_fr
     * @var integer $sequence
     * @var integer $status
     */
    private static $_items = array();
    private static $_itemNames = array();
    private static $_itemPoss = array();

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_lookup';
    }

    /**
     * Returns the items for the specified type.
     * @param string item type (e.g. 'PostStatus').
     * @return array item names indexed by item code. The items are order by their position values.
     * An empty array is returned if the item type does not exist.
     */
    public static function items($type) {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        return self::$_items[$type];
    }

    public static function itemNames($type) {
        if (!isset(self::$_itemNames[$type]))
            self::loadItemNames($type);
        return self::$_itemNames[$type];
    }

    public static function itemPoss($type) {
        if (!isset(self::$_itemPoss[$type]))
            self::loadItemPoss($type);
        return self::$_itemPoss[$type];
    }

    public static function ranges($type) {
        if (!isset(self::$_items[$type]))
            self::loadRanges($type);
        return self::$_items[$type];
    }

    /**
     * Returns the item name for the specified type and code.
     * @param string the item type (e.g. 'PostStatus').
     * @param integer the item code (corresponding to the 'code' column value)
     * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
     */
    public static function item($type, $code) {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }

    /**
     * Returns the item name for the specified type and code.
     * @param string the item type (e.g. 'PostStatus').
     * @param integer the item code (corresponding to the 'code' column value)
     * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
     */
    public static function itempos($type, $name) {
        if (!isset(self::$_itemNames[$type]))
            self::loadItemNames($type);
        return isset(self::$_itemNames[$type][$name]) ? self::$_itemNames[$type][$name] : false;
    }

    /**
     * Returns the item name for the specified type and code.
     * @param string the item type (e.g. 'PostStatus').
     * @param integer the item code (corresponding to the 'code' column value)
     * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
     */
    public static function itemname($type, $pos) {
        if (!isset(self::$_itemPoss[$type]))
            self::loadItemPoss($type);
        return isset(self::$_itemPoss[$type][$pos]) ? self::$_itemPoss[$type][$pos] : false;
    }

    /*
     * Returns the item name for the specified type and code.
     * @param string the item type (e.g. 'PostStatus').
     * @param integer the item code (corresponding to the 'code' column value)
     * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
     */

    public static function secret($type, $code) {
        if (!isset(self::$_items[$type]))
            self::loadItems($type);
        return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
    }

    /*
     *
     * Loads the lookup items for the specified type from the database.
     * @param string the item type
     */

    private static function loadItems($type) {
        self::$_items[$type] = array();
        $models = self::model()->findAll(array(
            'condition' => 'type=:type',
            'params' => array(':type' => $type),
            'order' => 'position',
        ));
        foreach ($models as $model)
            self::$_items[$type][$model->code] = $model->name;
    }

    /*
     *
     * Loads the lookup items for the specified type from the database.
     * @param string the item type
     */

    private static function loadItemNames($type) {
        self::$_itemNames[$type] = array();
        $models = self::model()->findAll(array(
            'condition' => 'type=:type',
            'params' => array(':type' => $type),
            'order' => 'position',
        ));
        foreach ($models as $model)
            self::$_itemNames[$type][$model->name] = $model->position;
    }

    /*
     *
     * Loads the lookup items for the specified type from the database.
     * @param string the item type
     */

    private static function loadItemPoss($type) {
        self::$_itemPoss[$type] = array();
        $models = self::model()->findAll(array(
            'condition' => 'type=:type',
            'params' => array(':type' => $type),
            'order' => 'position',
        ));
        foreach ($models as $model)
            self::$_itemPoss[$type][$model->position] = $model->name;
    }

    private static function loadRanges($type) {
        self::$_items[$type] = array();
        $models = self::model()->findAll(array(
            'condition' => 'type=:type',
            'params' => array(':type' => $type),
            'order' => 'position',
        ));
        $i = 0;
        foreach ($models as $model) {
            self::$_items[$type][$i]['position'] = $model->position;
            self::$_items[$type][$i]['name'] = $model->name;
            $i++;
        }
    }

    public static function loadLookup($position, $type) {
        $model = self::model()->find(array(
            'condition' => 'type=:type and position=:position',
            'params' => array(':type' => $type, ':position' => $position),
        ));
        return $model;
    }

}