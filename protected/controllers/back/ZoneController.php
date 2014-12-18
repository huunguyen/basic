<?php

class ZoneController extends Controller {

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
                'actions' => array('updateWards', 'updateCities', 'updateZones'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('indexCity', 'viewCity', 'createCity', 'updateCity'),
                'users' => array('@'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('indexDist', 'viewDist', 'createDist', 'updateDist'),
                'users' => array('@'),
            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('indexWard', 'viewWard', 'createWard', 'updateWard'),
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
public function actionUpdateWards() {
        $id_city = Yii::app()->getRequest()->getParam('id_city', "0");
        if ($id_city == "0") {
            $data = CHtml::listData(District::model()->findAll(), 'id_district', 'pre_name');
        } else
            $data = CHtml::listData(District::model()->findAll('id_city=:id_city', array(':id_city' => $id_city)), 'id_district', 'pre_name');
        $dropDown = "<option value=''>Chọn Quận | Huyện</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }
    public function actionUpdateCities() {
        $style = Yii::app()->getRequest()->getParam('style', "0");
        if ($style == "0") {
            $data = CHtml::listData(City::model()->findAll(), 'id_city', 'name');
        } else
            $data = CHtml::listData(City::model()->findAll('style=:style', array(':style' => $style)), 'id_city', 'name');
        $dropDown = "<option value=''>Chọn thành phố | tỉnh thành</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    public function actionUpdateZones() {
        if ($id_city = Yii::app()->getRequest()->getParam('city', null)) {
            $data = CHtml::listData(Zone::model()->findAll('id_city=:id_city AND active>=:active', array(':id_city' => $id_city, ':active' => 1)), 'id_zone', 'name');
        } else {
            $data = CHtml::listData(Zone::model()->findAll(array('order' => 'id_city ASC')), 'id_zone', 'name');
        }
        $dropDown = "<option value=''>Chọn Vùng</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Zone;
        $cmodel = new City;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Zone'])) {
            $model->attributes = $_POST['Zone'];
            if ($model->save())
                $this->redirect(array('index', 'id' => $model->id_zone));
        }

        $this->render('create', array(
            'model' => $model,
            'cmodel' => $cmodel
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if (empty($model->idCity))
            $cmodel = new City;
        else
            $cmodel = $model->idCity;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Zone'])) {
            $model->attributes = $_POST['Zone'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_zone));
        }

        $this->render('update', array(
            'model' => $model,
            'cmodel' => $cmodel
        ));
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateCity() {
        $model = new City;
        $model->id_country = Country::CODE_VIETNAM;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['City'])) {
            $model->attributes = $_POST['City'];
            if ($model->save())
                $this->redirect(array('zone/indexCity'));
        }

        $this->render('citycreate', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateCity($id) {
        $model = $this->loadCityModel($id);
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['City'])) {
            $model->attributes = $_POST['City'];
            if ($model->save())
                $this->redirect(array('zone/indexCity'));
        }

        $this->render('cityupdate', array(
            'model' => $model
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteCity($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadCityModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('indexCity'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDist() {
        $id = Yii::app()->getRequest()->getParam('id', null);
        if(($id!=null) && ($city = $this->loadCityModel($id))){
            $model = new District;
            $model->id_city = $city->id_city; 
        }
        else {
                   $model = new District;
        }

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['District'])) {
            $model->attributes = $_POST['District'];
            if ($model->save())
                $this->redirect(array('zone/indexDist'));
        }

        $this->render('distcreate', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateDist($id) {
        $model = $this->loadDistModel($id);

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['District'])) {
            $model->attributes = $_POST['District'];
            if ($model->save())
                $this->redirect(array('zone/indexDist'));
        }

        $this->render('distupdate', array(
            'model' => $model
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteDist($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadDistModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('indexDist'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateWard() {
        $id = Yii::app()->getRequest()->getParam('id', null);
        if(($id!=null) && ($district = $this->loadDistModel($id))){
            $model = new Ward;
            $model->id_district = $district->id_district; 
        }
        else {
                  $model = new Ward;
        }

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Ward'])) {
            $model->attributes = $_POST['Ward'];
            
            if ($model->save())
                $this->redirect(array('zone/indexWard'));
        }

        $this->render('wardcreate', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateWard($id) {
        $model = $this->loadWardModel($id);

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Ward'])) {
            $model->attributes = $_POST['Ward'];
            if ($model->save())
                $this->redirect(array('zone/indexWard'));
        }

        $this->render('wardupdate', array(
            'model' => $model
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteWard($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('indexWard'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Zone('search');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($model)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($model)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($model) . '_page'])) {
            $newsPage = (int) $_GET[get_class($model) . '_page'] - 1;
            Yii::app()->user->setState(get_class($model) . '_page', $newsPage);
            unset($_GET[get_class($model) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($model) . '_page', 0);
        }

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndexCity() {
        $model = new City('search');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($model)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($model)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($model) . '_page'])) {
            $newsPage = (int) $_GET[get_class($model) . '_page'] - 1;
            Yii::app()->user->setState(get_class($model) . '_page', $newsPage);
            unset($_GET[get_class($model) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($model) . '_page', 0);
        }

        $this->render('cityindex', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndexDist() {
        $model = new District('search');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($model)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($model)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($model) . '_page'])) {
            $newsPage = (int) $_GET[get_class($model) . '_page'] - 1;
            Yii::app()->user->setState(get_class($model) . '_page', $newsPage);
            unset($_GET[get_class($model) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($model) . '_page', 0);
        }

        $this->render('distindex', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndexWard() {
        $model = new Ward('search');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($model)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($model)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($model) . '_page'])) {
            $newsPage = (int) $_GET[get_class($model) . '_page'] - 1;
            Yii::app()->user->setState(get_class($model) . '_page', $newsPage);
            unset($_GET[get_class($model) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($model) . '_page', 0);
        }

        $this->render('wardindex', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Zone('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Zone']))
            $model->attributes = $_GET['Zone'];

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
        $model = Zone::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Yêu cầu trang này không tồn tại. Có thể đã bị xóa trên hệ thống. Đừng lặp lại nó một lần nữa!');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadCityModel($id) {
        $model = City::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Yêu cầu trang này không tồn tại. Có thể đã bị xóa trên hệ thống. Đừng lặp lại nó một lần nữa!');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadDistModel($id) {
        $model = District::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Yêu cầu trang này không tồn tại. Có thể đã bị xóa trên hệ thống. Đừng lặp lại nó một lần nữa!');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadWardModel($id) {
        $model = Ward::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Yêu cầu trang này không tồn tại. Có thể đã bị xóa trên hệ thống. Đừng lặp lại nó một lần nữa!');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'zone-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'city-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'dist-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ward-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
