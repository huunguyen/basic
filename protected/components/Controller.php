<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    private $_metaDescription;
    private $_metaKeywords;
    private $_pageTitle;
    private $_assetsBase;
    private $_themeBase;
    private $_globalBase;
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/shop';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $items = array();

    public function getAssetsBase() {
        if ($this->_assetsBase === null) {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('application.assets'), false, -1, defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_assetsBase;
    }
    /**
     * 
     * @return type
     */
    public function getthemeBase() {
        if ($this->_themeBase === null) {
            $this->_themeBase = Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias("application.assets." . Yii::app()->theme->name), false, -1, defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_themeBase;
    }
/**
     * 
     * @return type
     */
    public function getGlobalBase() {
        if ($this->_globalBase === null) {
            $this->_globalBase = Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias("application.assets." . "global"), false, -1, defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_globalBase;
    }
    public function getMetaDescription() {
        if ($this->_metaDescription !== null)
            return $this->_metaDescription;
        else {
            $name = ucfirst(basename($this->getId()));
            if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
                return $this->_metaDescription = Yii::app()->name . ' - ' . ucfirst($this->getAction()->getId()) . ' ' . $name . ' | ' . Yii::app()->params['metaDKT'];
            else
                return $this->_metaDescription = Yii::app()->name . ' - ' . $name . ' | ' . Yii::app()->params['metaDKT'];
        }
    }

    public function setMetaDescription($value = "") {
        $name = ucfirst(basename($this->getId()));
        if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
            $this->_metaDescription = $value . ' | ' . Yii::app()->name . ' - ' . ucfirst($this->getAction()->getId()) . ' ' . $name . ' | ' . Yii::app()->params['metaDKT'];
        else
            $this->_metaDescription = $value . ' | ' . Yii::app()->name . ' - ' . $name . ' | ' . Yii::app()->params['metaDKT'];
    }

    public function getMetaKeywords() {
        if ($this->_metaKeywords !== null)
            return $this->_metaKeywords;
        else {
            $name = ucfirst(basename($this->getId()));
            if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
                return $this->_metaKeywords = Yii::app()->name . ' - ' . ucfirst($this->getAction()->getId()) . ' ' . $name . ' | ' . Yii::app()->params['metaDKT'];
            else
                return $this->_metaKeywords = Yii::app()->name . ' - ' . $name . ' | ' . Yii::app()->params['metaDKT'];
        }
    }

    public function setMetaKeywords($value = "") {
        $name = ucfirst(basename($this->getId()));
        if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
            $this->_metaKeywords = $value . ' | ' . Yii::app()->name . ' - ' . ucfirst($this->getAction()->getId()) . ' ' . $name . ' | ' . Yii::app()->params['metaDKT'];
        else
            $this->_metaKeywords = $value . ' | ' . Yii::app()->name . ' - ' . $name . ' | ' . Yii::app()->params['metaDKT'];
    }

    public function setPageTitle($value) {
        $name = ucfirst(basename($this->getId()));
        if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
            $this->_pageTitle = $value . ' | ' . Yii::app()->name . ' - ' . ucfirst($this->getAction()->getId()) . ' ' . $name . ' | ' . Yii::app()->params['metaDKT'];
        else
            $this->_pageTitle = $value . ' | ' . Yii::app()->name . ' - ' . $name . ' | ' . Yii::app()->params['metaDKT'];
    }

    public function getPageTitle() {
        if ($this->_pageTitle !== null)
            return $this->_pageTitle;
        else {
            $name = ucfirst(basename($this->getId()));
            if ($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction))
                return $this->_pageTitle = Yii::app()->name . ' - ' . ucfirst($this->getAction()->getId()) . ' ' . $name . ' | ' . Yii::app()->params['metaDKT'];
            else
                return $this->_pageTitle = Yii::app()->name . ' - ' . $name . ' | ' . Yii::app()->params['metaDKT'];
        }
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            /* @var $cs CClientScript */
            $cs = Yii::app()->clientScript;
            /* @var $theme CTheme */
            $theme = Yii::app()->theme->baseUrl;
            $baseUrl = Yii::app()->baseUrl;
            $cs->registerScript('Global_Vars', 'var baseUrl="' . $baseUrl . '"; var theme="' . $theme . '"; var assetsBase="' . $this->assetsBase . '";', CClientScript::POS_HEAD);
//        $cs->registerPackage('jquery');
//        $cs->registerPackage('history');
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/highlight.js' );
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.ba-dotimeout.min.js' );
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.scrollTo-1.4.3.1-min.js' );
//        //$cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.scrollTo-min.js' );
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/script.js' );
//        $cs->registerCssFile($theme->getBaseUrl() . '/css/reset.css');
//        $cs->registerCssFile($theme->getBaseUrl() . '/css/main.css');
            $cs->registerScript("Common_Init", "
                                jQuery(document).ready(function() {
                                    if ((typeof Layout !== 'undefined') && (&& Layout !== null)) {
                                        Layout.init();
                                        Layout.initNavScrolling();
                                    }       
                                });", CClientScript::POS_END);
            return true;
        }
        return false;
    }

    /**
     * appendClipboard() appends the clip named 'clipboard' to the clip of
     * the provided name, creating that clip if it doesn't already exist.
     *
     * @param object $controller View's controller
     * @param string $targetClip Name of clip to which to append clipboard
     */
    public static function appendClipboard($controller, $targetClip) {
        $oldClip = '';
        if (isset($controller->clips[$targetClip]))
            $oldClip = $controller->clips[$targetClip];
        $controller->beginClip($targetClip);
        echo $oldClip;
        echo $controller->clips['clipboard'];
        $controller->endClip($targetClip);
    }

}
