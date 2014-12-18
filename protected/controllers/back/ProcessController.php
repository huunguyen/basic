<?php

class ProcessController extends Controller {   
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/login';
    public $attempts = 1;
    public $counter;

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            //'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('login', 'logout', 'activation', 'lostpass', 'newpass', 'recover'),
                'roles' => array('*'),
            ),
        );
    }
    
    /**
     *
     * @return array actions
     */
    public function actionActivation($key = null, $email = null) {
        $model = new VerifyForm('verify');
        if (isset($_GET['key']) && isset($_GET['email'])) {
            $key = $_GET['key'];
            $email = $_GET['email'];
            $model = User::model()->findByAttributes(
                    array('email' => $email), array(
                'condition' => 'verified=:verified',
                'params' => array(':verified' => Yii::t('verified', 'TRUE'),),
                    )
            );
            if (!empty($model)) {
                Yii::app()->user->setFlash('success', '<strong>Success!</strong>This account is ready verified!');
                $this->redirect(array('process/login'));
            } else {
                $model = User::model()->findByAttributes(
                        array('validation_key' => $key, 'email' => $email), array('condition' => 'verified=:verified', 'params' => array(':verified' => Yii::t('verified', 'FALSE'),)
                        )
                );
                if ($model) {
                    //$key = md5(mt_rand() . mt_rand() . mt_rand());
                    $model->updateByPk($model->id, array('verified' => Yii::t('verified', 'TRUE'), 'validation_key' => $key));
                    Yii::app()->user->setFlash('success', '<strong>Success!</strong>This account is verified!');
                    $this->redirect(array('process/login'));
                }
                else
                    Yii::app()->user->setFlash('error', '<strong>Fail!</strong>This account is verified fail!');
            }
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'activation-form') {
            echo CActiveForm::validate($model, array('key', 'email'));
            Yii::app()->end();
        }

        if (isset($_POST['VerifyForm'])) {
            $model->attributes = $_POST['VerifyForm'];
            if ($model->verify()) {
                Yii::app()->user->setFlash('success', '<strong>Success!</strong>This account is verified!');
                $this->redirect(array('process/login'));
            }
        }

        //var_dump(r());
        $sent = r()->getParam('sent', 0);
        $this->render('application.views.login.activation', array(
            'model' => $model,
            'sent' => $sent,
        ));
    }

    /**
     *
     * @return array actions
     */
    public function actionLostpass() {
        $model = new VerifyForm('lostpass');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lostpass-form') {
            echo CActiveForm::validate($model, array('namekey', 'email', 'verifyCode'));
            Yii::app()->end();
        }

        if (isset($_POST['VerifyForm'])) {
            $model->attributes = $_POST['VerifyForm'];
            if ((!empty($model->email) || !empty($model->namekey)) && ($model->lostPassword())) {

                Yii::app()->user->setFlash('success', '<strong>Success!</strong>An email send to you.!');
                $this->redirect(array('process/login'));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Fail!</strong>This account is fail by data input wrong!');
            }
        }


        $sent = r()->getParam('sent', 0);
        $this->render('application.views.login.lostpass', array(
            'model' => $model,
            'sent' => $sent,
        ));
    }

    /**
     *
     * @return array actions
     */
    public function actionNewpass() {
        $model = new VerifyForm('newpass');
        if (isset($_GET['key']) && isset($_GET['email'])) {
            $key = $_GET['key'];
            $email = $_GET['email'];

            $user = User::model()->findByAttributes(
                    array('email' => $email, 'password' => $key), array(
                'condition' => 'verified=:verified',
                'params' => array(':verified' => Yii::t('verified', 'TRUE'),),
                    )
            );
            //var_dump($user); exit();
            if (!empty($user)) {
                Yii::app()->user->setFlash('success', '<strong>Success!</strong>This account is request change new password!');
                $model->email = $user->email;
                $model->key = $user->validation_key;
            } else {
                Yii::app()->user->setFlash('error', '<strong>Fail!</strong>this action is\'t permittion in system!');
                $this->redirect(array('process/login'));
            }
        } else {
            Yii::app()->user->setFlash('error', '<strong>Fail!</strong>this action is\'t permittion in system!');
            $this->redirect(array('process/login'));
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'newpass-form') {
            echo CActiveForm::validate($model, array('pass', 'confirm', 'verifyCode'));
            Yii::app()->end();
        }

        if (isset($_POST['VerifyForm'])) {
            $model->attributes = $_POST['VerifyForm'];
            if ($model->newPassword()) {
                Yii::app()->user->setFlash('success', '<strong>Success!</strong>change password.!');
                $this->redirect(array('process/login'));
            } else {
                Yii::app()->user->setFlash('error', '<strong>Fail!</strong>This account is fail!');
            }
        }


        $sent = r()->getParam('sent', 0);
        $this->render('application.views.login.newpass', array(
            'model' => $model,
            'sent' => $sent,
        ));
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
                'testLimit'=>2,
            ),
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
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
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $mmodel = UserDetail::model()->findByPk($id);
        if (empty($mmodel))
            $mmodel = new UserDetail();
        // set the parameters for the bizRule
        $params = array('User' => $model);
        // now check the bizrule for this user
        if (!Yii::app()->user->checkAccess('updateSelf', $params) && !Yii::app()->user->checkAccess('admin')) {
            throw new CHttpException(403, 'You are not authorized to perform this action');
        }
        if (isset($model->userdetail) && (!isset($mmodel)))
            $mmodel = $model->userdetail;
        try {
            if ((!empty($mmodel->avatar)) && (file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $mmodel->avatar))) {
                $mmodel->avatar = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $mmodel->avatar);
            } else {
                $mmodel->avatar = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . 'default.png');
            }
        } catch (Exception $e) {
            Yii::app()->user->setFlash('error', $e->getMessage());
        }

        $this->render('view', array(
            'model' => $model,
            'mmodel' => $mmodel
        ));
    }

    protected function captchaRequired() {
        return Yii::app()->session->itemAt('captchaRequired') >= $this->attempts;
    }

    /**
     * Action to render login form or handle user's login
     * and redirection
     */
    public function actionLogin() {
        if(!Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);
        $this->layout = "//layouts/login";
        //show code verify after some login fail
        $model = $this->captchaRequired() ? new LoginFormUser('captchaRequired') : new LoginFormUser('captchaNoRequired');
        
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model, array('username', 'password', 'verifyCode'));
            Yii::app()->end();
        }

        if (isset($_POST['LoginFormUser'])) {
            $model->attributes = $_POST['LoginFormUser'];
            if($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->homeUrl);
            } else {
                $this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
                Yii::app()->session->add('captchaRequired', $this->counter);
            }
        }
        Yii::app()->getController()->createAction('captcha')->getVerifyCode(true);
        $sent = r()->getParam('sent', 0);
        $this->render('application.views.login.login', array(
            'model' => $model,
            'sent' => $sent,
        ));
    }

    public function actionLogout() {
        if(Yii::app()->user->isGuest) $this->redirect(Yii::app()->homeUrl);
        $auth = Yii::app()->authManager; //initializes the authManager
        //obtains all assigned roles for this user id
        if ($roleAssigned = $auth->getRoles(Yii::app()->user->id)) { //checks that there are assigned roles            
            foreach ($roleAssigned as $n => $role) {
                if ($auth->revoke($n, Yii::app()->user->id)) //remove each assigned role for this user
                    Yii::app()->authManager->save(); //again always save the result
            }
        }
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if ($tmp = $this->loadModel($id)) {
            if ($this->loadModel($id)->roles !== 'admin')
                $tmp->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionCreateZip() {
        $zip = new ZipArchive();
        $destination = "/filename.zip";
        if ($zip->open($destination, ZIPARCHIVE::CREATE) !== true) {
            return false;
        }

        foreach ($doclist as $thefile) {
            $random = rand(11111, 99999);
            $filename = $random . $thefile;
            $zip->addFile($thefile->tempname, $filename);
        }
        $zip->close();
    }

    public function actionExtractZip() {
        $filename = 'filename';
        $zipfile = "/filename.zip";
        $zip = zip_open($zipfile);
        $extract = DirDetails . "/newfolder";
        if ($zip) {
            if (!is_dir($extract))
                mkdir($extract);
            while ($zip_entry = zip_read($zip)) {
                // if(zip_entry_name($zip_entry)==$filename)
                //if you need any specified file use this condition {
                $fp = fopen($extract . "/" . zip_entry_name($zip_entry), "w");
                if (zip_entry_open($zip, $zip_entry, "r")) {
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    fwrite($fp, "$buf");
                    zip_entry_close($zip_entry);
                    fclose($fp);
                    break;
                }
            }
        }
        zip_close($zip);
    }

    public function actionUpdatezip($zipfilename, $filelist) {
        $destination = Yii::app()->basePath . '/files/' . $zipfilename . ".zip";
        $zip = new ZipArchive();
        if (!$zip->open($destination)) {
            return false;
        }
        if ($filelist) {
            foreach ($filelist as $thefile) {
                $filemodel = new Filesmodle;
                $randno = rand(11111, 99999);
                $filename = $randno . $thefile->name;   // yii magic method  
                $zip->addFile($thefile->tempname, $filename);
                //$fileext=$thefile->extensionName;
                //$filemodel->Size=$thefile->size;                                           
            }
        }
        $zip->close();
    }

    public function download_file($docid, $docname) {
        $filename = "filename.zip";
        if (file_exists($filename)) {
            $path_parts = pathinfo($filename);
            $ext = strtolower($path_parts["extension"]);
            switch ($ext) {
                case "pdf": $ctype = "application/pdf";
                    break;
                case "exe": $ctype = "application/octet-stream";
                    break;
                case "zip": $ctype = "application/zip";
                    break;
                case "doc": $ctype = "application/msword";
                    break;
                case "xls": $ctype = "application/vnd.ms-excel";
                    break;
                case "ppt": $ctype = "application/vnd.ms-powerpoint";
                    break;
                case "gif": $ctype = "image/gif";
                    break;
                case "png": $ctype = "image/png";
                    break;
                case "jpg": $ctype = "image/jpg";
                    break;
                default: $ctype = "application/force-download";
            }
            $newpath = $extract . '/' . $filename;
            header("Pragma: public");
            header("Content-Type: application/$ctype");
            header("Content-Disposition: inline; filename=$docname");
            header('Content-Length: ' . filesize($filename));
            header("Accept Ranges: bytes");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            readfile("$filename");
        } else {
            echo "error";
        }
    }

    public function actionDeletefile($id, $docid) {
        $docpath = Yii::app()->basePath . '/files/livefiles/' . $docid . ".zip";
        $zip = new ZipArchive;
        if ($zip->open($docpath) === TRUE) {
            $zip->deleteName($dfilename);
            $update = Files::model()->updateAll(array('IsActive' => 0), 'FileID =' . $id);

            if ($count == 1) {
                $updatecount = Documenttable::model()->updateAll(array('IsDesired' => 1), 'DocumentID=' . $docid);
            } else {
                $error = 'failed';
            }
            $zip->close();
        } else {
            $error = "All Files Are Deletee ";
        }
    }

    public function actionUpdateCategories() {
        $style = $_POST['RegionVN'];
        //$cities = City::model()->findAll('style=:style', array(':style' => $style));
        $data = CHtml::listData(City::model()->findAll('style=:style', array(':style' => $style)), 'id', 'city');
        $dropDownCities = "<option value=''>Chọn thành phố hoặc tỉnh thành</option>";
        foreach ($data as $value => $name)
            $dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        // var_dump($dropDownCities);exit();
        // return data (JSON formatted)
        echo CJSON::encode(array(
            'dropDownCities' => $dropDownCities
        ));
        Yii::app()->end();
    }

    /*     * You have to declare the method assignRoles here also .
     * You have to call it  inside UserController::init() method.
     */
}
