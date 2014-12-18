<?php

class MenuController extends Controller {

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
                'actions' => array('index', 'view', 'indexDetail', 'viewDetail','indexSubDetail'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'createDetail', 'createSubDetail', 'updateDetail'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'adminDetail', 'deleteDetail'),
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
    public function actionViewDetail($id) {
        $model = MenuDetail::model()->findByPk($id);
        $menu = Menu::model()->findByPk($model->id_menu);
        $this->render('application.views.menuDetail.view', array(
            'menu' => $menu,
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDetail($id) {
        $menu = $this->loadModel($id);
        $model = new MenuDetail;
        $model->id_menu = $menu->id_menu;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['MenuDetail'])) {
            $model->attributes = $_POST['MenuDetail'];
            if ($model->save())
                $this->redirect(array('viewDetail', 'id' => $model->id_menu_detail));
        }

        $this->render('application.views.menuDetail.create', array(
            'menu' => $menu,
            'model' => $model,
        ));
    }
 /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateSubDetail($id) {
        if($parent = $this->loadDetailModel($id)){
            $menu = $this->loadModel($parent->id_menu);
        }
        
        $model = new MenuDetail;
        $model->id_menu = $menu->id_menu;
        $model->id_parent = $parent->id_menu_detail;
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['MenuDetail'])) {
            $model->attributes = $_POST['MenuDetail'];
            if ($model->save())
                $this->redirect(array('viewDetail', 'id' => $model->id_menu_detail));
        }

        $this->render('application.views.menuDetail.create', array(
            'parent'=>$parent,
            'menu'  => $menu,
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateDetail($id) {
        $model = MenuDetail::model()->findByPk($id);
        $menu = Menu::model()->findByPk($model->id_menu);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['MenuDetail'])) {
            $model->attributes = $_POST['MenuDetail'];
            if ($model->save())
                $this->redirect(array('viewDetail', 'id' => $model->id_menu_detail));
        }

        $this->render('application.views.menuDetail.update', array(
            'menu' => $menu,
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteDetail($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $model = $this->loadDetailModel($id);
            $model->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('indexDetail','id'=>$model->id_menu));
        } else{
            // we only allow deletion via POST request
            $model = $this->loadDetailModel($id);
            $model->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('indexDetail','id'=>$model->id_menu));
        }
           
    }

    /**
     * Lists all models.
     */
    public function actionIndexDetail($id) {
        $menu = $this->loadModel($id);
        $model = new MenuDetail('searchByMenu');
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

        $this->render('application.views.menuDetail.index', array(
            'menu' => $menu,
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }
    
/**
     * Lists all models.
     */
    public function actionIndexSubDetail($id) {
        if($parent = MenuDetail::model()->findByPk($id)){
            $child = MenuDetail::model()->findByAttributes(array('id_parent'=>$parent->id_menu_detail));
            if($child == null){
                Yii::app()->user->setFlash('info', 'Liên kết này không có mục con <strong>Xem chi tiết thông tin bên dưới! </strong>');
                $this->redirect(array('viewDetail', 'id' => $parent->id_menu_detail));
            } 
        }
        
        $model = new MenuDetail('searchByMenu');
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

        $this->render('application.views.menuDetail.subindex', array(
            'parent' => $parent,
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }
    
    /**
     * Manages all models.
     */
    public function actionAdminDetail() {
        $model = new Menu('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Menu']))
            $model->attributes = $_GET['Menu'];

        $this->render('application.views.menuDetail.admin', array(
            'model' => $model,
        ));
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
        $model = new Menu;

// Uncomment the following line if AJAX validation is needed
 $this->performAjaxValidation($model);

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_menu));
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
 $this->performAjaxValidation($model);

        if (isset($_POST['Menu'])) {
            $model->attributes = $_POST['Menu'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_menu));
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
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
$model = $this->loadModel($id);
            $model->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
        {
            $model = $this->loadModel($id);
            $model->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Menu('search');
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Menu('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Menu']))
            $model->attributes = $_GET['Menu'];

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
        $model = Menu::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
/**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadDetailModel($id) {
        $model = MenuDetail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-detail-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
