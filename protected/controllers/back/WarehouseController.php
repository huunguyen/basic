<?php

class WarehouseController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'UpdateCities', 'UpdateZones'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    protected function resizePhoto($fileName, $width, $height, $inputPath = null, $outputPath = null) {
        $ext = ImageHelper::FilenameExtension($fileName);
        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpeg', 'jpg', 'gif', 'png');
        if (in_array($ext, $upload_permitted_image_types)) {
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                }
                else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
            }
            $filter = new Polycast_Filter_ImageSize();
            $config = $filter->getConfig();
            $config->setWidth($width)
                    ->setHeight($height)
                    ->setQuality(70)
                    ->setStrategy(new Polycast_Filter_ImageSize_Strategy_Fit())
                    ->setOverwriteMode(Polycast_Filter_ImageSize::OVERWRITE_ALL)
                    ->getOutputImageType('jpg');
            $filter->setOutputPathBuilder(new Polycast_Filter_ImageSize_PathBuilder_Standard($outputDirectory));
            $outputPath = $filter->filter($inputPath);
            chmod($outputPath, 0777);
        }
    }

    protected function savePhoto($uploadedFile, $fileName) {
        if (!empty($uploadedFile) & is_object($uploadedFile)) {
            if(!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE))
                    chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

            $this->resizePhoto($fileName, 640, 480);
            $this->resizePhoto($fileName, 240, 180);
            $this->resizePhoto($fileName, 50, 50);
            return true;
        } else
            return false;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Warehouse;
        $address = new Address;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $this->performAjaxValidation($address);

         if (isset($_POST['Warehouse']) && isset($_POST['Address'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'logo');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Warehouse']; 
            $address->attributes = $_POST['Address']; 
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->logo = $fileName;
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try 
                {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE)){
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE, 0777);  
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777); 
                            }  
                            $fileName = $model->getPrimaryKey().'.'.ImageHelper::FilenameExtension($fileName); 
                            $this->savePhoto($uploadedFile, $fileName);
                        }                        
                        $address->id_warehouse = $model->getPrimaryKey();
                        $address->save();
                       
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');                        
                        $this->redirect(array('warehouse/index', 'id' => $model->id_warehouse));
                    } 
                    else 
                        {
                        Yii::app()->user->setFlash('error', 'đã được tạo <strong>Thất bại! </strong><br/>');
                        throw new CException('Transaction failed: ');                         
                    }
                } 
                catch (Exception $e) 
                {
                    $transaction->rollback();   
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }        
        
        $this->render('create', array(
            'model' => $model,
            'address' => $address,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if(!empty($model->address_active)){
            $addresses=$model->addresses(array('condition'=>'active>=1'));
            $address = $model->address_active;
        }
        else $address = new Address;

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        $this->performAjaxValidation($address);

         if (isset($_POST['Warehouse']) && isset($_POST['Address'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'logo');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Warehouse']; 
            $address->attributes = $_POST['Address']; 
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->logo = $fileName;
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try 
                {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE)){
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE, 0777);  
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777); 
                            }  
                            $fileName = $model->getPrimaryKey().'.'.ImageHelper::FilenameExtension($fileName); 
                            $this->savePhoto($uploadedFile, $fileName);
                        }                        
                        $address->id_warehouse = $model->getPrimaryKey();
                        $address->save();
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Warehouse::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');                        
                        $this->redirect(array('warehouse/index', 'id' => $model->id_warehouse));
                    } 
                    else 
                        {
                        Yii::app()->user->setFlash('error', 'đã được tạo <strong>Thất bại! </strong><br/>');
                        throw new CException('Transaction failed: ');                         
                    }
                } 
                catch (Exception $e) 
                {
                    $transaction->rollback();   
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }        
        
        $this->render('create', array(
            'model' => $model,
            'address' => $address,
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
        $dataProvider = new CActiveDataProvider('Warehouse');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Warehouse('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Warehouse']))
            $model->attributes = $_GET['Warehouse'];

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
        $model = Warehouse::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'warehouse-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateCities() {
        $style = Yii::app()->getRequest()->getParam('style', "");
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
}
