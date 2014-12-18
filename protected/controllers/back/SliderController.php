<?php

class SliderController extends Controller {

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
                'actions' => array('index', 'view', 'indexDetail', 'viewDetail'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'createDetail', 'updateDetail'),
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

    protected function resizePhoto($fileName, $width, $height, $inputPath = null, $outputPath = null) {
        $ext = ImageHelper::FilenameExtension($fileName);
        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpeg', 'jpg', 'gif', 'png');
        if (in_array($ext, $upload_permitted_image_types)) {
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                } else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
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
            if (!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE))
                chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

            $this->resizePhoto($fileName, 850, 275);
            $this->resizePhoto($fileName, 180, 60);
            $this->resizePhoto($fileName, 50, 50);
            return true;
        } else
            return false;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewDetail($id) {
        $this->render('application.views.sliderDetail.view', array(
            'model' => $this->loadDetailModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDetail($id) {
        $slider = $this->loadModel($id);
        $model = new SliderDetail;
        $model->id_slider = $slider->id_slider;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SliderDetail'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'image');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['SliderDetail'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->image = $fileName;
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        SliderDetail::model()->updateByPk($model->getPrimaryKey(), array('image' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('slider/indexDetail', 'id' => $slider->id_slider));
                    } else {
                        throw new CException('Transaction failed: ');
                        Yii::app()->user->setFlash('error', 'đã được tạo <strong>Thất bại! </strong><br/>');
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }

        $this->render('application.views.sliderDetail.create', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateDetail($id) {
        $model = $this->loadDetailModel($id);

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['SliderDetail'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'image');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['SliderDetail'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->image = $fileName = $model->id_slider_detail . '.' . ImageHelper::FilenameExtension($fileName);
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . SliderDetail::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('slider/indexDetail', 'id' => $model->id_slider));
                    } else {
                        throw new CException('Transaction failed: ');
                        Yii::app()->user->setFlash('error', 'đã được tạo <strong>Thất bại! </strong><br/>');
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            }
        }

        $this->render('application.views.sliderDetail.update', array(
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
    public function actionIndexDetail($id) {
        $slider = $this->loadModel($id);
        $model = new SliderDetail('searchBySlider');
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

        $this->render('application.views.sliderDetail.index', array(
            'slider' => $slider,
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminDetail() {
        $model = new Slider('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Slider']))
            $model->attributes = $_GET['Slider'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $detail = new SliderDetail('search');
        $detail->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($detail));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($detail)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($detail)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($detail) . '_page'])) {
            $newsPage = (int) $_GET[get_class($detail) . '_page'] - 1;
            Yii::app()->user->setState(get_class($detail) . '_page', $newsPage);
            unset($_GET[get_class($detail) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($detail) . '_page', 0);
        }

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'detail' => $detail,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Slider;

// Uncomment the following line if AJAX validation is needed
 $this->performAjaxValidation($model);

        if (isset($_POST['Slider'])) {
            $model->attributes = $_POST['Slider'];
            if(isset($model->zoneadv) && ($model->zoneadv!="")){
                $model->id_category = $model->id_manufacturer = $model->id_supplier = null;
                $model->force = true;
            }
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_slider));
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

        if (isset($_POST['Slider'])) {
            $model->attributes = $_POST['Slider'];
            if(isset($model->zoneadv) && ($model->zoneadv!="")){
                $model->id_category = $model->id_manufacturer = $model->id_supplier = null;
                $model->force = true;
            }
            //dump($model);exit();
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_slider));
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
        $model = new Slider('search');
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
        $model = new Slider('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Slider']))
            $model->attributes = $_GET['Slider'];

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
        $model = Slider::model()->findByPk($id);
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
        $model = SliderDetail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'slider-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
