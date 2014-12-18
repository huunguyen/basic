<?php

class FeatureController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'update', 'cvalue', 'uvalue'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $value = New FeatureValue("seachByFeatureId");
        $value->unsetAttributes();  // clear any default values
        $value->id_feature = $model->id_feature;
        // This portion of code is belongs to Page size dropdown.
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($value));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($value)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($value)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET[get_class($value) . '_page'])) {
            $newsPage = (int) $_GET[get_class($value) . '_page'] - 1;
            Yii::app()->user->setState(get_class($value) . '_page', $newsPage);
            unset($_GET[get_class($value) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($value) . '_page', 0);
        }
        
        $this->render('view', array(
            'model' => $model,
            'value' => $value,
            'pageSize' => $pageSize,
        ));     
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Feature;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Feature'])) {
            $model->attributes = $_POST['Feature'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_feature));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Feature'])) {
            $model->attributes = $_POST['Feature'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_feature));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
/**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCvalue($id) {
        $feature = $this->loadModel($id);
        $model = new FeatureValue;
        if($feature!=null ) $model->id_feature = $feature->id_feature;
        else $this->redirect(array('feature/index'));
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['FeatureValue'])) {
            $model->attributes = $_POST['FeatureValue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_feature));
        }

        $this->render('cvalue', array(
            'model' => $model,
            'feature' => $feature,
        ));
    }
    public function actionUvalue() {        
        if($model = FeatureValue::model()->findByPk(Yii::app()->getRequest()->getParam('id_feature_value', 0)))                
            $feature = $this->loadModel($model->id_feature);
        else $this->redirect(array('feature/index'));
        
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['FeatureValue'])) {
            $model->attributes = $_POST['FeatureValue'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_feature));
        }

        $this->render('uvalue', array(
            'model' => $model,
            'feature' => $feature,
        ));
    }
    public function actionDvalue($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            if($model = FeatureValue::model()->findByPk(Yii::app()->getRequest()->getParam('id_feature_value', 0)))                
                $model->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Feature');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Feature('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Feature']))
            $model->attributes = $_GET['Feature'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Feature::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'feature-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
