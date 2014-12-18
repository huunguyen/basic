<?php

class InvoiceController extends Controller {

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
                'actions' => array('index', 'view', 'pView', 'sentEmail', 'export'),
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
    public function actionExport($id) {
        $model = $this->loadModel($id);
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'exc') . DIRECTORY_SEPARATOR;
        $publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'exc' . DIRECTORY_SEPARATOR;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Nguyen Huu Nguyen")
                ->setLastModifiedBy("Nguyen Huu Nguyen")
                ->setTitle("QCDN - Nguyen Huu Nguyen")
                ->setSubject("Báo cáo tài chính")
                ->setDescription("Báo cáo tài chính. QCDN - Nguyen Huu Nguyen")
                ->setKeywords("office PHPExcel php")
                ->setCategory("QCDN");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                ->setSize(10);
        $iheader = 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Báo cáo tài chính. QCDN - Books');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Mã thanh toán')
                ->setCellValue('B2', 'Ngày tạo')
                ->setCellValue('C2', 'Phân loại')
                ->setCellValue('D2', 'Mô tả')
                ->setCellValue('E2', 'Ngày bắt đầu thanh toán')
                ->setCellValue('F2', 'Ngày kết thúc thanh toán')
                ->setCellValue('G2', 'Tổng số tiền')
                ->setCellValue('H2', 'Đơn vị tính')
                ->setCellValue('I2', 'Bằng chữ');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', $model->paymentkey)
                ->setCellValue('B3', $model->create_date)
                ->setCellValue('C3', $model->categories)
                ->setCellValue('D3', $model->description . $model->info)
                ->setCellValue('E3', $model->start_date_payment)
                ->setCellValue('F3', $model->end_date_payment)
                ->setCellValue('G3', $model->totalofmoney)
                ->setCellValue('H3', 'VND')
                ->setCellValue('I3', FinanceHelper::changeNumberToString($model->totalofmoney));
        $ifooter = 4;
        $dateTimeNow = time();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H' . $ifooter, 'Biên hòa, Ngày')
                ->setCellValue('I' . $ifooter, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
        $objPHPExcel->getActiveSheet()->getStyle('I' . $ifooter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
// Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $file = $path . $model->paymentkey . '.xlsx';
        if (is_file($file)) {
            unlink($file);
        }
        $objWriter->save($path . $model->paymentkey . '.xlsx');
        chmod($path . $model->paymentkey . '.xlsx', 0777);
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        $this->render('application.views.orderInvoice.export', array(
            'model' => $model,
            'file' => $model->paymentkey . '.xlsx'
        ));
    }
    
    public function actionSentEmail($id = null) {
        $model = $this->loadModel($id);
        $order = $this->loadOrderModel($model->id_order);
        if ( ($user = User::model()->findByPk(Yii::app()->user->getId())) && ($cus = Customer::model()->findByPk($order->id_customer)) ){
            $dcus = Detail::model()->findByAttributes(array('id_customer' => $cus->id_customer));
            $duser = Detail::model()->findByAttributes(array('id_user' => $user->id_user));
            
                 $detail = new OrderDetail('searchByOrder');
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

        $theOutput = $this->renderPartial('application.views.orderInvoice.view', array(
            'model' => $model,
            'order' => $order,
            'detail' => $detail,
            'pageSize' => $pageSize,
        ),true);  
            $body = $theOutput;
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

                $mail->setSubject("Thông tin hóa đơn mua hàng [$cus->email]");
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
                Yii::app()->user->setFlash('success', '<strong>Thông tin đã được gửi thành công! </strong>');
                $this->redirect(array('invoice/index'));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
                $this->redirect(array('invoice/index'));
            }
        } else {
            Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong>');
            $this->redirect(array('user/chooseUserandRTO'));
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $order = $this->loadOrderModel($model->id_order);

        $detail = new OrderDetail('searchByOrder');
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

        $this->render('application.views.orderInvoice.view', array(
            'model' => $model,
            'order' => $order,
            'detail' => $detail,
            'pageSize' => $pageSize,
        ));
    }
/**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionPView($id) {
        $model = $this->loadModel($id);
        $order = $this->loadOrderModel($model->id_order);

        $detail = new OrderDetail('searchByOrder');
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

        $this->renderPartial('application.views.orderInvoice.view', array(
            'model' => $model,
            'order' => $order,
            'detail' => $detail,
            'pageSize' => $pageSize,
        ),false,false);
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new OrderInvoice;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['OrderInvoice'])) {
            $model->attributes = $_POST['OrderInvoice'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_order_invoice));
        }

        $this->render('application.views.orderInvoice.create', array(
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

        if (isset($_POST['OrderInvoice'])) {
            $model->attributes = $_POST['OrderInvoice'];
            if ($model->save())
                $this->redirect(array('application.views.orderInvoice.view', 'id' => $model->id_order_invoice));
        }

        $this->render('application.views.orderInvoice.update', array(
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
        $model = new OrderInvoice('search');
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

        $this->render('application.views.orderInvoice.index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OrderInvoice('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OrderInvoice']))
            $model->attributes = $_GET['OrderInvoice'];

        $this->render('application.views.orderInvoice.admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = OrderInvoice::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadOrderModel($id) {
        $model = Orders::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-invoice-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
