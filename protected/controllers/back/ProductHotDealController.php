<?php

class ProductHotDealController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'updateProductAttributes', 'addProductAttribute'),
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

    public function actionUpdateProductAttributes() {
        $id_product = Yii::app()->getRequest()->getParam('id_product', "0");
        $product = Product::model()->findByPk($id_product);
        $dropDown = "<option value=''>Chọn Sản Phẩm</option>";
        if (($id_product != "0") && ($product != null) && isset($product->productAttributes) && (count($product->productAttributes) > 0)) {
            $data = CHtml::listData($product->productAttributes, 'id_product_attribute', 'fullname');
            foreach ($data as $value => $name)
                $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        } else
            $data = array();
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    public function actionAddProductAttribute() {
        $product = Product::model()->findByPk(Yii::app()->getRequest()->getParam('id_product', null));
        $productattribute = ProductAttribute::model()->findByPk(Yii::app()->getRequest()->getParam('id_product_attribute', null));
        $hotdeal = HotDeal::model()->findByPk(Yii::app()->getRequest()->getParam('id_hot_deal', null));
        $rule = HotDeal::model()->findByPk(Yii::app()->getRequest()->getParam('id_specific_price_rule', null));
        if (isset($product, $productattribute, $hotdeal)) {
            if (isset($rule)) {
                $model = ProductHotDeal::model()->findByAttributes(
                        array(
                            'id_product' => $product->id_product,
                            'id_product_attribute' => $productattribute->id_product_attribute,
                            'id_hot_deal' => $hotdeal->id_hot_deal,
                            'id_specific_price_rule' => $rule->id_specific_price_rule
                        )
                );
            } else {
                $model = ProductHotDeal::model()->findByAttributes(
                        array(
                            'id_product' => $product->id_product,
                            'id_product_attribute' => $productattribute->id_product_attribute,
                            'id_hot_deal' => $hotdeal->id_hot_deal
                        )
                );
            }

            if ($model == null) {
                $model = new ProductHotDeal;
                $model->id_product = $product->id_product;
                $model->id_product_attribute = $productattribute->id_product_attribute;
                $model->id_hot_deal = $hotdeal->id_hot_deal;
                $model->id_specific_price_rule = ($rule == null) ? null : $rule->id_specific_price_rule;
            }
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductHotDeal'])) {
            $model->attributes = $_POST['ProductHotDeal'];
            if ($model->updateRule()){
                if(!$model->getPrimaryKey()) {
                    $model = ProductHotDeal::model()->findByAttributes(
                        array(
                            'id_product' => $model->id_product,
                            'id_product_attribute' => $model->id_product_attribute,
                            'id_hot_deal' => $model->id_hot_deal,
                            'id_specific_price_rule' => $model->id_specific_price_rule
                        )
                );
                }
                $this->redirect(array('view', 'id' => $model->getPrimaryKey()));
            }                
            else {
                dump($model);
                exit();
            }
        }

        $this->render('update', array(
            'model' => $model,
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProductHotDeal;
        
        $criteria = new CDbCriteria();
        $today = new DateTime('now');
        $current = $today->format('Y-m-d H:i:s');
        $criteria->condition = "t.to>=:to_day";
        $criteria->params = array(":to_day" => $current);
        $criteria->order = 'name, reduction_type, price ASC';
        $record = SpecificPriceRule::model()->find($criteria);
        if($record==null){
            Yii::app()->user->setFlash('error', 'Cần phải tạo <strong>Luật Giảm giá cho Sản phẩm Trước! </strong>');
            $this->redirect(array('specificPriceRule/create'));
        }
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductHotDeal'])) {
            $model->attributes = $_POST['ProductHotDeal'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_product_hot_deal));
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
        $pro = Product::model()->findByPk($model->id_product);
        $pro_att = ProductAttribute::model()->findByPk($model->id_product_attribute);
        $model->price = $pro_att->price;
        
        $criteria = new CDbCriteria();
    $today = new DateTime('now');
    $current = $today->format('Y-m-d H:i:s');
    $criteria->condition = "t.to>=:to_day";
    $criteria->params = array(":to_day" => $current);
    $criteria->order = 'name, reduction_type, price ASC';
    $record = SpecificPriceRule::model()->find($criteria);
    if($record==null){
        Yii::app()->user->setFlash('error', 'Cần phải tạo <strong>Luật Giảm giá cho Sản phẩm Trước! Bởi vì qui luật cũ đã quá hạn áp dụng</strong>');
        $this->redirect(array('specificPriceRule/create'));
    }
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['ProductHotDeal'])) {
            $model->attributes = $_POST['ProductHotDeal'];
            if ($model->updateRule())
                $this->redirect(array('view', 'id' => $model->id_product_hot_deal));           
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
        $id = Yii::app()->getRequest()->getParam('id', null);
        $id_hot_deal = Yii::app()->getRequest()->getParam('id_hot_deal', null);
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request  
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('hotDeal/view','id'=>$id_hot_deal));
        } 
        else 
        {
            $this->loadModel($id)->delete();
             //throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            $this->redirect(array('hotDeal/view','id'=>$id_hot_deal));
        }
            
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new ProductHotDeal('search');
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
        $model = new ProductHotDeal('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductHotDeal']))
            $model->attributes = $_GET['ProductHotDeal'];

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
        $model = ProductHotDeal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-hot-deal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
