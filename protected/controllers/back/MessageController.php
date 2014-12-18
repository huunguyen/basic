<?php

class MessageController extends Controller {

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
                'actions' => array('index', 'indexDetail', 'view', 'viewDetail', 'message', 'getCartsOrders', 'getCarts', 'getOrders', 'thread', 'viewThread'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'createDetail', 'updateDetail', 'sentEmail', 'updateThread'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'deleteDetail', 'delThread'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionGetCartsOrders() {
        $id_customer = Yii::app()->getRequest()->getParam('id_customer', null);
        $dropDownCart = "<option value=''>Chọn giỏ hàng [{$id_customer}]</option>";
        $dropDownOrder = "<option value=''>Chọn đơn hàng [{$id_customer}]</option>";
        if (empty($id_customer) || !isset($id_customer)) {
            echo CJSON::encode(array(
                'dropDownCart' => $dropDownCart,
                'dropDownOrder' => $dropDownOrder
            ));
            Yii::app()->end();
        } else {
            $carts = CHtml::listData(Cart::model()->findAll('id_customer=:id_customer', array(':id_customer' => $id_customer)), 'id_cart', 'secure_key');
            foreach ($carts as $value => $name) {
                $dropDownCart .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            $orders = CHtml::listData(Orders::model()->findAll('id_customer=:id_customer', array(':id_customer' => $id_customer)), 'id_order', 'secure_key');
            foreach ($orders as $value => $name) {
                $dropDownOrder .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            echo CJSON::encode(array(
                'dropDownCart' => $dropDownCart,
                'dropDownOrder' => $dropDownOrder
            ));
            Yii::app()->end();
        }
    }

    public function actionGetCarts() {
        $id_customer = Yii::app()->getRequest()->getParam('id_customer', null);
        $dropDownCart = "<option value=''>Chọn giỏ hàng [{$id_customer}]</option>";
        if (empty($id_customer) || !isset($id_customer)) {
            echo CJSON::encode(array(
                'dropDownCart' => $dropDownCart,
            ));
            Yii::app()->end();
        } else {
            $carts = CHtml::listData(Cart::model()->findAll('id_customer=:id_customer', array(':id_customer' => $id_customer)), 'id_cart', 'secure_key');
            foreach ($carts as $value => $name) {
                $dropDownCart .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }

            echo CJSON::encode(array(
                'dropDownCart' => $dropDownCart
            ));
            Yii::app()->end();
        }
    }

    public function actionGetOrders() {
        $id_customer = Yii::app()->getRequest()->getParam('id_customer', null);
        $dropDownOrder = "<option value=''>Chọn đơn hàng [{$id_customer}]</option>";
        if (empty($id_customer) || !isset($id_customer)) {
            echo CJSON::encode(array(
                'dropDownOrder' => $dropDownOrder
            ));
            Yii::app()->end();
        } else {
            $orders = CHtml::listData(Orders::model()->findAll('id_customer=:id_customer', array(':id_customer' => $id_customer)), 'id_order', 'secure_key');
            foreach ($orders as $value => $name) {
                $dropDownOrder .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            echo CJSON::encode(array(
                'dropDownOrder' => $dropDownOrder
            ));
            Yii::app()->end();
        }
    }

    public function actionGetProducts() {
        $id_order = Yii::app()->getRequest()->getParam('id_order', null);
        $dropDownProduct = "<option value=''>Chọn sản phẩm [{$id_order}]</option>";
        if (empty($id_order) || !isset($id_order)) {
            echo CJSON::encode(array(
                'dropDownOrder' => $dropDownProduct
            ));
            Yii::app()->end();
        } else {
            $orderdetails = CHtml::listData(OrderDetail::model()->findAll('id_order=:id_order', array(':id_order' => $id_order)), 'id_product', 'idProduct.name');
            foreach ($orderdetails as $value => $name) {
                $dropDownProduct .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
            echo CJSON::encode(array(
                'dropDownProduct' => $dropDownProduct
            ));
            Yii::app()->end();
        }
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
     * Lists all models.
     */
    public function actionMessage() {
        $model = new Message('search');
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

        $this->render('message', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Message;
        $model->id_user = Yii::app()->user->id;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            //dump($model);exit();
            if ($model->save())
            //$this->redirect(array('view', 'id' => $model->id_message));
                $this->redirect(array('sentEmail', 'id' => $model->id_message));
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

        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            if ($model->save())
            //$this->redirect(array('view', 'id' => $model->id_message));
                $this->redirect(array('sentEmail', 'id' => $model->id_message));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
/**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Message('search');
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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewThread($id) {
        $this->render('application.views.customerThread.view', array(
            'model' => $this->loadThreadModel($id),
        ));
    }

    /**
     * Lists all models.
     */
    public function actionThread() {
        $model = new CustomerThread('search');
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

        $this->render('application.views.customerThread.thread', array(
            'model' => $model,
            'pageSize' => $pageSize,
                )
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateThread() {
        $model = new Message;
        $model->id_user = Yii::app()->user->id;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Message'])) {
            $model->attributes = $_POST['Message'];
            //dump($model);exit();
            if ($model->save())
                $this->redirect(array('viewThread', 'id' => $model->id_message));
        }

        $this->render('application.views.customerThread.create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateThread($id) {
        $model = $this->loadThreadModel($id);

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerThread'])) {
            $model->attributes = $_POST['CustomerThread'];
            if ($model->save())
                $this->redirect(array('viewThread', 'id' => $model->id_customer_thread));
        }

        $this->render('application.views.customerThread.update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelThread($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadThreadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('thread'));
        } else
        {
           $this->loadThreadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('thread')); 
        }           
    }

    
    
 /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewDetail($id) {
        $model = $this->loadCusMessageModel($id);
        $thread = $this->loadThreadModel($model->id_customer_thread);

        $extmodel = new CustomerMessage('searchByThread');
        $extmodel->unsetAttributes();  // clear any default values
        $extmodel->id_customer_thread = $thread->id_customer_thread;
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($extmodel));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($extmodel)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($extmodel)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($extmodel) . '_page'])) {
            $newsPage = (int) $_GET[get_class($extmodel) . '_page'] - 1;
            Yii::app()->user->setState(get_class($extmodel) . '_page', $newsPage);
            unset($_GET[get_class($extmodel) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($extmodel) . '_page', 0);
        }

        $this->render('application.views.customerMessage.view', array(
            'thread' => $thread,
            'model' => $model,
            'extmodel' => $extmodel,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDetail($id) {
        $thread = $this->loadThreadModel($id);
        $model = new CustomerMessage('replyByAdmin');
        $model->id_user = Yii::app()->user->id;
        $model->isUser = true;
        $model->id_customer_thread = $thread->id_customer_thread;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerMessage'])) {
            $model->attributes = $_POST['CustomerMessage'];
            //dump($model);exit();
            if ($model->save())
                $this->redirect(array('viewDetail', 'id' => $model->getPrimaryKey()));
        }

        $this->render('application.views.customerMessage.create', array(
            'model' => $model,
        ));
    }
 /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionReplyDetail($id) {
        $parent = $this->loadCusMessageModel($id);
        $model = new CustomerMessage;
        $model->id_user = Yii::app()->user->id;
        $model->id_customer_thread = $parent->id_customer_thread;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerMessage'])) {
            $model->attributes = $_POST['CustomerMessage'];
            if ($model->save())
                $this->redirect(array('viewDetail', 'id' => $model->getPrimaryKey()));
        }

        $this->render('application.views.customerMessage.reply', array(
            'parent' => $parent,
            'model' => $model,
        ));
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateDetail($id) {
        $model = $this->loadCusMessageModel($id);
$model->scenario = 'replyByAdmin';
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['CustomerMessage'])) {
            $model->attributes = $_POST['CustomerMessage'];
            if ($model->save())
                $this->redirect(array('viewDetail', 'id' => $id));
        }

        $this->render('application.views.customerMessage.update', array(
            'model' => $model,
        ));
    }
    
 /**
     * Lists all models.
     */
    public function actionIndexDetail($id) {
        $thread = $this->loadThreadModel($id);
        $model = new CustomerMessage('searchByThread');
        $model->unsetAttributes();  // clear any default values
        $model->id_customer_thread = $thread->id_customer_thread;
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

        $this->render('application.views.customerMessage.index', array(
            'thread' => $thread,
            'model' => $model,
            'pageSize' => $pageSize,
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
            $this->loadCusMessageModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            //throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $this->redirect(array('viewDetail', 'id' =>$id));
    }

   
    
    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Message('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Message']))
            $model->attributes = $_GET['Message'];

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
        $model = Message::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadThreadModel($id) {
        $model = CustomerThread::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadCusMessageModel($id) {
        $model = CustomerMessage::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'thread-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-message-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSentEmail($id = null) {
        $model = $this->loadModel($id);
        if (($model !== null) && ($cus = Customer::model()->findByPk($model->id_customer))) {
            $user = User::model()->findByPk($model->id_user);
            $dcus = Detail::model()->findByAttributes(array('id_customer' => $cus->id_customer));
            $duser = Detail::model()->findByAttributes(array('id_user' => $user->id_user));
            $body = $model->message;
            try {
                $config = array(
                    'host' => Yii::app()->params["host"],
                    'auth' => Yii::app()->params["auth"],
                    'username' => Yii::app()->params["email"],
                    'password' => Yii::app()->params["password"],
                    'ssl' => Yii::app()->params["ssl"],
                    'port' => Yii::app()->params["port"]
                );
                //dump($config);exit();
                $transport = new Zend_Mail_Transport_Smtp(Yii::app()->params["host"], $config);
                Zend_Mail::setDefaultTransport($transport);
                Zend_Mail::setDefaultFrom(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail = new Zend_Mail('utf-8');
                $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
                $mail->setReplyTo(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail->setFrom(Yii::app()->params["email"], Yii::app()->params["name"]);
                //$mail->addCc(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail->addBcc(Yii::app()->params["email"], Yii::app()->params["name"]);

                $mail->addTo($cus->email, ($dcus !== null) ? $dcus->firstname . " " . $dcus->lastname : $cus->username );
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

                $mail->setSubject($model->title);
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
                Yii::app()->user->setFlash('success', '<strong>Thông tin đã được gửi thành công! </strong>');
                $this->redirect(array('message/message'));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
                $this->redirect(array('message/message'));
            }
        } else {
            Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong>');
            $this->redirect(array('user/chooseUserandRTO'));
        }
    }

}
