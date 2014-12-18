<?php

class PackGroupController extends Controller {

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
                'actions' => array('index', 'view', 'ajaxView', 'create', 'update', 'addItem', 'updateItem', 'updatePAttributes', 'deleteItem'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
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
    public function actionView($id) {
        $pack = new Pack;
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'pack' => $pack
        ));
    }
    public function actionAjaxView($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->renderPartial('_view', array(
            'model' => $this->loadModel($id)
            ), false, false);
            Yii::app()->end();
        }
        if($id = Yii::app()->getRequest()->getParam('id', null)){
            $this->renderPartial('_view', array(
            'model' => $this->loadModel($id)
            ), false, true);
            Yii::app()->end();
        }
        else {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }
public function actionUpdatePAttributes($id_product=null) {
        $id_product = Yii::app()->getRequest()->getParam('id_product', $id_product);
        if($id_product==null){
            $data = CHtml::listData(ProductAttribute::model()->findAll(), 'id_product_attribute', 'fullname');
        }
        else
            {
            $data = CHtml::listData(ProductAttribute::model()->findAll('id_product=:id_product', array(':id_product' => $id_product)), 'id_product_attribute', 'fullname');
        }
        
        
        $dropDown = "<option value=''>Chọn Sản phẩm Chi Tiết</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }
    
    public function actionAddItem($id) {
        $model = $this->loadModel($id);
        $pack = new Pack;
        $pack->id_pack_group = $model->id_pack_group;
        if (isset($_POST['Pack'])) {
            $pack->attributes = $_POST['Pack'];
            $exist = Pack::model()->findByAttributes(array('id_product' => $pack->id_product, 'id_product_attribute' => $pack->id_product_attribute, 'id_pack_group' => $pack->id_pack_group));
            if($exist != null){
                $exist->quantity += $pack->quantity;
                if ($exist->save()) {
                    $model->modifyTotalPaid();
                    $model->modifyTotalRealPaid();
                    $model->save(false);
                    $this->redirect(array('view', 'id' => $model->id_pack_group));
                }
            }
            elseif ($pack->save()) {
                $model->modifyTotalPaid();
                $model->modifyTotalRealPaid();
                $model->save(false);
                $this->redirect(array('view', 'id' => $model->id_pack_group));
            } else {
                dump($pack);
                exit();
            }
        }
        $this->render('item', array(
            'model' => $model,
            'pack' => $pack
        ));
    }
    
    public function actionUpdateItem($id) {
        $model = $this->loadModel($id);
        $pack = Pack::model()->findByPk($id);
        if ($pack == null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        } else {
            $model = PackGroup::model()->findByPk($pack->id_pack_group);
        }
        if (isset($_POST['Pack'])) {
            $pack->attributes = $_POST['Pack'];
            if ($model->save()) {
                $model->modifyTotalPaid();
                $model->modifyTotalRealPaid();
                $model->save(false);
                $this->redirect(array('addItem', 'id' => $model->id_pack_group));
            } else {
                dump($model);
                exit();
            }
        }
        $this->render('item', array(
            'model' => $model,
            'pack' => $pack
        ));
    }
 public function actionDeleteItem($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            if($model = Pack::model()->findByPk($id)){
                $model->delete();
                $pack_group = $this->loadModel($model->id_pack_group);   
                $pack_group->modifyTotalPaid();
                $pack_group->modifyTotalRealPaid();
                $pack_group->save(false);
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } 
        else
            {
            $id_pack = Yii::app()->getRequest()->getParam('id', null);
            if(isset($id_pack) && $model = Pack::model()->findByPk($id_pack) ){
                $model->delete();
                $pack_group = $this->loadModel($model->id_pack_group);   
                $pack_group->modifyTotalPaid();
                $pack_group->modifyTotalRealPaid();
                $pack_group->save(false);
            }
                
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PackGroup;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['PackGroup'])) {
            $model->attributes = $_POST['PackGroup'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_pack_group));
            else {
                dump($model);
                exit();
            }
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

        if (isset($_POST['PackGroup'])) {
            $model->attributes = $_POST['PackGroup'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_pack_group));
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
        $model = new PackGroup('search');
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
        $model = new PackGroup('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PackGroup']))
            $model->attributes = $_GET['PackGroup'];

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
        $model = PackGroup::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pack-group-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
