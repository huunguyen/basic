<?php

class ContactController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update'),
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
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                } else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
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
            if (!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE))
                chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

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
        $model = new Contact;

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Contact'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Contact'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->img = $fileName;
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = Contact::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_contact, array('img' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('contact/index', 'id' => $model->id_contact));
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

        if (isset($_POST['Contact'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Contact'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->img = $fileName = $model->id_contact . '.' . ImageHelper::FilenameExtension($fileName);
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Contact::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('contact/index', 'id' => $model->id_contact));
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
         $model = new Contact('search');
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
        } elseif (isset($_GET['ajax'])) {
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
        $model = new Contact('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contact']))
            $model->attributes = $_GET['Contact'];

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
        $model = Contact::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contact-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
