<?php

class StockController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'addStock', 'update', 'products', 'transfer', 'vProductOutStock', 'vProductInStock', 'updateProductAttributes'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'del'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionTransfer() {
        $id = Yii::app()->getRequest()->getParam('id', null);
        $stock = $this->loadModel($id);
        $model = new Stock('transfer');
        $model->unsetAttributes();  // clear any default values   
        $model->id_product = $stock->id_product;
        $model->id_product_attribute = $stock->id_product_attribute;
        $model->reference = $stock->reference;
        $model->physical_quantity = $stock->physical_quantity;
        $model->price_te = $stock->price_te;
        $model->transfer_stock = $stock;
        $model->scenario = "transfer";
        //dump($model);exit();
        /*         * *************************************************************************************** */
        if (isset($_POST['Stock'])) {
            $model->attributes = $_POST['Stock'];
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $model->id_product);
            $criteria->compare('id_product_attribute', $model->id_product_attribute);
            $criteria->compare('id_warehouse', $model->id_warehouse);
            $exist = Stock::model()->find($criteria);
            $remain_quantity = $stock->physical_quantity - $model->physical_quantity;
            $flag = false;
            if (($exist == null) && $model->save()) {                
                Stock::model()->updateByPk($stock->id_stock, array('physical_quantity' => $remain_quantity));
                $flag = true;
                //$this->redirect(array('view', 'id' => $model->id_stock));
            }
            elseif($exist != null) {
                $exist->scenario = "transfer";
                $exist->transfer_stock = $stock;
                $physical_quantity = $exist->physical_quantity + $model->physical_quantity;
                $exist->physical_quantity = $physical_quantity;     
                if($exist->save()){
                    Stock::model()->updateByPk($stock->id_stock, array('physical_quantity' => $remain_quantity));
                    $flag = true;
                    //$this->redirect(array('view', 'id' => $exist->id_stock));
                }
            }
            if($flag){
                $stock_inmvt = new StockMvt;
                $stock_outmvt = new StockMvt;
                $stock_inmvt->sign = $stock_outmvt->sign = 1;
                $stock_inmvt->physical_quantity = $stock_outmvt->physical_quantity = $model->physical_quantity;
                $stock_inmvt->price_te = $stock_outmvt->price_te = $model->price_te;
                $stock_inmvt->date_add = $stock_outmvt->date_add = date('Y-m-d H:i:s', time());

                $stock_outmvt->id_stock_mvt_reason = 2;
                $stock_inmvt->id_stock_mvt_reason = 3;

                $stock_outmvt->id_stock = ($exist == null)?$model->getPrimaryKey():$exist->getPrimaryKey();
                $stock_inmvt->id_stock = $stock->getPrimaryKey();
                
                if($stock_outmvt->save(false)&&$stock_inmvt->save(false)){
                    $this->redirect(($exist == null)?array('view', 'id' => $model->getPrimaryKey()):array('view', 'id' => $exist->getPrimaryKey()));
                }
            }            
        }
        $this->render('transfer', array(
            'model' => $model,
            'stock' => $stock
        ));
    }

    /* them product and product attribute to stock? chua viet hoan chinh */

    public function actionProducts() {
        /*         * *************************************************************************************** */
        $product1 = new Product('searchByInStock');
        $product1->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($product1));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($product1)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($product1)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($product1) . '_page'])) {
            $newsPage = (int) $_GET[get_class($product1) . '_page'] - 1;
            Yii::app()->user->setState(get_class($product1) . '_page', $newsPage);
            unset($_GET[get_class($product1) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($product1) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $product2 = new Product('searchByOutStock');
        $product2->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($product2));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($product2)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($product2)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($product2) . '_page'])) {
            $newsPage = (int) $_GET[get_class($product2) . '_page'] - 1;
            Yii::app()->user->setState(get_class($product2) . '_page', $newsPage);
            unset($_GET[get_class($product2) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($product2) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $this->render('product', array(
            'model' => $model,
            'pro_att' => $pro_att,
//            'pro_car' => $pro_car,
            'carrier' => $carrier,
            'pageSize' => $pageSize,
        ));
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
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionVProductOutStock($id) {
        $product = Product::model()->findByPk($id);

        $stock_ava = new StockAvailable;
        $stock_ava->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($stock_ava));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($stock_ava)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($stock_ava)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($stock_ava) . '_page'])) {
            $newsPage = (int) $_GET[get_class($stock_ava) . '_page'] - 1;
            Yii::app()->user->setState(get_class($stock_ava) . '_page', $newsPage);
            unset($_GET[get_class($stock_ava) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($stock_ava) . '_page', 0);
        }

        $this->render('outstock_attributes', array(
            'model' => $stock_ava,
            'product' => $product,
            'pageSize' => $pageSize
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionVProductInStock($id) {
        $product = Product::model()->findByPk($id);

        $stock = new Stock;
        $stock->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($stock));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($stock)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($stock)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($stock) . '_page'])) {
            $newsPage = (int) $_GET[get_class($stock) . '_page'] - 1;
            Yii::app()->user->setState(get_class($stock) . '_page', $newsPage);
            unset($_GET[get_class($stock) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($stock) . '_page', 0);
        }

        $this->render('instock_attributes', array(
            'model' => $stock,
            'product' => $product,
            'pageSize' => $pageSize
        ));
    }

    public function actionUpdateProductAttributes() {
        $id_product = Yii::app()->getRequest()->getParam('id_product', "0");
        $dropDown = "<option value=''>Chọn Chủng Loại Sản Phẩm</option>";
        if (($id_product != "0") && ($product = Product::model()->findByPk($id_product))) {
            $data = CHtml::listData(ProductAttribute::model()->findAll('id_product=:id_product', array(':id_product' => $product->id_product)), 'id_product_attribute', 'fullname');
            foreach ($data as $value => $name)
                $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionAddStock() {
        $model = new Stock('addquantity');
        $id = Yii::app()->getRequest()->getParam('id', null);
        if (($id != null) && ($stock = Stock::model()->findByPk($id))) {
            $model->id_product = $stock->id_product;
            $model->id_product_attribute = $stock->id_product_attribute;
            $model->id_warehouse = $stock->id_warehouse;
            $model->price_te = $stock->price_te;
        }
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Stock'])) {
            $model->attributes = $_POST['Stock'];
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $model->id_product);
            $criteria->compare('id_product_attribute', $model->id_product_attribute);
            $criteria->compare('id_warehouse', $model->id_warehouse);
            $exist = Stock::model()->find($criteria);
            $reason = StockMvtReason::model()->findByPk(1);
            if($reason===null) {
                $reason = new StockMvtReason;
                $reason->sign = 1;
                $reason->name = "Nhập Hàng Về Kho Hoặc Thêm Số Lượng";
                $reason->save(false);
            }
            $stock_mvt = new StockMvt;
            $stock_mvt->sign = 1;
            $stock_mvt->id_stock_mvt_reason = $reason->getPrimaryKey();
            if(!Yii::app()->user->isGuest){
                $stock_mvt->id_user = Yii::app()->user->id;
            }
            else $stock_mvt->id_user = null;
            if ($model->validate()) {
                $stock_mvt->date_add = date('Y-m-d H:i:s', time());
                $stock_mvt->physical_quantity = $model->physical_quantity;
                if ($exist == null) {
                    $model->save(false);                    
                    $stock_mvt->id_stock = $model->getPrimaryKey();
                    $stock_mvt->save(false);
                    $this->redirect(array('view', 'id' => $model->id_stock));
                } else {
                    $physical_quantity = $exist->physical_quantity + $model->physical_quantity;
                    Stock::model()->updateByPk($exist->id_stock, array('physical_quantity' => $physical_quantity));
                    $stock_mvt->id_stock = $exist->getPrimaryKey();
                    $stock_mvt->save(false);
                    $this->redirect(array('view', 'id' => $exist->id_stock));
                }                
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Stock;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Stock'])) {
            $model->attributes = $_POST['Stock'];
            $criteria = new CDbCriteria;
            $criteria->compare('id_product', $model->id_product);
            $criteria->compare('id_product_attribute', $model->id_product_attribute);
            $criteria->compare('id_warehouse', $model->id_warehouse);
            $exist = Stock::model()->find($criteria);
            $reason = StockMvtReason::model()->findByPk(1);
            if($reason===null) {
                $reason = new StockMvtReason;
                $reason->sign = 1;
                $reason->name = "Nhập Hàng Về Kho";
                $reason->save(false);
            }
            $stock_mvt = new StockMvt;
            $stock_mvt->sign = 1;
            $stock_mvt->id_stock_mvt_reason = $reason->getPrimaryKey();
            if(!Yii::app()->user->isGuest){
                $stock_mvt->id_user = Yii::app()->user->id;
            }
            else $stock_mvt->id_user = null;
            if ($model->validate()) {
                $stock_mvt->date_add = date('Y-m-d H:i:s', time());
                $stock_mvt->physical_quantity = $model->physical_quantity;
                if ($exist == null) {
                    $model->save(false);                    
                    $stock_mvt->id_stock = $model->getPrimaryKey();
                    $stock_mvt->save(false);
                    $this->redirect(array('view', 'id' => $model->id_stock));
                } else {
                    $physical_quantity = $exist->physical_quantity + $model->physical_quantity;
                    Stock::model()->updateByPk($exist->id_stock, array('physical_quantity' => $physical_quantity));
                    $stock_mvt->id_stock = $exist->getPrimaryKey();
                    $stock_mvt->save(false);
                    $this->redirect(array('view', 'id' => $exist->id_stock));
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
// $this->performAjaxValidation($model);

        if (isset($_POST['Stock'])) {
            $model->attributes = $_POST['Stock'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_stock));
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
            $model = $this->loadModel($id);
            $reason = StockMvtReason::model()->findByPk(5);
            if($reason===null) {
                $reason = new StockMvtReason;
                $reason->sign = 1;
                $reason->name = "Xóa Hàng Trong Kho";
                $reason->save(false);
            }
            $stock_mvt = new StockMvt;
            $stock_mvt->sign = 1;
            $stock_mvt->id_stock_mvt_reason = $reason->getPrimaryKey();
            if(!Yii::app()->user->isGuest){
                $stock_mvt->id_user = Yii::app()->user->id;
            }
            else $stock_mvt->id_user = null;
            $stock_mvt->date_add = date('Y-m-d H:i:s', time());
            $stock_mvt->physical_quantity = $model->physical_quantity;
            Stock::model()->updateByPk($exist->id_stock, array('physical_quantity' => 0));
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Chức năng này chưa hiện thực & Sẽ hiện thực sau! (^_^)');
    }
/**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDel($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            //$this->loadModel($id)->delete();
            /*
             * Xóa hàng trong kho:
             * Xóa đơn đặt hàng
             * Xóa hàng trong kho
             * Hàng Chuyển trong kho khác bị ảnh hưởng giải quyết như thế nào??????       
             */

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
        $stock = new Stock;
        $stock->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($stock));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($stock)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($stock)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($stock) . '_page'])) {
            $newsPage = (int) $_GET[get_class($stock) . '_page'] - 1;
            Yii::app()->user->setState(get_class($stock) . '_page', $newsPage);
            unset($_GET[get_class($stock) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($stock) . '_page', 0);
        }

        $stock_ava = new StockAvailable;
        $stock_ava->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($stock_ava));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($stock_ava)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($stock_ava)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($stock_ava) . '_page'])) {
            $newsPage = (int) $_GET[get_class($stock_ava) . '_page'] - 1;
            Yii::app()->user->setState(get_class($stock_ava) . '_page', $newsPage);
            unset($_GET[get_class($stock_ava) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($stock_ava) . '_page', 0);
        }
        $this->render('index', array(
            'stock' => $stock,
            'stock_ava' => $stock_ava,
            'pageSize' => $pageSize
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Stock('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Stock']))
            $model->attributes = $_GET['Stock'];

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
        $model = Stock::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Lỗi xảy ra vì không tìm thấy dữ liệu trong csdl');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'stock-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
