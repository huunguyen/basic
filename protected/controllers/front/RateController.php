<?php

class RateController extends Controller {

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
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view', 'AddRate'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
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
    public function actionAddRate() {
        if (Yii::app()->request->isAjaxRequest) {
            $total_percent = 0;
            $total_rate = 0;
            $id_product = Yii::app()->getRequest()->getParam('id_pro', NULL);
            $level_id = Yii::app()->getRequest()->getParam('level', NULL);
            $rate = $this->loadModel($id_product);
            
                if (empty($rate)) {
                    $model = new Rate();
                    $model->id_product = $id_product;
                    $model->level_name = '';
                    $model->level = $level_id;
                    $model->level_max = 5;
                    $model->total_rate = 1;
                    $model->final_rate_date = '';
                    $model->active = 1;
                    $model->save();
                    $total_rate = 1;
                } else {
                    $total_rate = $rate->total_rate + 1;
                    $avg = $rate->level + $level_id;
                    $level = ($avg / $total_rate);
                    $rate->level = $avg;
                    $rate->total_rate = $total_rate;
                    $rate->save();
                }
                echo $total_rate . "lượt đánh giá";
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Rate;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rate'])) {
            $model->attributes = $_POST['Rate'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_product));
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

        if (isset($_POST['Rate'])) {
            $model->attributes = $_POST['Rate'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_product));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Rate');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Rate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rate']))
            $model->attributes = $_GET['Rate'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rate the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Rate::model()->findByPk($id);
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rate $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
