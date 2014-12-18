<?php

class AttributeController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'indexGroup', 'viewGroup', 'createGroup', 'updateGroup', 'isColorGroup'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'deleteGroup'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionIsColorGroup() {
                //This is for IE which doens't handle 'Content-type: application/json' correctly
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        $id = Yii::app()->getRequest()->getParam('id_attribute_group', null);
        $rs = false;
        
        if (($id!=null) && ($id!="") && Yii::app()->request->isAjaxRequest) {
            $criteria=new CDbCriteria;
            $criteria->condition='id_attribute_group=:id AND group_type=:group_type';
            $criteria->params=array(':id'=>$id,':group_type'=> "color");
            if( ($model = AttributeGroup::model()->find($criteria)) ){
                $rs = true;
            }
            echo CJSON::encode(array('rs' => $rs));
            Yii::app()->end();
        }
        else {
            header('Content-type: text/plain');
            //redirect to home page
            Yii::app()->user->setFlash('error', '<strong>Fail!</strong> Error access.');
            throw new Exception('Error access');
            $this->redirect('site/index');
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Attribute;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            //var_dump($model);exit();
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_attribute));
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

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_attribute));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
        /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewGroup($id) {
        $this->render('application.views.attributeGroup.view', array(
            'model' => $this->loadGroupModel($id),
        ));
    }
/**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateGroup() {
        $model = new AttributeGroup;

// Uncomment the following line if AJAX validation is needed
 $this->performAjaxValidation($model);

        if (isset($_POST['AttributeGroup'])) {            
            $model->attributes = $_POST['AttributeGroup'];   
            
            $model->name = $_POST['AttributeGroup']['name'];     
            $model->public_name = $_POST['AttributeGroup']['public_name']; 
            $model->group_type = $_POST['AttributeGroup']['group_type']; 
            $model->position = $_POST['AttributeGroup']['position']; 
            
            if($model->validate()){
                if ($model->save(false))
                $this->redirect(array('indexGroup', 'id' => $model->id_attribute_group));
            }
            else {
                 var_dump($model);exit();
            }
            
        }

        $this->render('cgroup', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateGroup($id) {
        $model = AttributeGroup::model()->findByPk($id);

// Uncomment the following line if AJAX validation is needed
$this->performAjaxValidation($model);

        if (isset($_POST['AttributeGroup'])) {            
            $model->attributes = $_POST['AttributeGroup'];    
            
            $model->name = $_POST['AttributeGroup']['name'];     
            $model->public_name = $_POST['AttributeGroup']['public_name']; 
            $model->group_type = $_POST['AttributeGroup']['group_type']; 
            $model->position = $_POST['AttributeGroup']['position']; 
            
            if($model->validate()){
                if ($model->save(false))
                $this->redirect(array('indexGroup', 'id' => $model->id_attribute_group));
            }
            else {
                 var_dump($model);exit();
            }
            
        }
        $this->render('ugroup', array(
            'model' => $model,
        ));
    }
/**
     * Lists all models.
     */
    public function actionIndexGroup() {
        $model = new AttributeGroup('search');  
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . 'attributeGroupPageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'attributeGroupPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['AttributeGroup_page'])) {
            $newsPage = (int) $_GET['AttributeGroup_page'] - 1;
            Yii::app()->user->setState('AttributeGroup_page', $newsPage);
            unset($_GET['AttributeGroup_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('AttributeGroup_page', 0);
        }

        $this->render('igroup', array(
            'model' => $model,
            'pageSize' => $pageSize,
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
    public function actionIndex($id) {
        try {
            $group = $this->loadGroupModel($id);
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $this->redirect(array('indexGroup'));
        }

        
        $model = new Attribute('search');  
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . 'attributePageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'attributePageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['Attribute_page'])) {
            $newsPage = (int) $_GET['Attribute_page'] - 1;
            Yii::app()->user->setState('Attribute_page', $newsPage);
            unset($_GET['Attribute_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('Attribute_page', 0);
        }

        $this->render('index', array(
            'group' => $group,
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }
    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Attribute('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Attribute']))
            $model->attributes = $_GET['Attribute'];

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
        $model = Attribute::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadGroupModel($id) {
        $model = AttributeGroup::model()->findByPk($id);
        if ($model === null)
             throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'attribute-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
