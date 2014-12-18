<?php

class SupplierController extends Controller {
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
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
        );
    }
    
    
    public function GetCategory($id){
        $cate=  Category::model()->findAll("id_parent=:id_parent",array(':id_parent'=>$id));
        $item=array();
        $item[]=$id;
        if($cate!=NULL){
            foreach ($cate as $value){
                $item[]=$this->demo($value->id_category);
            }
            return $item;
        }else{
        return $item;
        }
        
    }
    public function SetArray($id) {
        $data=$this->GetCategory($id);
        $array=array();
        foreach ($data as $value){
            if(is_array($value)){
                foreach ($value as $value0){
                    $array[]=$value0;
                }
            }else {
             $array[]=$value;   
            }
        }
        return $array;
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->layout = "//layouts/content7";
        if(isset($_SERVER['HTTP_REFERER'])):
            $url=$_SERVER['HTTP_REFERER'];
        Yii::app()->request->cookies['url']= new CHttpCookie('url',$url);
        endif;
        if (isset($_GET['cate_default'])) {
            $idcate = (int) $_GET['cate_default'];
            $array=  $this->SetArray($idcate);
            $str=  implode(',', $array);
            $criteria = new CDbCriteria();
            $criteria->addCondition("active=1 AND id_product in (SELECT id_product FROM tbl_product_supplier WHERE id_supplier=$id) AND id_product in (SELECT id_product FROM tbl_category_product WHERE id_category in ($str)) OR id_product in (SELECT id_product FROM tbl_product_supplier WHERE id_supplier=$id) AND id_category_default in ($str) AND active=1 OR id_category_default in ($str) AND active=1 AND id_supplier_default=$id");
            $model = Category::model()->findByPk($idcate);
            $item_count = Product::model()->count($criteria);
            $pages_cate = new CPagination($item_count);
            $pages_cate->pageSize = 16;
            $pages_cate->pageVar = "page_catesup";
            $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
            if (Yii::app()->user->hasState('currentAction')) {
                if ($currentAction != Yii::app()->user->getState('currentAction')) {

                    Yii::app()->user->setState('currentAction', $currentAction);
                    if (Yii::app()->user->hasState('currentPages_cate')) {
                        Yii::app()->user->setState('currentPages_cate', 0);
                    }
                }
            } else {
                Yii::app()->user->setState('currentAction', $currentAction);
            }
            if (Yii::app()->request->isAjaxRequest && isset($_GET['page_catesup'])) {
                $currentPage = $_GET['page_catesup'] - 1;
                Yii::app()->user->setState('currentPages_cate', $currentPage);
            }if (Yii::app()->request->isAjaxRequest && !isset($_GET['page_catesup'])) {
                Yii::app()->user->setState('currentPages_cate', 0);
            } else if (Yii::app()->user->hasState('currentPages_cate')) {
                $pages_cate->setCurrentPage(Yii::app()->user->getState('currentPages_cate'));
            }
            $pages_cate->applyLimit($criteria);
            $data_list = Product::model()->findAll($criteria);
            $this->render('view_cate', array(
                'model' => $model,
                'data_list' => $data_list,
                'pages' => $pages_cate,
            ));
        } else {
            $criteria_id = new CDbCriteria();
            $criteria_id->select = "id_product";
            $criteria_id->group = "id_product";
            $criteria_id->order = "COUNT(1) DESC";
            $criteria_id->limit = "100";
            $id_pro = Customization::model()->findAll($criteria_id);
            $item = array();
            foreach ($id_pro as $value) {
                $item[] = $value->id_product;
            }
            $str = implode(",", $item);
            if ($str != "") {
                $criteria = new CDbCriteria();
                $criteria->addCondition("active=1 AND id_product in ($str) AND id_product in (SELECT id_product FROM tbl_product_supplier WHERE id_supplier=$id)");
                $item_count = Product::model()->count($criteria);
                $pages = new CPagination($item_count);
                $pages->pageSize = 8;
                $pages->pageVar = "page_hotsup";
                $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
                if (Yii::app()->user->hasState('currentAction')) {
                    if ($currentAction != Yii::app()->user->getState('currentAction')) {

                        Yii::app()->user->setState('currentAction', $currentAction);
                        if (Yii::app()->user->hasState('currentPages')) {
                            Yii::app()->user->setState('currentPages', 0);
                        }
                    }
                } else {
                    Yii::app()->user->setState('currentAction', $currentAction);
                }
                if (Yii::app()->request->isAjaxRequest && isset($_GET['page_hotsup'])) {
                    $currentPage = $_GET['page_hotsup'] - 1;
                    Yii::app()->user->setState('currentPages', $currentPage);
                }if (Yii::app()->request->isAjaxRequest && !isset($_GET['page_hotsup'])) {
                    Yii::app()->user->setState('currentPages', 0);
                } else if (Yii::app()->user->hasState('currentPages')) {
                    $pages->setCurrentPage(Yii::app()->user->getState('currentPages'));
                }
                $pages->applyLimit($criteria);
                $data_hot = Product::model()->findAll($criteria);
            }


            $criteria1 = new CDbCriteria();
            $criteria1->addCondition("active=1 AND id_product in (SELECT id_product FROM tbl_product_supplier WHERE id_supplier=$id) OR id_supplier_default=$id AND active=1");
            $item_count = Product::model()->count($criteria1);
            $pagepro = new CPagination($item_count);
            $pagepro->pageSize = 16;
            $pagepro->pageVar = "page_sup";
            $currentAction_sup = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
            if (Yii::app()->user->hasState('currentAction')) {
                if ($currentAction_sup != Yii::app()->user->getState('currentAction')) {

                    Yii::app()->user->setState('currentAction', $currentAction_sup);
                    if (Yii::app()->user->hasState('currentPages_sup')) {
                        Yii::app()->user->setState('currentPages_sup', 0);
                    }
                }
            } else {
                Yii::app()->user->setState('currentAction', $currentAction_sup);
            }
            if (Yii::app()->request->isAjaxRequest && isset($_GET['page_sup'])) {
                $currentPage_sup = $_GET['page_sup'] - 1;
                Yii::app()->user->setState('currentPages_sup', $currentPage_sup);
            }if (Yii::app()->request->isAjaxRequest && !isset($_GET['page_sup'])) {
                Yii::app()->user->setState('currentPages_sup', 0);
            } else if (Yii::app()->user->hasState('currentPages_sup')) {
                $pagepro->setCurrentPage(Yii::app()->user->getState('currentPages_sup'));
            }
            $pagepro->applyLimit($criteria1);
            $product_list = Product::model()->findAll($criteria1);
            $this->render('view', array(
                'model' => $this->loadModel($id),
                'data' => $product_list,
                'pagepro' => $pagepro,
                'data_hot' => isset($data_hot) ? $data_hot : null,
                'pages' => isset($pages) ? $pages : null,
            ));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->layout = "//layouts/content6";
        if(isset($_SERVER['HTTP_REFERER'])):
            $url=$_SERVER['HTTP_REFERER'];
        Yii::app()->request->cookies['url']= new CHttpCookie('url',$url);
        endif;
        $criteria = new CDbCriteria();
        $criteria->condition = "t.active=1";
        $itemcount = Supplier::model()->count($criteria);
        $pages = new CPagination($itemcount);
        $pages->pageSize = 12;
        $pages->pageVar = "pageSup";
        $currentAction = Yii::app()->controller->id . "/" . Yii::app()->controller->action->id;
        if (Yii::app()->user->hasState('currentAction')) {
            if ($currentAction != Yii::app()->user->getState('currentAction')) {

                Yii::app()->user->setState('currentAction', $currentAction);
                if (Yii::app()->user->hasState('currentPages')) {
                    Yii::app()->user->setState('currentPages', 0);
                }
            }
        } else {
            Yii::app()->user->setState('currentAction', $currentAction);
        }
        if (Yii::app()->request->isAjaxRequest && isset($_GET['pageSup'])) {
            $currentPage = $_GET['pageSup'] - 1;
            Yii::app()->user->setState('currentPages', $currentPage);
        }if (Yii::app()->request->isAjaxRequest && !isset($_GET['pageSup'])) {
            Yii::app()->user->setState('currentPages', 0);
        } else if (Yii::app()->user->hasState('currentPages')) {
            $pages->setCurrentPage(Yii::app()->user->getState('currentPages'));
        }
        $pages->applyLimit($criteria);
        $dataProvider = Supplier::model()->findAll($criteria);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Supplier the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Supplier::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Supplier $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'supplier-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
