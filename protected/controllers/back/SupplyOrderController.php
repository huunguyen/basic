<?php

class SupplyOrderController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'product', 'addProduct', 'loadAttributes', 'loadTax', 'viewDetail', 'updateDetail', 'deleteDetail'),
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

    public function actionViewDetail($id) {
        $detail = SupplyOrderDetail::model()->findByPk($id);
        if ($detail === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $this->render('viewDetail', array(
            'detail' => $detail,
            'model' => $detail->idSupplyOrder,
        ));
    }

    public function actionUpdateDetail($id) {
        $model = SupplyOrderDetail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');

        if (isset($_POST['SupplyOrderDetail'])) {
            $model->attributes = $_POST['SupplyOrderDetail'];
            if ($model->save())
                $this->redirect(array('supplyOrder/product', 'id' => $model->id_supply_order));
        }
        $this->render('updateDetail', array(
            'model' => $model,
        ));
    }

    public function actionDeleteDetail($id) {
        $model = SupplyOrderDetail::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        else
            $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('supplyOrder/product', 'id' => $model->id_supply_order));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        /*         * *************************************************************************************** */
        $pro_order = new SupplyOrderDetail('searchByOrder');
        $pro_order->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_order));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($pro_order)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($pro_order)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($pro_order) . '_page'])) {
            $newsPage = (int) $_GET[get_class($pro_order) . '_page'] - 1;
            Yii::app()->user->setState(get_class($pro_order) . '_page', $newsPage);
            unset($_GET[get_class($pro_order) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($pro_order) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'pro_order' => $pro_order,
            'pageSize' => $pageSize,
        ));
    }

    public function actionAddProduct() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_supply_order = Yii::app()->getRequest()->getParam('id_supply_order', null);
            if (!isset($id_supply_order) || !($order = SupplyOrder::model()->findByPk($id_supply_order))) {
                throw new CHttpException(400, 'Invalid request because id_supply_order is null. Please do not repeat this request again.');
            }
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            if (isset($id_product) && ($product = Product::model()->findByPk($id_product))) {
                $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
                if (isset($id_product_attribute) && ($product_attribute = ProductAttribute::model()->findByPk($id_product_attribute))) {
                    // add product attribute to supply order detail
                    $model = SupplyOrderDetail::model()->findByAttributes(array('id_supply_order' => $order->id_supply_order, 'id_product' => $product->id_product, 'id_product_attribute' => $product_attribute->id_product_attribute));
                    if ($model == null) {
                        $model = new SupplyOrderDetail;
                        $model->id_supply_order = $order->id_supply_order;
                        $model->id_product = $product->id_product;
                        $model->id_product_attribute = $product_attribute->id_product_attribute;
                        $model->save();
                    } else
                        throw new CHttpException(400, 'Invalid request because SupplyOrderDetail exist. Please do not repeat this request again.');
                }
                elseif (isset($product->productAttributes) && (count($product->productAttributes) > 0)) {
                    foreach ($product->productAttributes as $product_attribute) {
                        // add product attribute to supply order detail
                        // add product attribute to supply order detail
                        $model = SupplyOrderDetail::model()->findByAttributes(array('id_supply_order' => $order->id_supply_order, 'id_product' => $product->id_product, 'id_product_attribute' => $product_attribute->id_product_attribute));
                        if ($model == null) {
                            $model = new SupplyOrderDetail;
                            $model->id_supply_order = $order->id_supply_order;
                            $model->id_product = $product->id_product;
                            $model->id_product_attribute = $product_attribute->id_product_attribute;
                            $model->save();
                        }
                    }
                }
            } else {
                $products = Yii::app()->getRequest()->getParam('p_autoId', null);
                if (empty($products)) {
                    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again. Du lieu bi loi [' . $warehouses . $product_attributes . ']');
                } else {
                    foreach ($products as $id_product) {
                        if ($product = Product::model()->findByPk($id_product)) {
                            if (isset($product->productAttributes) && (count($product->productAttributes) > 0)) {
                                foreach ($product->productAttributes as $product_attribute) {
                                    $model = SupplyOrderDetail::model()->findByAttributes(array('id_supply_order' => $order->id_supply_order, 'id_product' => $product->id_product, 'id_product_attribute' => $product_attribute->id_product_attribute));
                                    if ($model == null) {
                                        $model = new SupplyOrderDetail;
                                        $model->id_supply_order = $order->id_supply_order;
                                        $model->id_product = $product->id_product;
                                        $model->id_product_attribute = $product_attribute->id_product_attribute;
                                        $model->save();
                                    }
                                }
                            }
                        } else
                            continue;
                    }
                }
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('supplyOrder/product', 'id' => $id_supply_order));
        } else
            {           
                $id_supply_order = Yii::app()->getRequest()->getParam('id_supply_order', null);
                $id_product = Yii::app()->getRequest()->getParam('id_product', null);
                $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
                $model = SupplyOrderDetail::model()->findByAttributes(array('id_supply_order' => $id_supply_order, 'id_product' => $id_product, 'id_product_attribute' => $id_product_attribute));
                if ($model == null) {
                    $model = new SupplyOrderDetail;
                    $model->id_supply_order = $id_supply_order;
                    $model->id_product = $id_product;
                    $model->id_product_attribute = $id_product_attribute;
                    $model->save();
                }
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('supplyOrder/product', 'id' => $id_supply_order));            
        }
            
    }
    
public function actionLoadTax() {
    header('Vary: Accept');
    if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
        header('Content-type: application/json');
    } else {
        header('Content-type: text/plain');
    }
    if (Yii::app()->request->isAjaxRequest) {
        $id_supply_order_detail = Yii::app()->getRequest()->getParam('id_supply_order_detail', null);
        $model = SupplyOrderDetail::model()->findByPk($id_supply_order_detail);
        $product = Product::model()->findByPk($model->id_product);
        $data = array();
        $flag = false;
        if ($product!=null) {
            $flag = true;
            $data['tax'] = $product->idTax->rate;
        }
        $data['flag'] = $flag;
        echo CJSON::encode($data);
    }
    else {
            header('Content-type: text/plain');
            //redirect to home page
            Yii::app()->user->setFlash('error', '<strong>Fail!</strong> Error access.');
            throw new Exception('Error access');
            $this->redirect(array('site/index'));
        }    
}
    public function actionLoadAttributes() {
        $id_supply_order = Yii::app()->getRequest()->getParam('id_supply_order', null);
        $model = SupplyOrder::model()->findByPk($id_supply_order);
        $id_product = Yii::app()->getRequest()->getParam('id_product', null);
        if (isset($id_product) && ($product = Product::model()->findByPk($id_product))) {
            if (isset($product->productAttributes) && (count($product->productAttributes) > 0)) {
                $pro_att = new ProductAttribute('searchByProduct');
                $pro_att->unsetAttributes();  // clear any default values
                // This portion of code is belongs to Page size dropdown.
                $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_att));
                $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($pro_att)) . 'PageSize', Yii::app()->params['defaultPageSize']);

                if (isset($_GET['pageSize'])) {
                    $pageSize = (int) $_GET['pageSize'];
                    Yii::app()->user->setState($uni_id . lcfirst(get_class($pro_att)) . 'PageSize', $pageSize);
                    unset($_GET['pageSize']);
                }

                if (isset($_GET[get_class($pro_att) . '_page'])) {
                    $newsPage = (int) $_GET[get_class($pro_att) . '_page'] - 1;
                    Yii::app()->user->setState(get_class($pro_att) . '_page', $newsPage);
                    unset($_GET[get_class($pro_att) . '_page']);
                } else if (isset($_GET['ajax'])) {
                    Yii::app()->user->setState(get_class($pro_att) . '_page', 0);
                }
                $pro_att->id_product = $pro_att->id_product;
            }
            /*             * *************************************************************************************** */
            $data = array();
            $data['model'] = $model;
            $data['product'] = $product;
            $data['pro_att'] = $pro_att;
            $data['pageSize'] = $pageSize;
            if (Yii::app()->request->getIsAjaxRequest()) {
                Yii::app()->clientScript->scriptMap['*.js'] = false;
                Yii::app()->clientScript->scriptMap['*.css'] = false;
                $this->renderPartial('_attributes', $data, false, true);
            }
            else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('supplyOrder/product', 'id' => $id_supply_order));            
            /*             * *************************************************************************************** */
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionProduct($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
        $product = new Product('searchBySupplier');
        $product->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($product));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($product)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($product)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($product) . '_page'])) {
            $newsPage = (int) $_GET[get_class($product) . '_page'] - 1;
            Yii::app()->user->setState(get_class($product) . '_page', $newsPage);
            unset($_GET[get_class($product) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($product) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $pro_order = new SupplyOrderDetail('searchByOrder');
        $pro_order->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_order));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($pro_order)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($pro_order)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($pro_order) . '_page'])) {
            $newsPage = (int) $_GET[get_class($pro_order) . '_page'] - 1;
            Yii::app()->user->setState(get_class($pro_order) . '_page', $newsPage);
            unset($_GET[get_class($pro_order) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($pro_order) . '_page', 0);
        }
        /*         * *************************************************************************************** */

        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['product'] = $product;
            $data['pro_order'] = $pro_order;
            $data['pageSize'] = $pageSize;
            $this->renderPartial('product', $data, false, true);
        } else {
            $this->render('product', array(
                'model' => $model,
                'product' => $product,
                'pro_order' => $pro_order,
                'pageSize' => $pageSize,
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SupplyOrder;
        $state = SupplyOrderState::model()->findByPk(1);
        if ($state == null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->id_supply_order_state = $state->id_supply_order_state;
// Uncomment the following line if AJAX validation is needed
$this->performAjaxValidation($model);

        if (isset($_POST['SupplyOrder'])) {
            $model->attributes = $_POST['SupplyOrder'];
            if ($model->save())
                $this->redirect(array('product', 'id' => $model->id_supply_order));            
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

        if (isset($_POST['SupplyOrder'])) {
            $model->attributes = $_POST['SupplyOrder'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_supply_order));
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
            throw new CHttpException(400, 'Chức năng này chưa hiện thực & Sẽ hiện thực sau! (^_^)');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new SupplyOrder('search');
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
        $model = new SupplyOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SupplyOrder']))
            $model->attributes = $_GET['SupplyOrder'];

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
        $model = SupplyOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'supply-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
