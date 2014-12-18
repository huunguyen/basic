<?php

class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     * 
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

    public function accessRules() {
//        $params = array();
//        $id = Yii::app()->request->getParam('id'); //Choose the GET/POST parameters appropriately and populate $params.
//        if (isset($id))
//            $params['user'] = $this->loadModel($id);
//        else {
//            $params['user'] = $this->loadModel(Yii::app()->user->id);
//            Yii::app()->request->getPut('id', Yii::app()->user->id);
//        }
        /*
         * The parent task  'userAccount'  has bizRule with it.    
         * So we have to pass params with updateAccount and ViewAccount.
         */
        return array(
            array('allow',
                'actions' => array('find'),
                'roles' => array('*'),
            ),
            array('allow',
                'actions' => array('roView', 'roUpdate', 'roDelete', 'roAddSubRoles', 'roAddUsersRole', 'addSubRole', 'addUserRole', 'removeSubRole', 'assDelete', 'addressUser'),
                'roles' => array('supper, admin, manager, staff'),
            ),
            array('allow',
                'actions' => array('member', 'updateRoles', 'checkRolesUsers', 'dynamiccities', 'index', 'active', 'verified', 'expiry', 'rqPasswd', 'assignments', 'roles', 'tasks', 'operations', 'view', 'upload', 'address'),
                'users' => array('supper4saocom'),
            ),
            array('allow',
                'actions' => array('grid', 'memberGrid', 'adminGrid'),
                'roles' => array('supper, admin, manager, staff'),
            ),
            array('allow',
                'actions' => array('password', 'admin', 'delete', 'create', 'update', 'ajaxUpdate', 'ajaxSentEmail', 'trade', 'job'),
                'roles' => array('supper, admin, manager, staff'),
            ),
            array('allow',
                'actions' => array('deleteRTO', 'viewRTO', 'updateRTO', 'createRTO', 'createRPC', 'manageRPC', 'updateAuthItems', 'deleteRTO', 'deleteRPC', 'updateRTO4U', 'modifyRTO4U', 'reloadRTO4U'),
                'roles' => array('supper, admin, manager, staff'),
            ),
            array('allow',
                'actions' => array('password'),
                'expression' => "Yii::app()->controller->isOwner()",
            ),
            array('allow',
                'actions' => array('admin', 'chooseUserandRTO', 'delAllRoleUser', 'sentEmail'),
                'expression' => "( Yii::app()->user->getState('isAdmin') || (Yii::app()->user->getState('role')=='admin') )",
            ),
            array('deny', // deny anything else
                'users' => array('*'),
            ),
        );
    }

    /**
     *
     * @return array actions
     */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xEEEEEE,
                'foreColor' => 0xB3493F,
            ),
        );
    }

    public function actionAddressUser($id) {
        $user = $this->loadModel($id);
        $detail = Detail::model()->findByAttributes(array('id_user' => $user->id_user));
        if (!isset($user->details) || empty($user->details) || ($detail === null)) {
            Yii::app()->user->setFlash('error', 'Thông tin người dùng sai <strong>Vui lòng cập nhật lại! </strong>');
            $this->redirect(array('user/update', 'id' => $user->id_user));
        } else {
            $address = Address::model()->findByPk($detail->id_address_default);
            if ($address == null) {
                $address = new Address;
                $address->id_detail = $detail->id_detail;
            }
            $address->id_store = $address->id_supplier = $address->id_manufacturer = $address->id_warehouse = null;
            if (isset($_POST['Address'])) {
                $address->attributes = $_POST['Address'];
                //dump($address);exit();
                if ($address->save()) {
                    Yii::app()->user->setFlash('success', 'Thông tin đã lưu <strong>Thành công! </strong>');
                    Detail::model()->updateByPk($detail->id_detail, array('id_address_default' => $address->id_address));
                    $this->redirect(array('index', 'id' => $address->id_address));
                }
            }
            $this->render('address', array(
                'model' => $address
            ));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new User('search');
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
    public function actionActive() {
        $model = new User('active');
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

        $this->render('active', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionVerified() {
        $model = new User('verified');
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

        $this->render('verified', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionExpiry() {
        $model = new User('expiry');
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

        $this->render('expiry', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionRqPasswd() {
        $model = new User('expiry');
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

        $this->render('rqpasswd', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionAssignments() {
        $model = new AuthAssignment('search');
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

        $this->render('assignments', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionRoles() {
        $model = new AuthItem('roles');
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

        $this->render('roles', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionTasks() {
        $model = new AuthItem('tasks');
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

        $this->render('tasks', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionOperations() {
        $model = new AuthItem('operators');
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

        $this->render('operators', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        if (!isset($id)) {
            $model = $this->loadModel(Yii::app()->user->id);
        } else
            $model = $this->loadModel($id);

        $mmodel = Detail::model()->findByAttributes(array('id_user' => $model->id_user));
        if ($mmodel === null)
            $mmodel = new Detail();
        // set the parameters for the bizRule
//        $params = array('User' => $model);
        // now check the bizrule for this user
//        if (!Yii::app()->user->checkAccess('updateSelf', $params) && !Yii::app()->user->checkAccess('admin')) {
//            throw new CHttpException(403, 'You are not authorized to perform this action');
//        }     

        $this->render('view', array(
            'model' => $model,
            'mmodel' => $mmodel
        ));
    }

    protected function resizePhoto($fileName, $width, $height, $inputPath = null, $outputPath = null) {
        $ext = ImageHelper::FilenameExtension($fileName);
        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpeg', 'jpg', 'gif', 'png');
        if (in_array($ext, $upload_permitted_image_types)) {
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                } else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
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
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE)) {
                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, 0777);
                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
            }
            if (!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE))
                chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

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
        $model = new User('insert');
        $mmodel = new Detail('insert');

        //$model->userdetail = $mmodel;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User']) && isset($_POST['Detail'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'avatar');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['User'];
            $mmodel->attributes = $_POST['Detail'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->avatar = $fileName;
            if ($model->validate() && $mmodel->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $mmodel->id_user = $model->getPrimaryKey();
                        $mmodel->save(false);
                        $transaction->commit();
                         ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = User::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_user, array('avatar' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('user/index', 'id' => $model->id_user));
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
        //print_r($model->getErrors()); exit;
        $this->render('create', array(
            'model' => $model,
            'mmodel' => $mmodel,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $mmodel = Detail::model()->findByAttributes(array('id_user' => $model->id_user));
        if ($mmodel === null)
            $mmodel = new Detail('create');

        //$model->userdetail = $mmodel;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['User']) && isset($_POST['Detail'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'avatar');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['User'];
            $mmodel->attributes = $_POST['Detail'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->avatar = $fileName;
            if ($model->validate() && $mmodel->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $mmodel->id_user = $model->getPrimaryKey();
                        $mmodel->save(false);
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . User::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = User::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_user, array('avatar' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('user/index', 'id' => $model->id_user));
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
        //print_r($model->getErrors()); exit;
        $this->render('update', array(
            'model' => $model,
            'mmodel' => $mmodel,
        ));
    }

    public function actionTrade() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . '@' . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_id . 'userPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'userPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['User_page'])) {
            $userPage = (int) $_GET['User_page'] - 1;
            Yii::app()->user->setState('User_page', $userPage);
            unset($_GET['User_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('User_page', 0);
        }
        $this->render('grid', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionJob() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . '@' . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_id . 'userPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'userPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['User_page'])) {
            $userPage = (int) $_GET['User_page'] - 1;
            Yii::app()->user->setState('User_page', $userPage);
            unset($_GET['User_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('User_page', 0);
        }
        $this->render('grid', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionPassword($isOwner = true) {
        $owner = User::model()->findByPk(Yii::app()->user->id);
        if (!Yii::app()->user->checkAccess('admin')) {
            Yii::app()->user->setFlash('error', '<strong>Lỗi xảy ra!</strong> đổi mật khẩu cho người dùng không được phép.');
            $this->redirect('process');
        } else {
            $model = new ChangePasswordForm;
            $model->username = $owner->username;
        }
        if (isset($_GET['id'])) {
            $user = User::model()->findByPk((int) $_GET['id']);
            if (!empty($user)) {
                $model->username = $user->username;
                $isOwner = false;
            } else
                $isOwner = true;
        }
        else {
            $isOwner = true;
            $user = $owner;
        }
        if (isset($_POST['ChangePasswordForm'])) {
            $model->attributes = $_POST['ChangePasswordForm'];
            try {
                $secret = $user->encrypt_text(strtolower($user->username), $user->salt);
                $new = $user->hashPassword($model->password, $secret);
                //$new = crypt($model->password, $isOwner ? $owner->salt : $user->salt);
                //if user login is a supper admin. don't check old password.
                if (Yii::app()->user->checkAccess('supper')) {
                    $user->updateByPk($isOwner ? $owner->id : $user->id, array('password' => $new));
                    Yii::app()->user->setFlash('success', '<strong>Thành công!</strong> đổi mật khẩu cho người dùng.');
                    $this->redirect(array('view', 'id' => $isOwner ? $owner->id : $user->id));
                } elseif ($model->validate() && ( $isOwner ? $owner->check($model->oldpassword) : $user->check($model->oldpassword) )) {
                    $user->updateByPk($isOwner ? $owner->id : $user->id, array('password' => $new));
                    Yii::app()->user->setFlash('success', '<strong>Thành công!</strong> đổi mật khẩu cho người dùng.');
                    $this->redirect(array('view', 'id' => $isOwner ? $owner->id : $user->id));
                }
            } catch (Exception $exc) {
                Yii::app()->user->setFlash('error', '<strong>Lỗi xảy ra!</strong> đổi mật khẩu cho người dùng. ' . $exc->getMessage());
            }
        }
        $this->render('password', array(
            'user' => $isOwner ? $owner : $user,
            'model' => $model
        ));
    }

    public function actionAjaxupdate() {
        $act = Yii::app()->getRequest()->getParam('act', null);
        if ($act == 'doSortOrder') {
            $sortOrderAll = $_POST['sortOrder'];
            if (count($sortOrderAll) > 0) {
                foreach ($sortOrderAll as $menuId => $sortOrder) {
                    $model = $this->loadModel($menuId);
                    $model->sortOrder = $sortOrder;
                    $model->save();
                }
            }
        } else {
            $autoIdAll = Yii::app()->getRequest()->getParam('autoId', null);
            if (count($autoIdAll) > 0) {
                foreach ($autoIdAll as $autoId) {
                    try {
                        $model = $this->loadModel($autoId);
                        if ($act == 'doINACTIVE')
                            $model->updateByPk($model->id, array('status' => Yii::t('status', 'INACTIVE')));
                        if ($act == 'doACTIVE')
                            $model->updateByPk($model->id, array('status' => Yii::t('status', 'ACTIVE')));
                        if ($act == 'doREMOVED')
                            $model->updateByPk($model->id, array('status' => Yii::t('status', 'REMOVED')));
                        if ($act == 'doBANNED')
                            $model->updateByPk($model->id, array('status' => Yii::t('status', 'BANNED')));
                        if ($act == 'doBYPASS')
                            $model->updateByPk($model->id, array('status' => Yii::t('status', 'BYPASS')));
                        echo $autoId . ' ok ';
                    } catch (Exception $exc) {
                        echo $autoId . ' fail ' . $exc->getTraceAsString();
                    }
                }
            }
        }
    }

    public function actionAjaxSentEmail() {
        
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if ($tmp = $this->loadModel($id)) {
            $permitted_linux_types = array('admin', 'manager', 'supper', 'staff', 'vip');
            if ($this->loadModel($id)->level >= 18) {
                Yii::app()->user->setFlash('error', 'Nguyên nhân gây lỗi: ', 'Không cho phép xóa thành viên loại này', "\n");
            } else
                $tmp->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    public function actionNewsOwner() {
        $model = new News('searchowner');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . $_GET['cat_id'] . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_id . 'newsPageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'newsPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['News_page'])) {
            $newsPage = (int) $_GET['News_page'] - 1;
            Yii::app()->user->setState('News_page', $newsPage);
            unset($_GET['News_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('News_page', 0);
        }

        $this->render('newsowner', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionPostOwner() {
        $model = new Post('searchowner');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . $_GET['cat_id'] . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_id . 'postPageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'postPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['Post_page'])) {
            $newsPage = (int) $_GET['Post_page'] - 1;
            Yii::app()->user->setState('Post_page', $newsPage);
            unset($_GET['Post_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('Post_page', 0);
        }

        $this->render('postowner', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionMessageOwner() {
        $model = new Message('searchowner');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.        
        if ((isset($_GET['zone'])) && ($_GET['zone'] == 3)) {
            $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . $_GET['zone'] . Yii::app()->user->id);
        } else {
            $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . '@' . Yii::app()->user->id);
        }
        $pageSize = Yii::app()->user->getState($uni_id . 'messagePageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'messagePageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['Message_page'])) {
            $newsPage = (int) $_GET['Message_page'] - 1;
            Yii::app()->user->setState('Message_page', $newsPage);
            unset($_GET['Message_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('Message_page', 0);
        }

        $this->render('messageowner', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function actionGrid() {
        $user = new User('search');
        $user->unsetAttributes();  // clear any default values
        $uni_user_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($user) . '@' . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_user_id . 'userPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_user_id . 'userPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['User_page'])) {
            $userPage = (int) $_GET['User_page'] - 1;
            Yii::app()->user->setState('User_page', $userPage);
            unset($_GET['User_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('User_page', 0);
        }
        $this->render('grid', array(
            'dataProvider' => $user,
            'pageSize' => $pageSize,
        ));
    }

    public function actionAdminGrid($catid = -1) {
        $model = new User('searchadmin');
        $model->unsetAttributes();  // clear any default values
        $catid = isset($_GET['catid']) ? $_GET['catid'] : $catid;
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model) . $catid . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_id . 'userPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'userPageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET['User_page'])) {
            $userPage = (int) $_GET['User_page'] - 1;
            Yii::app()->user->setState('User_page', $userPage);
            unset($_GET['User_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('User_page', 0);
        }

        if ((isset($_GET['catid'])) && ($_GET['catid'] != '')) {
            $catid = $_GET['catid'];
        }
        $this->render('admingrid', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
            'catid' => $catid
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAddress() {
        if (isset($_GET['address_id'])) {
            $address_id = $_GET['address_id'];
            $model = Address::model()->findByPk($address_id);
        }
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user)) {
            Yii::app()->user->setFlash('error', "<strong>Lỗi xảy ra!</strong> do hành động này không được phép.!");
            $this->redirect(array('process/login'));
        }
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            $contact = User::model()->findByPk($user_id);
            if (!isset($model)) {
                $model = Address::model()->findByAttributes(array('user_id' => isset($contact) ? $contact->id : $user->id));
            }
        }
        if (!isset($contact))
            $contact = $user;

        if (!isset($model)) {
            $model = new Address;
            $model->setScenario("new_main_address");
            if ($tmp = Address::model()->findByAttributes(array('user_id' => $user->id, 'categories' => Yii::t("MAIN", "MAIN")))) {
                $model->email = $tmp->email;
            }
        } else {
            $model->setScenario("update_main_address");
            // restore region
            $city = City::model()->findByPk($model->city_id);
            if (!empty($city))
                $model->RegionVN = $city->style;
        }

        $model->user_id = (isset($_GET['user_id']) && isset($contact)) ? $contact->id : $user->id;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'address-form') {
            echo CActiveForm::validate($model, array('email', 'address', 'district'));
            Yii::app()->end();
        }

        if (isset($_POST['Address'])) {
            $model->attributes = $_POST['Address'];

            $model->last_update = new CDbExpression('NOW()');
//var_dump($model);exit();
            if ($model->save()) {
                Yii::app()->user->setFlash('success', '<strong>Thành công!</strong>tạo một địa chỉ mới.!');

                if (isset($contact)) {
                    $this->redirect(array('user/view', 'id' => $contact->id));
                } else
                    $this->redirect(array('user/address', 'address_id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Fail!</strong>add an new address.! by data input wrong!');
                print_r($model->getErrors());
                var_dump($model);
                exit();
            }
        }
        $sent = r()->getParam('sent', 0);
        $this->render('address', array(
            'model' => $model,
            'sent' => $sent,
        ));
    }

    public function actionUpdateRoles() {
        $_urtos = $urtos = array();
        $dropDownRoles = "";
        if (($role = Yii::app()->getRequest()->getParam('parentname', null)) && (Yii::app()->authManager->getAuthItem($role) !== null)) {
            $_urtos[] = AuthItem::model()->findByPk($role);
            if (Yii::app()->authManager->getItemChildren($role)) {
                $this->findAllRTOByParent($role, $_urtos);
            }
            foreach ($_urtos as $value) {
                $urtos[] = $value->name;
            }
            $criteria = new CDbCriteria();
            $criteria->addInCondition('name', $urtos);
            $criteria->order = 'name ASC';

            $data = CHtml::listData(AuthItem::model()->findAll($criteria), 'name', 'name');

            foreach ($data as $value => $name)
                $dropDownRoles .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        echo CJSON::encode(array(
            'dropDownRoles' => $dropDownRoles
        ));
    }

    public function actionCheckRolesUsers() {
        if (($roles = Yii::app()->getRequest()->getParam('childnames', array())) && (count($roles) > 0)) {
            // check role and user
            echo CJSON::encode(array(
                'result' => true
            ));
        } else
            echo CJSON::encode(array(
                'result' => false
            ));
    }

    public function actionUpdateAuthItems() {
        $type = $_POST['parenttype'];
        $data = CHtml::listData(AuthItem::model()->findAll('type=:type', array(':type' => $type)), 'name', 'name');
        $dropAuthItems = "<option value=''>Chọn Quyền Cha</option>";
        foreach ($data as $value => $name)
            $dropAuthItems .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropAuthItems' => $dropAuthItems
        ));
    }

    public function actionUpdateAuthItemChilds() {
        $type = $_POST['parenttype'];
        $data = CHtml::listData(AuthItem::model()->findAll('type=:type', array(':type' => $type)), 'name', 'name');
        $dropAuthItems = "<option value=''>Chọn loại quyền</option>";
        foreach ($data as $value => $name)
            $dropAuthItems .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropAuthItems' => $dropAuthItems
        ));
    }

    public function actionRoView() {
        $id = Yii::app()->getRequest()->getParam('role', null);
        $auth = Yii::app()->authManager;
        if (!isset($id))
            $this->redirect('index');
        else {
            $item = $auth->getAuthItem($id);
            if ($item === null)
                $this->redirect('index');
        }
        $roles = $tasks = $operators = array();
        $this->getRTO($id, $roles, $tasks, $operators);
        $data = array();
        $data['item'] = AuthItem::model()->findByPk($id);
        if (isset($roles))
            $data['roles'] = $roles;
        if (isset($tasks))
            $data['tasks'] = $tasks;
        if (isset($operators))
            $data['operators'] = $operators;

        $this->render('roview', $data);
    }

    public function actionRoCreate() {
        $type = Yii::app()->getRequest()->getParam('type', null);
        if (!isset($type) || !in_array(Lookup::item("TypeRoles", $type), Lookup::items('TypeRoles')))
            $this->redirect('index');
        $model = new AuthItem("create");
        $model->type = $type;
        $this->performAjaxValidation($model);

        if (isset($_POST['AuthItem'])) {
            $model->attributes = $_POST['AuthItem'];
            if ($model->save())
                $this->redirect(array('roView', 'role' => $model->name));
        }
        $sent = r()->getParam('sent', 0);
        $this->render('rocreate', array(
            'model' => $model,
//                'authitems_role' => $authitems_role,
//                'authitems_task' => $authitems_task,
//                'authitems_operator' => $authitems_operator,
            'sent' => $sent,
        ));
    }

    public function actionRoUpdate() {
        $id = Yii::app()->getRequest()->getParam('role', null);
        $auth = Yii::app()->authManager;
        if (!isset($id))
            $this->redirect('index');
        else {
            $item = $auth->getAuthItem($id);
            if ($item === null)
                $this->redirect('index');
        }
        $model = AuthItem::model()->findByPk($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['AuthItem'])) {
            $model->attributes = $_POST['AuthItem'];
            if ($model->save())
                $this->redirect(array('roView', 'role' => $model->name));
        }
        $sent = r()->getParam('sent', 0);
        $this->render('rocreate', array(
            'model' => $model,
//                'authitems_role' => $authitems_role,
//                'authitems_task' => $authitems_task,
//                'authitems_operator' => $authitems_operator,
            'sent' => $sent,
        ));
    }

    public function actionRoAddSubRoles() {
        $id = Yii::app()->getRequest()->getParam('role', null);
        $auth = Yii::app()->authManager;
        if (!isset($id))
            $this->redirect('index');
        else {
            $item = $auth->getAuthItem($id);
            if ($item === null)
                $this->redirect('index');
        }
        $model = AuthItem::model()->findByPk($id);

        $aOItem = new AuthItem('searchByType');
        $aOItem->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($aOItem));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($aOItem)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($aOItem)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($aOItem) . '_page'])) {
            $newsPage = (int) $_GET[get_class($aOItem) . '_page'] - 1;
            Yii::app()->user->setState(get_class($aOItem) . '_page', $newsPage);
            unset($_GET[get_class($aOItem) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($aOItem) . '_page', 0);
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['AuthItem'])) {
            $model->attributes = $_POST['AuthItem'];
            if ($model->save())
                $this->redirect(array('roView', 'role' => $model->name));
        }
        $sent = r()->getParam('sent', 0);
        $this->render('roaddsubroles', array(
            'model' => $model,
//                'authitems_role' => $authitems_role,
//                'authitems_task' => $authitems_task,
            'aOItem' => $aOItem,
            'sent' => $sent,
        ));
    }

    public function actionRoAddUsersRole() {
        $id = Yii::app()->getRequest()->getParam('role', null);
        $auth = Yii::app()->authManager;
        if (!isset($id))
            $this->redirect('index');
        else {
            $item = $auth->getAuthItem($id);
            if ($item === null)
                $this->redirect('index');
        }
        $model = AuthItem::model()->findByPk($id);

        $aOItem = new AuthItem('searchByType');
        $aOItem->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($aOItem));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($aOItem)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($aOItem)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($aOItem) . '_page'])) {
            $newsPage = (int) $_GET[get_class($aOItem) . '_page'] - 1;
            Yii::app()->user->setState(get_class($aOItem) . '_page', $newsPage);
            unset($_GET[get_class($aOItem) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($aOItem) . '_page', 0);
        }

        $userItem = new User('searchByType');
        $userItem->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($userItem));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($userItem)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($userItem)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($userItem) . '_page'])) {
            $newsPage = (int) $_GET[get_class($userItem) . '_page'] - 1;
            Yii::app()->user->setState(get_class($userItem) . '_page', $newsPage);
            unset($_GET[get_class($userItem) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($userItem) . '_page', 0);
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['AuthItem'])) {
            $model->attributes = $_POST['AuthItem'];
            if ($model->save())
                $this->redirect(array('roView', 'role' => $model->name));
        }
        $sent = r()->getParam('sent', 0);
        $this->render('roaddusersrole', array(
            'model' => $model,
//                'authitems_role' => $authitems_role,
//                'authitems_task' => $authitems_task,
            'aOItem' => $aOItem,
            'userItem' => $userItem,
            'sent' => $sent,
        ));
    }

    public function actionRemoveSubRole() {
        $auth = Yii::app()->authManager;
        $parent = Yii::app()->getRequest()->getParam('parent', null);
        $child = Yii::app()->getRequest()->getParam('child', null);
        if (($parent !== null) && ($child !== null)) {
            if ($auth->hasItemChild($parent, $child)) {
                $auth->removeItemChild($parent, $child);
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAddSubRole() {
        $auth = Yii::app()->authManager;
        $parent = Yii::app()->getRequest()->getParam('parent', null);
        $child = Yii::app()->getRequest()->getParam('child', null);
        if (($parent !== null) && ($child !== null)) {
            if (!$auth->hasItemChild($parent, $child)) {
                $auth->addItemChild($parent, $child);
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAddUserRole() {
        $auth = Yii::app()->authManager;
        $parent = Yii::app()->getRequest()->getParam('parent', null);
        $child = Yii::app()->getRequest()->getParam('child', null);
        if (($parent !== null) && ($child !== null)) {
            if (!$auth->hasItemChild($parent, $child)) {
                $auth->addItemChild($parent, $child);
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionRoDelete() {
        $auth = Yii::app()->authManager;
        $id = Yii::app()->getRequest()->getParam('role', null);
        if (Yii::app()->user->checkAccess('supper')) {

            if (!isset($id) && !isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            else {
                $item = $auth->getAuthItem($id);
                if (($item === null) && (!isset($_GET['ajax'])))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }

            if (isset($id) || ($item !== null)) {
                $roles = $tasks = $operators = array();
                $this->getRTO($id, $roles, $tasks, $operators);
                $data = array();
                $data['item'] = AuthItem::model()->findByPk($id);
                if (isset($roles))
                    $data['roles'] = $roles;
                if (isset($tasks))
                    $data['tasks'] = $tasks;
                if (isset($operators))
                    $data['operators'] = $operators;

                $baserole = RoleHelper::getLabel($id);
                if ($baserole != false) {
                    $data['message'] = " Quyền định nghĩa sẳn [Quyền cơ bản] trong hệ thống không được xóa ";
                } elseif (!empty($roles) || !empty($tasks) || !empty($operators)) {
                    // cho phep xoa neu force duoc set = true
                    if ($force = Yii::app()->getRequest()->getParam('force', null)) {
                        if ($authitemchilds = $auth->getItemChildren($id)) {
                            foreach ($authitemchilds as $authitemchild) {
                                if ($authitemchild->type == 2)
                                    $roles[] = $authitemchild;
                                elseif ($authitemchild->type == 1)
                                    $tasks[] = $authitemchild;
                                else
                                    $operators[] = $authitemchild;
                                // delete child and save it in arrays $roles, $tasks, $operators
                                $auth->removeItemChild($id, $authitemchild->name);
                            }
                        }
                        $auth->removeAuthItem($id); // delete parent
                    } else
                        $data['message'] = " Quyền không thể xóa vì Nó có quyền con";
                }
                else {
                    if ($authitemchilds = $auth->getItemChildren($id)) {
                        foreach ($authitemchilds as $authitemchild) {
                            if ($authitemchild->type == 2)
                                $roles[] = $authitemchild;
                            elseif ($authitemchild->type == 1)
                                $tasks[] = $authitemchild;
                            else
                                $operators[] = $authitemchild;
                            // delete child and save it in arrays $roles, $tasks, $operators
                            $auth->removeItemChild($id, $authitemchild->name);
                        }
                    }
                    $auth->removeAuthItem($id); // delete parent
                }
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> xóa quyền [$id].!");
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                } else
                    $this->renderPartial('rodelete', $data, false, true);
                Yii::app()->end();
            }
            elseif (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            } else {
                throw new CHttpException(400, 'Invalid request [The Role not exist in system]. Please do not repeat this request again.');
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAssDelete() {
        $auth = Yii::app()->authManager;
        $role = Yii::app()->getRequest()->getParam('role', null);
        $user = Yii::app()->getRequest()->getParam('id', null);
        if (Yii::app()->user->checkAccess('supper') && isset($role) && isset($user)) {
            if (Yii::app()->user->id != $user) {
                //obtains all assigned roles for this user id
                if ($roleAssigned = $auth->getRoles($user)) { //checks that there are assigned roles            
                    foreach ($roleAssigned as $n => $role) {
                        if ($auth->revoke($n, $user)) //remove each assigned role for this user
                            Yii::app()->authManager->save(); //again always save the result
                    }
                }
                if ($auth->revoke(Yii::app()->user->username, Yii::app()->user->id)) //remove each assigned role for this user
                    Yii::app()->authManager->save(); //again always save the result
            }
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            } else
                $this->redirect($_POST['returnUrl']);
        }
    }

    public function actionViewRTO() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (empty($user) || !Yii::app()->user->checkAccess('admin')) {
            Yii::app()->user->setFlash('error', "<strong>Lỗi!</strong>Bạn không có quyền thực hiện việc này.!");
            $this->redirect(array('process/login'));
        }
        try {
            $criteria = new CDbCriteria();
            $criteria->condition = "type =:type";
            $criteria->order = 'level ASC';

            $criteria->params = array(':type' => 1);
            $authitems_task = AuthItem::model()->findAll($criteria);

            $criteria->params = array(':type' => 0);
            $authitems_operator = AuthItem::model()->findAll($criteria);

            $criteria->params = array(':type' => 2);

            $authitems_role = AuthItem::model()->findAll($criteria);
        } catch (Exception $exc) {
            Yii::app()->user->setFlash('error', "<strong>Lỗi!</strong> Khi lấy dữ liệu trong hệ thống.!");
            $this->redirect(array('process/login'));
        }
        $data = array();
        $data["authitems_role"] = $authitems_role;
        $data["authitems_task"] = $authitems_task;
        $data["authitems_operator"] = $authitems_operator;

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                '*.js' => false,
                '*.css' => false,
            );
            $this->renderPartial('_viewRTO', $data, false, true);
            Yii::app()->end();
        } else {
            $sent = r()->getParam('sent', 0);
            $this->render('viewRTO', array(
                'authitems_role' => $authitems_role,
                'authitems_task' => $authitems_task,
                'authitems_operator' => $authitems_operator,
                'sent' => $sent,
            ));
        }
    }

    public function getPRTO($name, &$parentitems) {
        $auth = Yii::app()->authManager;
        $criteria = new CDbCriteria;
        $criteria->compare('child', $name);
        $parents = AuthItemChild::model()->findAll($criteria);
        foreach ($parents as $parentitem) {
            //$parent = $auth->getAuthItem($parentitem->parent);
            $parentitems[] = $parentitem;
            $this->getPRTO($parentitem->parent, $parentitems);
        }
    }

    public function getRTO($parent = null, &$roles, &$tasks, &$operators) {
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $authitemchild) {
                if ($authitemchild->type == 2)
                    $roles[] = $authitemchild;
                elseif ($authitemchild->type == 1)
                    $tasks[] = $authitemchild;
                else
                    $operators[] = $authitemchild;
                $this->getRTO($authitemchild->name, $roles, $tasks, $operators);
            }
        }
    }

    public function actionReloadRTO4U() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_urto');
            Yii::app()->end();
        } else {
            header('Content-type: text/plain');
            Yii::app()->user->setFlash('error', '<strong>Fail!</strong> Error access.');
            $this->redirect('index');
        }
    }

    public function actionModifyRTO4U() {
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        if (Yii::app()->request->isAjaxRequest) {
            $info = '';
            $_method = '';
            $name = 'noname';
            $status = true;
            $auth = Yii::app()->authManager;
            try {
                if (isset($_POST['name'])) {
                    $name = isset($_POST['name']) ? $_POST['name'] : $name;
                    $uni_id = Yii::app()->user->getState('RTOuid');
                    $_mRTOsById = Yii::app()->user->getState($uni_id . '_mRTOsById');
                    //$_mRTOsInSystem = Yii::app()->user->getState($uni_id . '_mRTOsInSystem');
                    //Here we check if we are deleting and uploaded file
                    if (isset($_POST["_method"])) {
                        $_method = isset($_POST["_method"]) ? $_POST["_method"] : $_method;
                        if (isset($_POST['user_id']) && ($u = User::model()->findByPk($_POST['user_id']))) {
                            if (!($rou = $auth->getAuthItem($u->username))) {
                                // Quyền Riêng của User này chưa được tạo. Tạo nó bây giờ
                                $auth->createAuthItem($u->username, 2);
                            }
                        }

                        switch ($_method) {
                            case "remove":
                                /*
                                 * Tên Quyền và Tên User không được giống nhau
                                 * Những user hệ thống thì không cho remove quyền bởi nó được tạo mặc định
                                 * Chỉ xóa các quyền được cấp cho user đó chứ không được xóa quyền thừa kế không thuộc user đó.
                                 */
                                if (($u->username != $name) && ($auth->hasItemChild($u->username, $name)) && (!in_array($u->username, RoleHelper::getLevelList()))) {
                                    if ($auth->removeItemChild($u->username, $name)) {
                                        foreach ($_mRTOsById as $key => $_mRTOById) {
                                            if ($_mRTOById->name == $name) {
                                                unset($_mRTOsById[$key]);
                                                Yii::app()->user->setState($uni_id . '_mRTOsById', $_mRTOsById);
                                                break;
                                            }
                                        }
                                        $uclogin = User::model()->findByPk(Yii::app()->user->id);
                                        $info .= 'Quyền: [[' . $name . ']] đã được xóa. Tài khoản đăng nhập [[' . $uclogin->username . ']] có Quyền [[' . $uclogin->role . ']]';
                                    } else {
                                        throw new Exception('Lỗi do name không tồn tại hoặc không được gửi đến server');
                                    }
                                } elseif (Yii::app()->user->checkAccess('supper') && $auth->hasItemChild($u->username, $name)) {
                                    if ($auth->removeItemChild($u->username, $name)) {
                                        $uclogin = User::model()->findByPk(Yii::app()->user->id);
                                        $info .= 'Quyền: [[' . $name . ']] đã được xóa. Tài khoản đăng nhập [[' . $uclogin->username . ']] có Quyền cao nhất trong hệ thống. Quyền [[supper]]';
                                        foreach ($_mRTOsById as $key => $_mRTOById) {
                                            if ($_mRTOById->name == $name) {
                                                unset($_mRTOsById[$key]);
                                                Yii::app()->user->setState($uni_id . '_mRTOsById', $_mRTOsById);
                                                break;
                                            }
                                        }
                                    } else {
                                        throw new Exception('Lỗi do name không tồn tại hoặc không được gửi đến server');
                                    }
                                } else {
                                    $parentitems = array();
                                    $stack = array();
                                    foreach ($_mRTOsById as $_mRTOById) {
                                        array_push($stack, $_mRTOById->name);
                                    }
                                    $this->getPRTO($name, $parentitems);
                                    $info .= 'Quyền: [[' . $name . ']] không thể xóa. Cần phải xóa Quyền Cha: ';
                                    foreach ($parentitems as $parentitem) {
                                        if (in_array($parentitem->parent, $stack)) {
                                            $info .= '[[' . $parentitem->parent . ']]';
                                        }
                                    }
                                    //$info .= CJSON::encode($stack);
                                    $info .= 'Sau đó mới có thể xóa Quyền [[' . $name . ']]. Bởi Quyền này được Thừa kế chứ <b>Không Cấp Trực Tiếp</b> cho Thành viên <b>[[' . $u->username . ']]</b>';
                                    $status = false;
                                }
                                break;
                            case "add":
                                /*
                                 * Tên Quyền và Tên User không được giống nhau
                                 * Những user hệ thống thì không cho cấp quyền bởi nó được tạo mặc định
                                 * Cấp cho user quyền phải khác quyền hiện có của user.
                                 */

                                if (($u->username != $name) && (!$auth->hasItemChild($u->username, $name)) && (!in_array($name, RoleHelper::getLevelList()))) {
                                    if ($auth->addItemChild($u->username, $name) && ($_mRTOById = $auth->getAuthItem($name))) {
                                        $_mRTOsById[] = $_mRTOById;
                                        Yii::app()->user->setState($uni_id . '_mRTOsById', $_mRTOsById);
                                        $info .= 'Quyền: [[' . $name . ']] đã thêm cho thành viên <b>[[' . $u->username . ']]</b>';
                                    } else {
                                        throw new Exception('Lỗi do name [[' . $name . ']] không tồn tại hoặc không được gửi đến server');
                                    }
                                } elseif (Yii::app()->user->checkAccess('supper') && !$auth->hasItemChild($u->username, $name)) {
                                    if ($auth->addItemChild($u->username, $name) && ($_mRTOById = $auth->getAuthItem($name))) {
                                        $_mRTOsById[] = $_mRTOById;
                                        Yii::app()->user->setState($uni_id . '_mRTOsById', $_mRTOsById);
                                        $uclogin = User::model()->findByPk(Yii::app()->user->id);
                                        $info .= 'Quyền: [[' . $name . ']] đã thêm cho thành viên <b>[[' . $u->username . ']]</b>. Tài khoản đăng nhập [[' . $uclogin->username . ']] có Quyền cao nhất trong hệ thống. Quyền [[supper]]';
                                    } else {
                                        throw new Exception('Lỗi do name [[' . $name . ']] không tồn tại hoặc không được gửi đến server');
                                    }
                                } else {
                                    $info .= 'Quyền: [[' . $name . ']] không thể thêm. Cho thành viên <b>[[' . $u->username . ']]</b>';
                                    $status = false;
                                }
                                break;
                            case "restore":
                                $_mRTOsById = $this->findAllRTOByUser($u->id);
                                Yii::app()->user->setState($uni_id . '_mRTOsById', $_mRTOsById);
                                break;
                            default :
                                $info .= 'Hành động này không hợp lệ';
                                $status = false;
                                break;
                        }
                    }
                    echo CJSON::encode(array('_method' => $_method, 'status' => $status, 'name' => $name, 'info' => $info));
                } else
                    throw new Exception('Lỗi do name không tồn tại hoặc không được gửi đến server');
            } catch (Exception $exc) {
                $info .= 'Hành động này không hợp lệ ' . $exc->getMessage();
                echo CJSON::encode(array('_method' => $_method, 'status' => false, 'name' => $name, 'info' => $info));
            }
            Yii::app()->end();
        } else {
            header('Content-type: text/plain');
            Yii::app()->user->setFlash('error', '<strong>Fail!</strong> Error access.');
            $this->redirect('index');
        }
    }

    public function actionUpdateRTO4U() {
        $auth = Yii::app()->authManager;
        $data = array();

        $roles = array();
        $tasks = array();
        $operators = array();
        try {
            if (isset($_GET['user_id']) || isset($_POST['user_id'])) {
                $name = isset($_POST['name']) ? $_POST['name'] : $_GET['name'];
                $uni_id = Yii::app()->user->getState('RTOuid');
                $_mRTOsById = Yii::app()->user->getState($uni_id . '_mRTOsById');
                $_mRTOsInSystem = Yii::app()->user->getState($uni_id . '_mRTOsInSystem');
                $data["roles"] = $roles;
                $data["tasks"] = $tasks;
                $data["operators"] = $operators;
                $data["show"] = true;
            }
        } catch (Exception $exc) {
            
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                '*.js' => false,
                '*.css' => false,
            );
            $this->renderPartial('_addRTO4U', $data, false, true);
            Yii::app()->end();
        }
    }

    public function actionCreateRTO() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $auth = Yii::app()->authManager;
        $data = array();

        $child = isset($_POST['child']) ? $_POST['child'] : isset($_GET['child']) ? $_GET['child'] : null;
        $parent = isset($_POST['parent']) ? $_POST['parent'] : isset($_GET['parent']) ? $_GET['parent'] : null;

        if ($auth->getAuthItem($child) !== null) {
            $authitem = AuthItem::model()->findByPk($child);
            $authitem->scenario = "update";
        } else {
            $authitem = new AuthItem("create");
        }


        if ($auth->getAuthItem($parent) !== null) {
            $pauthitem = AuthItem::model()->findByPk($parent);
            $authitem->parentname = $pauthitem->name;
            $authitem->type = $pauthitem->type;
            $pauthitem->scenario = "view";
        } else {
            $pauthitem = new AuthItem("list");
        }

        if (($child == null) & ($parent == null)) {
            $action = isset($_POST['action']) ? $_POST['action'] : isset($_GET['action']) ? $_GET['action'] : null;
            if (($action != null) & ($action == 'createRPC')) {
                $authitem->scenario = "list";
                $pauthitem->scenario = "list";
            } elseif (($action != null) & ($action == 'create')) {
                $authitem->scenario = "create";
                $pauthitem->scenario = "list";
            }
        }
        $data["model"] = $authitem;
        $data["parent"] = $pauthitem;
        if (Yii::app()->user->hasState('roleDiv'))
            Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), $data);

        if (isset($_POST['AuthItem'])) {
            $authitem->attributes = $_POST['AuthItem'];
            if ($authitem->validate()) {
                try {
                    if ($auth->getAuthItem($authitem->name) === null) {
                        switch ($authitem->type) {
                            case 2:
                                $auth->createRole($authitem->name, 'Create a Roles from System by ' . $user->username);
                                break;
                            case 1:
                                $bizRule = null;
                                $task = $auth->createTask($authitem->name, 'Create a Task from System by' . $user->username, $bizRule);
                                break;
                            default :
                                $auth->createOperation($authitem->name, 'Create a Operator from System by' . $user->username);
                                break;
                        }
                        if ($authitem->parentname) {
                            $p = AuthItem::model()->findByPk($authitem->parentname);
                            if ($p->type == 0) {
                                Yii::app()->user->setFlash('error', "<strong>Lỗi! </strong> không nên tạo quyền con cho quyền thực thi trong hệ thống. Vì rất khó để quản lý các hành động như vậy. Nên tạo hành động thực thi là hành hành động đơn!");
                                $this->redirect(array('user/viewRTO'));
                            }
                        }
                        if (isset($authitem->parentname))
                            $auth->addItemChild($authitem->parentname, $authitem->name);
                        elseif (isset($_POST['AuthItem']['parentname']))
                            $auth->addItemChild($_POST['AuthItem']['parentname'], $authitem->name);
                        $auth->save();
                    }
                } catch (Exception $exc) {
                    Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), null);
                }
                $authitem = new AuthItem("create");
                $authitem->unsetAttributes();
                $data["model"] = $data["parent"] = $authitem;
                Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), null);
                Yii::app()->user->setState('roleDiv', null);
                Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> lưu dữ liệu trong hệ thống.!");
                $this->redirect(array('user/viewRTO'));
            } elseif (($action != null) & ($action == 'createRPC')) {
                $p = AuthItem::model()->findByPk($authitem->parentname);
                $c = AuthItem::model()->findByPk($authitem->name);
                if (( ($p != null) & ($c != null) ) && (!$auth->hasItemChild($p->name, $c->name))) {
                    $auth->addItemChild($p->name, $c->name);
                    Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), null);
                    Yii::app()->user->setState('roleDiv', null);
                    Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> Cập nhật quan hệ trong hệ thống.!");
                    $this->redirect(array('user/viewRTO'));
                }
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                '*.css' => false,
            );
            $this->renderPartial('_ajaxrto', $data, false, true);
            Yii::app()->end();
        } else {
            $this->redirect(array('user/viewRTO'));
        }
    }

    public function actionUpdateRTO() {
        $auth = Yii::app()->authManager;
        $data = array();

        $roles = array();
        $tasks = array();
        $operators = array();
        try {
            if (isset($_GET['name']) || isset($_POST['name'])) {
                $name = isset($_POST['name']) ? $_POST['name'] : $_GET['name'];
                if ($auth->getAuthItem($name) !== null) {
                    $authitem = AuthItem::model()->findByPk($name);
                    if (Yii::app()->user->hasState('childDiv')) {
                        Yii::app()->user->setState(Yii::app()->user->getState('childDiv'), $authitem);
                        Yii::app()->user->setState('nameofparent', $name);
                    }
                    if ($auth->getItemChildren($name)) {
                        $this->getRTO($name, $roles, $tasks, $operators);
                        $data["roles"] = $roles;
                        $data["tasks"] = $tasks;
                        $data["operators"] = $operators;
                        $data["show"] = true;
                        $data["name"] = $name;
                    }
                }
            } else {
                Yii::app()->user->setState(Yii::app()->user->getState('childDiv'), null);
                Yii::app()->user->setState('nameofparent', null);
            }
        } catch (Exception $exc) {
            
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                '*.js' => false,
                '*.css' => false,
            );
            $this->renderPartial('_subrto', $data, false, true);
            Yii::app()->end();
        } else {
            $this->redirect(array('site/index'));
        }
    }

    public function deleteRTO($parent, &$roles, &$tasks, &$operators) {
        if (!Yii::app()->user->checkAccess('admin')) {
            return false;
        }
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $authitemchild) {
                if ($authitemchild->type == 2)
                    $roles[] = $authitemchild;
                elseif ($authitemchild->type == 1)
                    $tasks[] = $authitemchild;
                else
                    $operators[] = $authitemchild;
                // delete child and save it in arrays $roles, $tasks, $operators
                $auth->removeItemChild($parent, $authitemchild->name);
            }
        }
        elseif (RoleHelper::getLevel($parent)) {
            return false;
        } else {
            return $auth->removeAuthItem($parent); // delete parent
        }
    }

    public function actionDeleteRTO() {
        if (!Yii::app()->user->checkAccess('admin')) {
            Yii::app()->user->setFlash('error', "<strong>Thất bại! </strong> Bạn không có quyền thực hiện chức năng này.!");
            $this->redirect(array('user/viewRTO'));
        }
        $auth = Yii::app()->authManager;
        $roles = array();
        $tasks = array();
        $operators = array();
        $role = isset($_POST['role']) ? $_POST['role'] : isset($_GET['role']) ? $_GET['role'] : null;
        $prole = isset($_POST['prole']) ? $_POST['prole'] : isset($_GET['prole']) ? $_GET['prole'] : null;
        $crole = isset($_POST['crole']) ? $_POST['crole'] : isset($_GET['crole']) ? $_GET['crole'] : null;

        if (($role != null) && ($auth->getAuthItem($role) != null)) {
            $authitem = AuthItem::model()->findByPk($role);
            if ($authitemchilds = $auth->getItemChildren($authitem->name)) {
                // we only delete childs of role
                foreach ($authitemchilds as $authitemchild) {
                    if ($authitemchild->type == 2)
                        $roles[] = $authitemchild;
                    elseif ($authitemchild->type == 1)
                        $tasks[] = $authitemchild;
                    else
                        $operators[] = $authitemchild;
                    // delete child and save it in arrays $roles, $tasks, $operators
                    $auth->removeItemChild($authitem->name, $authitemchild->name);
                }
            }
            else {
                if (!RoleHelper::getLevel($authitem->name)) {
                    if ($authitem->type == 2)
                        $roles[] = $authitem;
                    elseif ($authitem->type == 1)
                        $tasks[] = $authitem;
                    else
                        $operators[] = $authitem;
                    $auth->removeAuthItem($authitem->name); //remove if it don't have child
                }
                else {
                    Yii::app()->user->setFlash('error', "<strong>Thất bại! </strong> quyền này thuộc quyền hệ thống không cho xóa.!");
                    $this->redirect(array('user/viewRTO'));
                }
            }
            Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> lưu dữ liệu trong hệ thống.!");
            $this->redirect(array('user/viewRTO'));
        } elseif ((($prole != null) & ($crole != null)) && ( ($auth->getAuthItem($prole) != null) & ($auth->getAuthItem($crole) != null) )) {
            $pauthitem = AuthItem::model()->findByPk($prole);
            $cauthitem = AuthItem::model()->findByPk($crole);
            $auth->removeItemChild($pauthitem->name, $cauthitem->name);
            Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> lưu dữ liệu trong hệ thống.!");
            $this->redirect(array('user/viewRTO'));
        }

        if (($auth->getAuthItem($role) === null) || ($auth->getAuthItem($prole) === null) || ($auth->getAuthItem($crole) === null)) {
            Yii::app()->user->setFlash('error', "<strong>Lỗi! </strong> Quyền không tồn tại hoặc không có quyền này.!");
            $this->redirect(array('user/viewRTO'));
        }
    }

    public function actionCreateRPC() {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $auth = Yii::app()->authManager;
        $data = array();

        $authitem = new AuthItem("create");
        $pauthitem = new AuthItem("list");

        $action = isset($_POST['action']) ? $_POST['action'] : isset($_GET['action']) ? $_GET['action'] : null;
        if (($action != null) & ($action == 'createRPC')) {
            $authitem->scenario = "list";
            $pauthitem->scenario = "list";
        } else
            $this->redirect(array('user/viewRTO'));
        $data["model"] = $authitem;
        $data["parent"] = $pauthitem;
        if (Yii::app()->user->hasState('roleDiv'))
            Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), $data);

        if (isset($_POST['AuthItem'])) {
            $authitem->attributes = $_POST['AuthItem'];
            $p = AuthItem::model()->findByPk($authitem->parentname);
            $c = AuthItem::model()->findByPk($authitem->name);
            if (((($p != null) & ($c != null)) && ($p->type != 0)) && (!$auth->hasItemChild($p->name, $c->name))) {
                $auth->addItemChild($p->name, $c->name);
                Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), null);
                Yii::app()->user->setState('roleDiv', null);
                Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> Cập nhật quan hệ trong hệ thống.!");
                $this->renderPartial('_ajaxrto', $data, false, true);
                Yii::app()->end();
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                '*.js' => false,
                '*.css' => false,
            );
            $this->renderPartial('_ajaxrto', $data, false, true);
            Yii::app()->end();
        } else {
            $this->redirect(array('user/viewRTO'));
        }
    }

    public function actionManageRPC() {
        if (!Yii::app()->user->checkAccess('admin')) {
            Yii::app()->user->setFlash('fail', "<strong>Thất bại! </strong> Bạn không có quyền trong hệ thống.!");
            $this->redirect(array('user/index'));
        }
        $auth = Yii::app()->authManager;
        $action = isset($_POST['action']) ? $_POST['action'] : isset($_GET['action']) ? $_GET['action'] : null;

        $model = new AuthItem("manageRPC");

        if (isset($_POST['AuthItem'])) {
            $authitem->attributes = $_POST['AuthItem'];
            if ($authitem->validate()) {
                try {
                    if ($auth->getAuthItem($authitem->name) === null) {
                        switch ($authitem->type) {
                            case 2:
                                $auth->createRole($authitem->name, 'Create a Roles from System by ' . $user->username);
                                break;
                            case 1:
                                $bizRule = null;
                                $task = $auth->createTask($authitem->name, 'Create a Task from System by' . $user->username, $bizRule);
                                break;
                            default :
                                $auth->createOperation($authitem->name, 'Create a Operator from System by' . $user->username);
                                break;
                        }
                        if (isset($authitem->parentname))
                            $auth->addItemChild($authitem->parentname, $authitem->name);
                        elseif (isset($_POST['AuthItem']['parentname']))
                            $auth->addItemChild($_POST['AuthItem']['parentname'], $authitem->name);
                        $auth->save();
                    }
                } catch (Exception $exc) {
                    Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), null);
                }
                $authitem = new AuthItem("create");
                $authitem->unsetAttributes();
                $data["model"] = $data["parent"] = $authitem;
                Yii::app()->user->setState(Yii::app()->user->getState('roleDiv'), null);
                Yii::app()->user->setState('roleDiv', null);
                Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> lưu dữ liệu trong hệ thống.!");
                $this->redirect(array('user/viewRTO'));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_manageRPC', $data, false, true);
            Yii::app()->end();
        } else {
            $sent = r()->getParam('sent', 0);
            $this->render('manageRPC', array(
                'model' => $model,
                'sent' => $sent,
            ));
        }
    }

    public function deleteRPC($parent, &$roles, &$tasks, &$operators) {
        if (!Yii::app()->user->checkAccess('supper')) {
            return false;
        }
        $auth = Yii::app()->authManager;
        if ($authitemchilds = $auth->getItemChildren($parent)) {
            foreach ($authitemchilds as $authitemchild) {
                if ($authitemchild->type == 2)
                    $roles[] = $authitemchild;
                elseif ($authitemchild->type == 1)
                    $tasks[] = $authitemchild;
                else
                    $operators[] = $authitemchild;
                // delete child and save it in arrays $roles, $tasks, $operators
                $this->deleteRPC($authitemchild->name, $roles, $tasks, $operators);
            }
        } elseif (RoleHelper::getLevel($parent)) {
            return false;
        } else
            return $auth->removeAuthItem($parent); // delete parent
    }

    public function actionDeleteRPC() {
        if (!Yii::app()->user->checkAccess('supper')) {
            Yii::app()->user->setFlash('error', "<strong>Thất bại! </strong> Bạn không có quyền thực hiện chức năng này.!");
            $this->redirect(array('user/viewRTO'));
        }
        $auth = Yii::app()->authManager;
        $data = array();
        $roles = array();
        $tasks = array();
        $operators = array();
        $role = isset($_POST['role']) ? $_POST['role'] : isset($_GET['role']) ? $_GET['role'] : null;
        $prole = isset($_POST['prole']) ? $_POST['prole'] : isset($_GET['prole']) ? $_GET['prole'] : null;
        $crole = isset($_POST['crole']) ? $_POST['crole'] : isset($_GET['crole']) ? $_GET['crole'] : null;

        if (($role != null) && ($auth->getAuthItem($role) != null)) {
            $authitem = AuthItem::model()->findByPk($role);
            if ($auth->getItemChildren($authitem->name)) {
                if ($this->deleteRPC($authitem->name, $roles, $tasks, $operators)) {
                    $data["roles"] = $roles;
                    $data["tasks"] = $tasks;
                    $data["operators"] = $operators;
                    // uncheck here to delete parent after delete all its'child
                    if (!RoleHelper::getLevel($authitem->name))
                        $auth->removeAuthItem($authitem->name);
                }
            } elseif (RoleHelper::getLevel($authitem->name)) {
                Yii::app()->user->setFlash('error', "<strong>Thất bại! </strong> quyền này thuộc quyền hệ thống không cho xóa.!");
                $this->redirect(array('user/viewRTO'));
            } else
                $auth->removeAuthItem($authitem->name);
            Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> lưu dữ liệu trong hệ thống.!");
            $this->redirect(array('user/viewRTO'));
        }
        elseif ((($prole != null) & ($crole != null)) && ( ($auth->getAuthItem($prole) != null) & ($auth->getAuthItem($crole) != null) )) {
            $pauthitem = AuthItem::model()->findByPk($prole);
            $cauthitem = AuthItem::model()->findByPk($crole);
            $auth->removeItemChild($pauthitem->name, $cauthitem->name);
            Yii::app()->user->setFlash('success', "<strong>Thành công! </strong> lưu dữ liệu trong hệ thống.!");
            $this->redirect(array('user/viewRTO'));
        }

        if (($auth->getAuthItem($role) === null) || ($auth->getAuthItem($prole) === null) || ($auth->getAuthItem($crole) === null)) {
            Yii::app()->user->setFlash('error', "<strong>Lỗi! </strong> Quyền không tồn tại hoặc không có quyền này.!");
            $this->redirect(array('user/viewRTO'));
        }
    }

    public function assignRole($role) {
        $auth = Yii::app()->authManager;
        // revoke all auth items assigned to the user
        $items = $auth->getRoles(Yii::app()->user->id);
        foreach ($items as $item) {
            $auth->revoke($item->name, Yii::app()->user->id);
        }

        // assign new role to the user
        $auth->assign($role, Yii::app()->user->id);
        $auth->save();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        //if ($model === null) throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'auth-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function isOwner() {
        if (isset($_GET['id']))
            $user = User::model()->findByPk($_GET['id']);
        else
            return false;
        if (($user != null) && ($user->id === Yii::app()->user->id))
            return true;
        else
            return false;
    }

    public function actionChooseUserandRTO() {
        $user = new User('search');
        $user->unsetAttributes();  // clear any default values
        $uni_user_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($user) . '@' . Yii::app()->user->id);
        $pageSize = Yii::app()->user->getState($uni_user_id . 'userPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_user_id . 'userPageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['User_page'])) {
            $userPage = (int) $_GET['User_page'] - 1;
            Yii::app()->user->setState('User_page', $userPage);
            unset($_GET['User_page']);
        } else
        if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('User_page', 0);
        }
        $criteria = new CDbCriteria();
        $criteria->compare('type', 1);
        $criteria->order = 'name ASC';
        $list = CHtml::listData(AuthItem::model()->findAll($criteria), 'name', 'name'/* , 'type_string' */);

        $sent = r()->getParam('sent', 0);
        $status = Yii::app()->getRequest()->getParam('status', '2');
        $tmprole = new TmpForm();
        $autoIdAll = Yii::app()->getRequest()->getParam('autoId', null);
        if (count($autoIdAll) > 0) {
            /*             * ************************************************************** */
            $tmprole->attributes = $_POST['TmpForm'];
            if ($parentname = $_POST['TmpForm']['parentname']) {
                $childnames = isset($_POST['TmpForm']['childnames']) ? $_POST['TmpForm']['childnames'] : array();
                $opt_role = isset($_POST['TmpForm']['opt_role']) ? $_POST['TmpForm']['opt_role'] : 0;
                $pai = AuthItem::model()->findByPk($parentname);
                foreach ($autoIdAll as $autoId) {
                    $_tmp_u = User::model()->findByPk($autoId);
                    if (Yii::app()->authManager->getAuthItem($_tmp_u->username) === null) {
                        Yii::app()->authManager->createRole($_tmp_u->username, 'Auto Create a Roles from username ' . $_tmp_u->username);
                        Yii::app()->authManager->save();
                    }
                    $uai = AuthItem::model()->findByPk($_tmp_u->username);
                    switch ($opt_role) {
                        case 0:
                            if ((($pai != null) & ($uai != null)) && (!Yii::app()->authManager->hasItemChild($uai->name, $pai->name))) {
                                Yii::app()->authManager->addItemChild($uai->name, $pai->name);
                                Yii::app()->authManager->save();
                            }
                            break;
                        case 1:
                            foreach ($childnames as $childname) {
                                $cai = AuthItem::model()->findByPk($childname);
                                if (!Yii::app()->authManager->hasItemChild($uai->name, $cai->name)) {
                                    // xoa quyen lap vong.
                                    if (Yii::app()->authManager->hasItemChild($cai->name, $uai->name)) {
                                        Yii::app()->authManager->removeItemChild($cai->name, $uai->name);
                                        Yii::app()->authManager->save();
                                    }
                                    // them quyen nhu da chon cho thanh vien 
                                    Yii::app()->authManager->addItemChild($uai->name, $cai->name);
                                    Yii::app()->authManager->save();
                                }
                            }
                            break;
                        case 2:
                            // xoa tat ca cac quyen da phan truoc do cho thanh vien nay
                            if ($all_uais = Yii::app()->authManager->getItemChildren($_tmp_u->username)) {
                                foreach ($all_uais as $all_uai) {
                                    if (Yii::app()->authManager->hasItemChild($_tmp_u->username, $all_uai->name)) {
                                        Yii::app()->authManager->removeItemChild($_tmp_u->username, $all_uai->name);
                                        Yii::app()->authManager->save();
                                    }
                                }
                            }
                            // them cac quyen da chon cho thanh vien
                            foreach ($childnames as $childname) {
                                $cai = AuthItem::model()->findByPk($childname);
                                if (!Yii::app()->authManager->hasItemChild($uai->name, $cai->name)) {
                                    // xoa quyen lap vong.
                                    if (Yii::app()->authManager->hasItemChild($cai->name, $uai->name)) {
                                        Yii::app()->authManager->removeItemChild($cai->name, $uai->name);
                                        Yii::app()->authManager->save();
                                    }
                                    // them quyen nhu da chon cho thanh vien 
                                    Yii::app()->authManager->addItemChild($uai->name, $cai->name);
                                    Yii::app()->authManager->save();
                                }
                            }
                            break;
                    }
                }
                echo CJSON::encode(
                        array(
                            "error" => false,
                            "autoId" => count($autoIdAll),
                            "parentname" => $parentname
                        )
                );
                Yii::app()->end();
            } else {
                echo CJSON::encode(
                        array(
                            "error" => true,
                            "autoId" => count($autoIdAll),
                            "parentname" => $parentname
                        )
                );
                Yii::app()->end();
            }
            /*             * ************************************************************** */
        } else {
            $this->render('userRTO', array(
                'user' => $user,
                'list' => $list,
                'sent' => $sent,
                'tmprole' => $tmprole
                    )
            );
        }
    }

    public function actionDelAllRoleUser() {
        $id = Yii::app()->getRequest()->getParam('id', null);
        try {
            if ($id && ($u = User::model()->findByPk($id))) {
                if ($all_uais = Yii::app()->authManager->getItemChildren($u->username)) {
                    foreach ($all_uais as $all_uai) {
                        if (Yii::app()->authManager->hasItemChild($u->username, $all_uai->name)) {
                            Yii::app()->authManager->removeItemChild($u->username, $all_uai->name);
                            Yii::app()->authManager->save();
                        }
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Thành công');
            } else {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ');
            }
            $this->redirect(array('user/chooseUserandRTO'));
        } catch (Exception $e) {
            Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionSentEmail($id = null) {
        $id = Yii::app()->getRequest()->getParam('id', $id);
        if ($id && ($u = User::model()->findByPk($id))) {
            $body = 'Thông tin Thành Viên<br/>';
            try {
                $config = array(
                    'host' => 'smtp.gmail.com',
                    'auth' => 'login',
                    'username' => 'qcdn.master@gmail.com',
                    'password' => '@dm!n1978',
                    'ssl' => 'tls',
                    'port' => 587
                );
                $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
                Zend_Mail::setDefaultTransport($transport);
                Zend_Mail::setDefaultFrom('qcdn.master@gmail.com', 'Cao Quang');
                $mail = new Zend_Mail('utf-8');
                $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
                $mail->setReplyTo('qcdn.master@gmail.com', 'qcdn.master');
                $mail->setFrom('qcdn.master@gmail.com', 'Cao Quang');
                $mail->addCc('nguyen@4sao.com', 'Nguyen 4Sao.Com');
                $mail->addBcc('guitinhtho@gmail.com', 'Gui Tinh Tho');
                $mail->addTo($u->email, isset($u->author_name) ? $u->author_name : $u->username );
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

                $mail->setSubject('Thông tin Thành Viên');
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
                $this->redirect(Yii::app()->homeUrl);
            }
        } else {
            Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong>');
            $this->redirect(array('user/chooseUserandRTO'));
        }
    }

//assume you have generated the Address model with gii too
    protected function gridAddress($data, $row) {
        $model = Address::model()->findByPk($data->address); //$data->address is the FK from the user table
        //get the view from the address CRUD controller (generated with gii)
        return $this->renderPartial('../address/view', array('model' => $model), true); //set $return = true, don't display direct
    }

}
