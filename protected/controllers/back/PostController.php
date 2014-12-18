<?php

class PostController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

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
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('cIndex', 'index', 'view', 'create', 'update', 'comments', 'vComment', 'uComment', 'dComment'),
//                'users' => array('*'),
//            ),
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('cIndex', 'index', 'view', 'create', 'update', 'comments', 'vComment', 'uComment', 'dComment'),
                'roles' => array('supper, admin'),
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

    protected function resizePhoto($fileName, $width, $height, $inputPath = null, $outputPath = null) {
        $ext = ImageHelper::FilenameExtension($fileName);
        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpeg', 'jpg', 'gif', 'png');
        if (in_array($ext, $upload_permitted_image_types)) {
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                } else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
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
            if (!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE))
                chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

            $this->resizePhoto($fileName, 640, 480);
            $this->resizePhoto($fileName, 240, 180);
            $this->resizePhoto($fileName, 50, 50);
            return true;
        } else
            return false;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $post = $this->loadModel($id);

        $comment = $this->newComment($post);

        $this->render('view', array(
            'model' => $post,
            'comment' => $comment,
        ));
    }

    /**
     * Creates a new comment.
     * This method attempts to create a new comment based on the user input.
     * If the comment is successfully created, the browser will be redirected
     * to show the created comment.
     * @param Post the post that the new comment belongs to
     * @return Comment the comment instance
     */
    protected function newComment($post) {
        $comment = new Comment;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($post->addComment($comment)) {
                Yii::app()->user->setFlash('success', 'Thank you for your comment. Your comment will be posted once it is approved.');
                $this->refresh();
            }
        }
        return $comment;
    }

    public function actionVComment($id) {
        $model = Comment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $comment = $this->replyComment($model);
        
        $reply = new Comment('searchByReply');
        $reply->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($reply));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($reply)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($reply)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($reply) . '_page'])) {
            $newsPage = (int) $_GET[get_class($reply) . '_page'] - 1;
            Yii::app()->user->setState(get_class($reply) . '_page', $newsPage);
            unset($_GET[get_class($reply) . '_page']);
        } elseif (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($reply) . '_page', 0);
        }
        
        $this->render('vcomment', array(
            'model' => $model,
            'comment' => $comment,
            'reply' => $reply,
            'pageSize' => $pageSize,
        ));
    }

    protected function replyComment($model) {
        $comment = new Comment;
        $comment->id_parent = $model->id_comment;
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($model->replyComment($comment)) {
                Yii::app()->user->setFlash('success', 'Bạn đã trả lời phản hồi. Xem lại phản hồi ở dòng cuối cùng trong bản.');
                $this->refresh();
            }
        }
        return $comment;
    }

    public function actionUComment($id) {
        $model = Comment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        if (isset($_POST['Comment'])) {
            $model->attributes = $_POST['Comment'];
            //dump($model);exit();
            if ($model->save(false)) {
                Yii::app()->user->setFlash('success', 'Bạn đã trả lời phản hồi. Xem lại phản hồi ở dòng cuối cùng trong bản.');
                }
                else  Yii::app()->user->setFlash('error', 'Lỗi trong quá trình lưu dữ liệu.');
        }
        $this->render('ucomment', array(
            'model' => $model
        ));
    }

    public function actionDComment($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            if($comment = Comment::model()->findByPk($id)){
                if (isset($comment->comments) && ($comment->commentsCount > 0)) {
                    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
                }
                else
                    $comment->delete();
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Post;
        if (isset(Yii::app()->session['id_store']))
            $model->id_store = Yii::app()->session['id_store'];
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Post'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Post'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->img = $fileName;
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = Manufacturer::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_manufacturer, array('logo' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('post/index', 'id' => $model->id_post));
                        //$this->redirect(array('view', 'id' => $model->id_post));
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

        if (isset($_POST['Post'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Post'];
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->img = $fileName = $model->id_post . '.' . ImageHelper::FilenameExtension($fileName);
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Post::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('post/index', 'id' => $model->id_post));
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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $model = new Post('search');
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

    public function actionCIndex() {
        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
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
        $this->render('cindex', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
        
    }

    public function actionComments($id) {
        $post = $this->loadModel($id);
        $id_comment = Yii::app()->getRequest()->getParam('id_comment', null);
        if ($id_comment != null) {
            $comment = Comment::model()->findByPk($id_comment);
        } else
            $comment = new Comment;
        $model = new Comment('searchByPost');
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

        $this->render('comments', array(
            'post' => $post,
            'comment' => $comment,
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Post('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Post']))
            $model->attributes = $_GET['Post'];

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
        $model = Post::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
