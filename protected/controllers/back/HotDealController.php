<?php

class HotDealController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'product', 'products', 'productAttribute', 'partUpdate'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionPartUpdate($id = null) {
        $model = ProductHotDeal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $this->renderPartial('_view', array('model' => $model));
        Yii::app()->end();
    }

    public function actionProducts() {
        if (Yii::app()->request->isPostRequest) {
            $ps = Yii::app()->getRequest()->getParam('p_autoId', null);
            $act = Yii::app()->getRequest()->getParam('act', "childs");
            if (isset($_POST['HotDeal'])) {
                $id = $_POST['HotDeal']['id_hot_deal'];
                $rule = $_POST['HotDeal']['rule'];
            } else {
                $id = Yii::app()->getRequest()->getParam('id', null);
                $rule = Yii::app()->getRequest()->getParam('HotDeal_rule', null);
            }
            $model = HotDeal::model()->findByPk($id);
            $rmodel = SpecificPriceRule::model()->findByPk($rule);

            foreach ($ps as $p) {
                $product = Product::model()->findByPk($p);
                if ((strcmp($act, "childs") == 0) && ($product != null) && ($rmodel != null) && ($model != null) && isset($product->productAttributes)) {
                    foreach ($product->productAttributes as $attribute) {
                        $phdmodel = ProductHotDeal::model()->findByAttributes(
                                array(
                                    'id_product_attribute' => $attribute->id_product_attribute,
                                    'id_product' => $product->id_product,
                                    'id_specific_price_rule' => $rmodel->id_specific_price_rule,
                                    'id_hot_deal' => $model->id_hot_deal
                                )
                        );
                        if ($phdmodel === null) {
                            $phdmodel = new ProductHotDeal;
                            $phdmodel->id_hot_deal = $model->id_hot_deal;
                            $phdmodel->id_product = $product->id_product;
                            $phdmodel->id_product_attribute = $attribute->id_product_attribute;
                            $phdmodel->id_specific_price_rule = $rmodel->id_specific_price_rule;
                            $phdmodel->updateRecord();
                        }
                    }
                } elseif (($product != null) && ($rmodel != null) && ($model != null)) {
                    $phdmodel = ProductHotDeal::model()->findByAttributes(
                            array(
                                'id_product' => $product->id_product,
                                'id_specific_price_rule' => $rmodel->id_specific_price_rule,
                                'id_hot_deal' => $model->id_hot_deal
                            )
                    );
                    if ($phdmodel === null) {
                        $phdmodel = new ProductHotDeal;
                        $phdmodel->id_hot_deal = $model->id_hot_deal;
                        $phdmodel->id_product = $product->id_product;
                        $phdmodel->id_specific_price_rule = $rmodel->id_specific_price_rule;
                        $phdmodel->updateRecord();
                    }
                }
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionProductAttribute() {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->getRequest()->getParam('id', null);
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
            $rule = Yii::app()->getRequest()->getParam('rule', null);

            $model = HotDeal::model()->findByPk($id);
            $pmodel = Product::model()->findByPk($id_product);
            $pamodel = ProductAttribute::model()->findByPk($id_product_attribute);
            $rmodel = SpecificPriceRule::model()->findByPk($rule);
            if (($model != null) && ($pmodel != null) && ($pamodel != null) && ($rmodel != null)) {
                $phdmodel = ProductHotDeal::model()->findByAttributes(
                        array(
                            'id_product' => $pmodel->id_product,
                            'id_product_attribute' => $pamodel->id_product_attribute,
                            'id_specific_price_rule' => $rmodel->id_specific_price_rule,
                            'id_hot_deal' => $model->id_hot_deal
                        )
                );
                if ($phdmodel === null) {
                    $phdmodel = new ProductHotDeal;
                    $phdmodel->id_hot_deal = $model->id_hot_deal;
                    $phdmodel->id_product = $pmodel->id_product;
                    $phdmodel->id_product_attribute = $pamodel->id_product_attribute;
                    $phdmodel->id_specific_price_rule = $rmodel->id_specific_price_rule;
                    $phdmodel->updateRecord();
                }
            } else
                throw new CHttpException(404, 'The requested page does not exist.');
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionProduct() {
        if (Yii::app()->request->isPostRequest) {
            $id = Yii::app()->getRequest()->getParam('id', null);
            $model = HotDeal::model()->findByPk($id);
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $product = Product::model()->findByPk($id_product);
            if (($model === null) || ($product === null))
                throw new CHttpException(404, 'The requested page does not exist.');
            /*             * *************************************************************************************** */
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
            /*             * *************************************************************************************** */
            $data = array();
            $data["model"] = $model;
            $data["product"] = $product;
            $data["pro_att"] = $pro_att;
            $data["pageSize"] = $pageSize;
            $this->renderPartial('_view', $data, false, false);
            Yii::app()->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        /*         * ******************************************************************* */
        $product = new Product('search');
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
        /*         * ******************************************************************* */
        $pro_hot_deal = new ProductHotDeal('searchByHotDeal');
        $pro_hot_deal->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_hot_deal));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($pro_hot_deal)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($pro_hot_deal)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($pro_hot_deal) . '_page'])) {
            $newsPage = (int) $_GET[get_class($pro_hot_deal) . '_page'] - 1;
            Yii::app()->user->setState(get_class($pro_hot_deal) . '_page', $newsPage);
            unset($_GET[get_class($pro_hot_deal) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($pro_hot_deal) . '_page', 0);
        }
        /*         * ******************************************************************* */
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'product' => $product,
            'pro_hot_deal' => $pro_hot_deal,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new HotDeal;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['HotDeal'])) {
            $model->attributes = $_POST['HotDeal'];
            //dump($model);exit();
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_hot_deal));
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

        if (isset($_POST['HotDeal'])) {
            $model->attributes = $_POST['HotDeal'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_hot_deal));
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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('hotDeal/index'));
        } else
            throw new CHttpException(400, 'Yêu cầu này không hợp lệ. Vui lòng đừng lập lại nó một lần nữa. Chức năng xóa chưa được hiện thực.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new HotDeal('search');
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

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new HotDeal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['HotDeal']))
            $model->attributes = $_GET['HotDeal'];

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
        $model = HotDeal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hot-deal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
