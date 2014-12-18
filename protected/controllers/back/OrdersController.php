<?php

class OrdersController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'viewDetail', 'updateDetail', 'invoice'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'deleteDetail'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionInvoice($id) {
        $model = $this->loadModel($id);
        $invoice = OrderInvoice::model()->findByAttributes(array('id_order' => $model->id_order));
        if ($invoice === null) {
            $invoice = new OrderInvoice;
        }
        $invoice->id_order = $model->id_order;
        $invoice->total_paid_tax_excl = $model->total_paid_tax_excl;
        $invoice->total_shipping_tax_excl = $model->total_shipping_tax_excl;
        $invoice->total_wrapping_tax_excl = $model->total_wrapping_tax_excl;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['OrderInvoice'])) {
            $invoice->attributes = $_POST['OrderInvoice'];
            if ($invoice->save())
                $this->redirect(array('invoice/view', 'id' => $invoice->id_order_invoice));
        }
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
        $this->render('invoice', array(
            'invoice' => $invoice,
            'model' => $model,
            'detail' => $detail,
            'pageSize' => $pageSize,
        ));
    }

    public function actionViewDetail($id) {
        $model = OrderDetail::model()->findByPk($id);
        $detail = new OrderDetail('searchByOrder');
        $detail->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
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

        $order = Orders::model()->findByPk($model->id_order);
        $this->render('viewdetail', array(
            'model' => $model,
            'order' => $order,
            'detail' => $detail,
            'pageSize' => $pageSize,
        ));
    }

    public function actionUpdateDetail($id) {
        $model = OrderDetail::model()->findByPk($id);

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['OrderDetail'])) {
            $model->attributes = $_POST['OrderDetail'];
            if ($model->save()) {
                $this->redirect(array('viewdetail', 'id' => $model->id_order_detail));
            }
        }
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
        $order = Orders::model()->findByPk($model->id_order);
        $this->render('updatedetail', array(
            'model' => $model,
            'order' => $order,
            'detail' => $detail,
            'pageSize' => $pageSize,
        ));
    }

    public function actionDeleteDetail($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $model = OrderDetail::model()->findByPk($id);
            //$model->delete();
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Yêu cầu này hiện thời không được phép. Bạn vui lòng đừng lặp lại nó một lần nữa.');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
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
        $model = new Orders;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_order));
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

        if (isset($_POST['Orders'])) {
            $model->attributes = $_POST['Orders'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_order));
        }
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
        $this->render('update', array(
            'model' => $model,
            'detail' => $detail,
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
            $model = $this->loadModel($id);
            if ($model->current_state <= 4) {
                $model->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
            else {
                throw new CHttpException(400, 'Yêu cầu này hiện thời không được phép. Bạn vui lòng đừng lặp lại nó một lần nữa.');
            }
        } else {
            $model = $this->loadModel($id);
            if ($model->current_state <= 4) {
                $model->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
            else {
                throw new CHttpException(400, 'Yêu cầu này hiện thời không được phép. Bạn vui lòng đừng lặp lại nó một lần nữa.');
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $order = new Orders('search');
        $order->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($order));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($order)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($order)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET[get_class($order) . '_page'])) {
            $newsPage = (int) $_GET[get_class($order) . '_page'] - 1;
            Yii::app()->user->setState(get_class($order) . '_page', $newsPage);
            unset($_GET[get_class($order) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($order) . '_page', 0);
        }

        $cart = new Cart('search');
        $cart->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($cart));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($cart)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($cart)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET[get_class($cart) . '_page'])) {
            $newsPage = (int) $_GET[get_class($cart) . '_page'] - 1;
            Yii::app()->user->setState(get_class($cart) . '_page', $newsPage);
            unset($_GET[get_class($cart) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($cart) . '_page', 0);
        }

        $this->render('index', array(
            'order' => $order,
            'cart' => $cart,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Orders('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'orders-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-invoice-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
