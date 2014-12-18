<?php

class ProductHotDealController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex() {
        $this->layout = "//layouts/content4";
        if(isset($_SERVER['HTTP_REFERER'])):
            $url=$_SERVER['HTTP_REFERER'];
        Yii::app()->request->cookies['url']= new CHttpCookie('url',$url);
        endif;
        $model1 = Configuration::model()->findByPk(7);
        $model2 = Configuration::model()->findByPk(8);
        $model3 = Configuration::model()->findByPk(9);
        $price = explode(',', $model2->value);
        
        $date = date('Y-m-d H:i:s');
        $criteria_spe = new CDbCriteria();
        $criteria_spe->with = array('productHotDeals', 'productHotDeals.idSpecificPriceRule');
        $criteria_spe->together = true;
        $criteria_spe->compare('id_product', 'productHotDeals.id_product');
        $criteria_spe->compare('productHotDeals.id_specific_price_rule', 'idSpecificPriceRule.id_specific_price_rule');
        $criteria_spe->condition = "idSpecificPriceRule.to>='$date' AND idSpecificPriceRule.from<='$date' AND active=1";
        if(isset($_GET['soft'])){
            $key= preg_replace("/[^a-zA-Z0-9-]/",'', $_GET['soft']);
            if($key==='desc'){
                $criteria_spe->order="productHotDeals.id_product_hot_deal desc";
            }if($key=="asc"){
                $criteria_spe->order="productHotDeals.id_product_hot_deal asc";
            }if($key=="product"){
                $criteria_spe->order="t.id_product desc";
            }if($key==='priceasc'){
                $criteria_spe->order="productHotDeals.price asc";
            }if ($key ==="pricedesc") {
                $criteria_spe->order = "productHotDeals.price desc";
            }if ($key ==7) {
                $criteria_spe->addCondition("productHotDeals.price>=$model1->value");
                $criteria_spe->order="productHotDeals.price asc";
            }
            if ($key ==8) {
                $criteria_spe->addCondition("productHotDeals.price BETWEEN $price[0] AND $price[1]");
                $criteria_spe->order="productHotDeals.price asc";
            } elseif ($key ==9) {
                $criteria_spe->addCondition("productHotDeals.price<=$model3->value");
                $criteria_spe->order="productHotDeals.price asc";
            }
        }
        $count = Product::model()->count($criteria_spe);
        $pages_hot = new CPagination($count);
        $pages_hot->pageSize = 32;
        $pages_hot->pageVar = "page_hotdeal";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages_hotdeal')) {
                    Yii::app()->user->setState('currentPages_hotdeal', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['page_hotdeal'])) {
            $currentPage = $_GET['page_hotdeal'] - 1;
            Yii::app()->user->setState('currentPages_hotdeal', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['page_hotdeal'])) {
            Yii::app()->user->setState('currentPages_hotdeal', 0);
        } else if (Yii::app()->user->hasState('currentPages_hotdeal')) {
            $pages_hot->setCurrentPage(Yii::app()->user->getState('currentPages_hotdeal'));
        }
        $pages_hot->applyLimit($criteria_spe);
        $products = Product::model()->findAll($criteria_spe);
        $this->render('index', array(
            'data_hot_deal' => $products,
            "pages" => isset($pages_hot) ? $pages_hot : null,
            'model1' => $model1,
            'model2' => $model2,
            'model3' => $model3,
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
     * @param integer $id the ID of the model to be loaded
     * @return ProductHotDeal the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductHotDeal::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductHotDeal $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-hot-deal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
