<?php

class AddressController extends Controller {

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
                'actions' => array('index', 'view', 'updateCities', 'getCities', 'getDistricts', 'getWards'),
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
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id=null, $type=null) {
        $model = new Address;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Address'])) {
            $model->attributes = $_POST['Address'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_address));
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

        if (isset($_POST['Address'])) {
            $model->attributes = $_POST['Address'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_address));
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
        $dataProvider = new CActiveDataProvider('Address');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Address('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Address']))
            $model->attributes = $_GET['Address'];

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
        $model = Address::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'address-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function actionUpdateCities() {
        $style = Yii::app()->getRequest()->getParam('style', "0");
        if($style=="0"){
            $data = CHtml::listData(City::model()->findAll(), 'id_city', 'name');
        }
        else
        $data = CHtml::listData(City::model()->findAll('style=:style', array(':style' => $style)), 'id_city', 'name');
        $dropDown = "<option value=''>Chọn thành phố | tỉnh thành</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }
    
public function actionGetCities() {
        $id_country = Yii::app()->getRequest()->getParam('id_country', null);
        $dropDownCity = "<option value=''>Chọn Tỉnh | Thành phố [{$id_country}]</option>";
        if (empty($id_country) || !isset($id_country)) {
            echo CJSON::encode(array(
                'dropDownCity' => $dropDownCity,
            ));
            Yii::app()->end();
        } else {
            $cities = CHtml::listData(City::model()->findAll('id_country=:id_country', array(':id_country' => $id_country)), 'id_city', 'name');
            foreach ($cities as $value => $name) {
                $dropDownCity .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            echo CJSON::encode(array(
                'dropDownCity' => $dropDownCity
            ));
            Yii::app()->end();
        }
    }
    
    public function actionGetDistricts() {
        $id_city = Yii::app()->getRequest()->getParam('id_city', null);
        $dropDownDistrict = "<option value=''>Chọn Quận | Huyện [{$id_city}]</option>";
        if (empty($id_city) || !isset($id_city)) {
            echo CJSON::encode(array(
                'dropDownDistrict' => $dropDownDistrict,
            ));
            Yii::app()->end();
        } else {
            $districts = CHtml::listData(District::model()->findAll('id_city=:id_city', array(':id_city' => $id_city)), 'id_district', 'name');
            foreach ($districts as $value => $name) {
                $dropDownDistrict .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            echo CJSON::encode(array(
                'dropDownDistrict' => $dropDownDistrict,
            ));
            Yii::app()->end();
        }
    }
    
    public function actionGetWards() {
        $id_district = Yii::app()->getRequest()->getParam('id_district', null);
        $dropDownWard = "<option value=''>Chọn Phường | Xã [{$id_district}]</option>";
        if (empty($id_district) || !isset($id_district)) {
            echo CJSON::encode(array(
                'dropDownWard' => $dropDownWard,
            ));
            Yii::app()->end();
        } else {
            $wards = CHtml::listData(Ward::model()->findAll('id_district=:id_district', array(':id_district' => $id_district)), 'id_ward', 'name');
            foreach ($wards as $value => $name) {
                $dropDownWard .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            echo CJSON::encode(array(
                'dropDownWard' => $dropDownWard
            ));
            Yii::app()->end();
        }
    }
}
