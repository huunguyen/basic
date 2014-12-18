<?php
class BEController extends CController
{
    private $_metaDescription;
    private $_metaKeywords;
    private $_pageTitle;
    private $_assetsBase;
    public $layout='//layouts/default';
    public $menu=array();
    public $breadcrumbs=array();
  
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
  
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
                'actions'=>array('login'),
            ),
            array('allow',
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
    
    public $items = array();
    
public function init() {
      if (Yii::app()->params['install'] == true) {
      $this->redirect(Yii::app()->getBaseUrl() . '/backend.php?r=install');
      }
      return parent::init();
      }
      
    public function getAssetsBase() {
        if ($this->_assetsBase === null) {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('application.assets'), false, -1, defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_assetsBase;
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
        if (strcasecmp($this->getAction()->getId(), $this->defaultAction))
            $this->_pageTitle = "QCDN - Quản trị hệ thống";
        else
            $this->_pageTitle = $value . ' | QCDN';
    }

    public function getPageTitle() {
        if ($this->_pageTitle === null) {
            $this->_pageTitle = "QCDN - Quản trị hệ thống";
        }
        return $this->_pageTitle;
    }    
    
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            /* @var $cs CClientScript */
            $cs = Yii::app()->clientScript;
            /* @var $theme CTheme */
            $theme = Yii::app()->theme->baseUrl;
            $baseUrl = Yii::app()->baseUrl;
            $cs->registerScript('global vars', 'var baseUrl="' . $baseUrl . '"; var theme="' . $theme . '"; var assetsBase="' . $this->assetsBase . '";', CClientScript::POS_HEAD);
//        $cs->registerPackage('jquery');
//        $cs->registerPackage('history');
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/highlight.js' );
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.ba-dotimeout.min.js' );
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.scrollTo-1.4.3.1-min.js' );
//        //$cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.scrollTo-min.js' );
//        $cs->registerScriptFile( $theme->getBaseUrl() . '/js/script.js' );
//        $cs->registerCssFile($theme->getBaseUrl() . '/css/reset.css');
//        $cs->registerCssFile($theme->getBaseUrl() . '/css/main.css');
            return true;
        }
        return false;
    }
}
?>