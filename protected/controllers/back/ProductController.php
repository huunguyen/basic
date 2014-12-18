<?php

class ProductController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'viewAttribute', 'createAttribute', 'updateAttribute', 'combinations', 'images', 'setCover', 'addImage', 'features', 'deleteFeature', 'carrier', 'addCarrier', 'deleteCarrier', 'supplier', 'addSupplier', 'deleteSupplier', 'warehouse', 'addWarehouse', 'deleteWarehouse', 'accessory', 'addAccessory', 'deleteAccessory', 'category', 'addCategory', 'deleteCategory', 'quantities', 'getAttributes', 'putAttributes', 'modifyAttributes'),
                'roles' => array('supper, admin, manager, staff'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'deleteAttribute', 'delImage'),
                'roles' => array('supper, admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionGetAttributes() {
        if ($id_attribute_group = Yii::app()->getRequest()->getParam('id_attribute_group', null)) {
            $data = CHtml::listData(Attribute::model()->findAll('id_attribute_group=:id_attribute_group', array(':id_attribute_group' => $id_attribute_group)), 'id_attribute', 'name');
        } else {
            $data = CHtml::listData(Attribute::model()->findAll(array('order' => 'id_attribute_group ASC')), 'id_attribute', 'name');
        }
        $dropDown = "<option value=''>Chọn Thuộc Tính</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    public function actionPutAttributes() {
        $model = new Attribute;
        $status = false;
        $id_product = Yii::app()->getRequest()->getParam('id_product', "");
        if (Yii::app()->user->hasState($id_product)) {
            $data = Yii::app()->user->getState($id_product);
        } else
            $data = array();

        $id_attribute = Yii::app()->getRequest()->getParam('id_attribute', null);
        if (isset($id_attribute)) {
            $model = Attribute::model()->findByPk($id_attribute);
            if (empty($data)) {
                $data[] = array("id_attribute" => $model->id_attribute, "name" => $model->name);
                $status = true;
            } else {
                if (isset($model)) {
                    $flag = false; /* true = tim thay false = tim khong thay */
                    foreach ($data as $row) {
                        if (($row["id_attribute"] == $model->id_attribute) & ($row["name"] == $model->name)) {
                            $flag = true;
                        }
                    }
                    if (!$flag) {
                        $data[] = array("id_attribute" => $model->id_attribute, "name" => $model->name);
                        $status = true;
                    }
                }
            }
            // luu lai session
            if (isset($model) && Yii::app()->user->hasState($id_product)) {
                Yii::app()->user->setState($id_product, $data);
            }
        }

        echo CJSON::encode(
                array('status' => $status,
                    'data' => $data
                )
        );
        Yii::app()->end();
    }

    public function actionModifyAttributes() {
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        if (Yii::app()->request->isAjaxRequest) {
            $model = new Attribute;
            $status = false;
            $uni_id = Yii::app()->user->getState('uni_id');
            if (Yii::app()->user->hasState($uni_id . '_attributeList')) {
                $data = Yii::app()->user->getState($uni_id . '_attributeList');
            } else
                $data = array();
            $id_attribute = Yii::app()->getRequest()->getParam('id_attribute', null);
            $_method = Yii::app()->getRequest()->getParam('_m', "add"); /* _method = add or remove */

            if (isset($id_attribute) && ($id_attribute != "")) {
                $model = Attribute::model()->findByPk($id_attribute);
                if (empty($data)) {
                    if ($_method == "add") {
                        $data[] = array("id_attribute" => $model->id_attribute, "name" => $model->name);
                    }
                    $status = true;
                } else {
                    if (isset($model)) {
                        $flag = false; /* true = tim thay false = tim khong thay */
                        $id_list = array();
                        if ($_method == "add") {
                            foreach ($data as $row) {
                                $id_list[] = $row["id_attribute"];
                            }
                            $criteria = new CDbCriteria;
                            $criteria->addInCondition('id_attribute', $id_list);
                            $criteria->compare('id_attribute_group', $model->id_attribute_group);
                            if (!$rs = Attribute::model()->find($criteria)) {
                                foreach ($data as $row) {
                                    if (($row["id_attribute"] == $model->id_attribute) & ($row["name"] == $model->name)) {
                                        $flag = true;
                                    }
                                }
                            } else {
                                $flag = true;
                            }
                        } else {
                            $tmp = array();
                            foreach ($data as $row) {
                                if (($row["id_attribute"] == $model->id_attribute) & ($row["name"] == $model->name)) {
                                    $flag = true;
                                } else
                                    $tmp[] = $row;
                            }
                            if ($_method == "rem") {
                                $data = $tmp;
                            }
                        }
                        /* true = tim thay false = tim khong thay */
                        if (!$flag) {
                            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
                            $rs = $this->checkexist($data, $model->id_attribute, $id_product);
                            if (($_method == "add") && !$rs) {
                                $data[] = array("id_attribute" => $model->id_attribute, "name" => $model->name);
                            }
                            $status = true;
                        }
                    }
                }
                // luu lai session
                Yii::app()->user->setState($uni_id . '_attributeList', $data);
            }
            $this->renderPartial('_addattribute', array("data" => $data), false, false);
            Yii::app()->end();
        } else {
            header('Content-type: text/plain');
            Yii::app()->user->setFlash('error', '<strong>Fail!</strong> Error access.');
            $this->redirect('index');
        }
    }

    /*
     * tim list ids in combine
     * hop le tra ve true
     * khong hop le tra ve false
     */

    public function checkexist($data = array(), $id_attribute = null, $id_product = null) {
        if (($id_attribute == null) || ($id_product == null)) {
            return false;
        }

        if (empty($data)) {
            $uni_id = Yii::app()->user->getState('uni_id');
            if (Yii::app()->user->hasState($uni_id . '_attributeList')) {
                $data = Yii::app()->user->getState($uni_id . '_attributeList');
            } else
                $data = array();
        }
        $sub = array();
        if (($attribute = Attribute::model()->findByPk($id_attribute)) && ($product = Product::model()->findByPk($id_product))) {
            $data[] = array("id_attribute" => $attribute->id_attribute, "name" => $attribute->name);
            foreach ($data as $value) {
                $sub[] = $value["id_attribute"];
            }
        } else {
            return false;
        }

        if (isset($product) && ($product != null)) {
            if (isset($product->productAttributes)) {
                $prolist = array(); // mang chua cac pro att. Moi phan tu tro toi mang attribute
                foreach ($product->productAttributes as $productattribute) {
                    if (isset($productattribute->tblProductAttributeCombinations)) {
                        $list = array();
                        foreach ($productattribute->tblProductAttributeCombinations as $value) {
                            $list[] = $value->id_attribute;
                        }
                        $prolist[$productattribute->id_product_attribute] = $list;
                    }
                }
                // tim $list co nam trong $prolist
                if (count($prolist) > 0) {
                    foreach ($prolist as $value) {
                        if (CommonHelper::isSameArray($value, $sub)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function actionViewAttribute($id) {
        $pro_att = ProductAttribute::model()->findByPk($id);
        if ($pro_att === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model = $this->loadModel($pro_att->id_product);


        $image = new Image('searchByProductAttributeId');
        $image->unsetAttributes();  // clear any default values
        $image->id_product_attribute = $pro_att->id_product_attribute;
        // This portion of code is belongs to Page size dropdown.
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($image));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($image)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($image)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET[get_class($image) . '_page'])) {
            $newsPage = (int) $_GET[get_class($image) . '_page'] - 1;
            Yii::app()->user->setState(get_class($image) . '_page', $newsPage);
            unset($_GET[get_class($image) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($image) . '_page', 0);
        }


        $this->render('vcombination', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'image' => $image,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateAttribute($id) {
        $model = $this->loadModel($id);
        $pro_att = new ProductAttribute;
        $pro_att->id_product = $model->id_product;
        $files = new XUploadForm;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($pro_att);

        if (isset($_POST['ProductAttribute'])) {
            $pro_att->attributes = $_POST['ProductAttribute'];
            $pro_att->_list = isset($_POST['_attribute']) ? $_POST['_attribute'] : $pro_att->_list;
            if ($pro_att->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($pro_att->save(false)) {   // modify existing line to pass in false param
                        $transaction->commit();

                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('product/index', 'id' => $model->id_product));
                        //$this->redirect(array('view', 'id' => $model->id_category));
                    } else {
                        throw new CException('Transaction failed: ');
                        Yii::app()->user->setFlash('error', 'đã được tạo <strong>Thất bại! </strong><br/>');
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            } else {
                Yii::app()->user->setFlash('error', 'Lỗi xảy ra do <strong>Các trường nhập chưa chính xác hoặc đã tồn tại trong hệ thống</strong><br/>');
            }
        }
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/attribute.js', CClientScript::POS_END);
        $this->render('ccombination', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'files' => $files
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateAttribute($id) {
        $pro_att = ProductAttribute::model()->findByPk($id);
        if ($pro_att === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model = $this->loadModel($pro_att->id_product);
        $files = new XUploadForm;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($pro_att);

        if (isset($_POST['ProductAttribute'])) {
            $pro_att->attributes = $_POST['ProductAttribute'];
            $pro_att->_list = isset($_POST['_attribute']) ? $_POST['_attribute'] : $pro_att->_list;
            if ($pro_att->validate()) {
                 //dump($pro_att);exit();
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($pro_att->save(false)) {   // modify existing line to pass in false param
                        $transaction->commit();

                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('product/index', 'id' => $model->id_product));
                        //$this->redirect(array('view', 'id' => $model->id_category));
                    } else {
                        throw new CException('Transaction failed: ');
                        Yii::app()->user->setFlash('error', 'đã được tạo <strong>Thất bại! </strong><br/>');
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', $e->getMessage());
                }
            } else {
                Yii::app()->user->setFlash('error', 'Lỗi xảy ra do <strong>Các trường nhập chưa chính xác hoặc đã tồn tại trong hệ thống</strong><br/>');
            }
        }
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/attribute.js', CClientScript::POS_END);
        $this->render('ucombination', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'files' => $files
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteAttribute($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            if ($pro_att = ProductAttribute::model()->findByPk($id)->delete()) {
                if (isset($pro_att->tblProductAttributeCombinations)) {
                    foreach ($pro_att->tblProductAttributeCombinations as $value) {
                        $value->delete();
                    }
                }
                $pro_att->delete();
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionCombinations($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
        $pro_att_com = new ProductAttributeCombination('searchByProduct');
        $pro_att_com->unsetAttributes();  // clear any default values
        // This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_att_com));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($pro_att_com)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($pro_att_com)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }
        if (isset($_GET[get_class($pro_att_com) . '_page'])) {
            $newsPage = (int) $_GET[get_class($pro_att_com) . '_page'] - 1;
            Yii::app()->user->setState(get_class($pro_att_com) . '_page', $newsPage);
            unset($_GET[get_class($pro_att_com) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($pro_att_com) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $this->render('combinations', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'pro_att_com' => $pro_att_com,
            'pageSize' => $pageSize,
        ));
    }

    public function actionAddImage() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id = Yii::app()->getRequest()->getParam('id', 0);
            $id_pa = Yii::app()->getRequest()->getParam('id_pa', 0);
            if ($model = ProductAttributeImage::model()->findByPk(array('id_image' => $id, 'id_product_attribute' => $id_pa))) {
                $model->cover = Yii::app()->getRequest()->getParam('cover', 0);
                $model->updateRecord();
            } else {
                $model = new ProductAttributeImage;
                $model->id_image = Yii::app()->getRequest()->getParam('id', 0);
                $model->id_product_attribute = Yii::app()->getRequest()->getParam('id_pa', 0);
                $model->cover = Yii::app()->getRequest()->getParam('cover', 0);
                $model->updateCover();
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionSetCover($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            if ($model = ProductAttributeImage::model()->findByPk(array('id_image' => Yii::app()->getRequest()->getParam('id', 0), 'id_product_attribute' => Yii::app()->getRequest()->getParam('id_pa', 0)))) {
                $model->cover = Yii::app()->getRequest()->getParam('cover', 0);
                $model->updateCover();
            } elseif ($model = Image::model()->findByPk($id)) {
                $model->cover = Yii::app()->getRequest()->getParam('cover', 0);
                $model->updateCover();
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('images'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
public function actionDelImage($id) {
     if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            if ($model = ProductAttributeImage::model()->findByPk(array('id_image' => Yii::app()->getRequest()->getParam('id', 0), 'id_product_attribute' => Yii::app()->getRequest()->getParam('id_pa', 0)))) {
                if(!$model->cover) $model->delete();
            } elseif ($model = Image::model()->findByPk($id)) {
                if(!$model->cover) $model->delete();
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('images'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
}

    public function actionImages($id) {
        $product = $this->loadModel($id);
        $model = new Image('searchByProductId');
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

        $this->render('images', array(
            'product' => $product,
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    public function getFeatureProductsToUpdate() {
        // Create an empty list of records
        $items = array();
        $id_product = Yii::app()->getRequest()->getParam('id', null);
        if ($id_product == null)
            return $items;
        $features = Feature::model()->findAll();

        // Iterate over each item from the submitted form
        if (isset($_POST['FeatureValue']) && is_array($_POST['FeatureValue'])) {
            foreach ($_POST['FeatureValue'] as $i => $item) {
                // If item id is available, read the record from database 
                if (array_key_exists('id_feature_value', $item) && (Trim($item['id_feature_value']) != '') && ($fea_val = FeatureValue::model()->findByPk($item['id_feature_value']))) {
                    $fea_pro = FeatureProduct::model()->findByAttributes(
                            array('id_feature' => $fea_val->id_feature,
                                'id_product' => $id_product)
                    );
                    if ($fea_pro == null) {
                        $fea_pro = new FeatureProduct;
                        $fea_pro->id_product = $id_product;
                        $fea_pro->id_feature = $fea_val->id_feature;
                        $fea_pro->id_feature_value = $fea_val->id_feature_value;
                    } else
                        $fea_pro->id_feature_value = $fea_val->id_feature_value;
                    $items[] = $fea_pro;
                }
                // Otherwise create a new record
                elseif (array_key_exists('newvalue', $item) && (Trim($item['newvalue']) != '')) {
                    $value = FeatureValue::model()->findByAttributes(
                            array('id_feature' => $features[$i]->id_feature,
                                'value' => $item['newvalue'])
                    );
                    if ($value == null) {
                        $value = new FeatureValue();
                        $value->value = $item['newvalue'];
                        $value->id_feature = $features[$i]->id_feature;
                        $value->save(false);
                    }
                    $fea_pro = new FeatureProduct;
                    $fea_pro->id_product = $id_product;
                    $fea_pro->id_feature = $value->id_feature;
                    $fea_pro->id_feature_value = $value->id_feature_value;
                    $items[] = $fea_pro;
                }
                // final del old record
                else {
                    if (array_key_exists('id_feature_value', $item) && array_key_exists('newvalue', $item) && (Trim($item['id_feature_value']) == '') && (Trim($item['newvalue']) == '')) {
                        $fea_pro = FeatureProduct::model()->findByAttributes(
                                array('id_feature' => $features[$i]->id_feature,
                                    'id_product' => $id_product)
                        );
                        if ($fea_pro != null)
                            $fea_pro->delete();
                    }
                }
            }
        }
        return $items;
    }

    public function actionFeatures($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
        $fea_pro = new FeatureProduct('searchByProduct');
        $fea_pro->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($fea_pro));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($fea_pro)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($fea_pro)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($fea_pro) . '_page'])) {
            $newsPage = (int) $_GET[get_class($fea_pro) . '_page'] - 1;
            Yii::app()->user->setState(get_class($fea_pro) . '_page', $newsPage);
            unset($_GET[get_class($fea_pro) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($fea_pro) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $features = Feature::model()->findAll();
        $list = array();
        foreach ($features as $value) {
            $m_feapro = FeatureProduct::model()->findByAttributes(
                    array('id_feature' => $value->id_feature,
                        'id_product' => $model->id_product)
            );
            if (($m_feapro !== null) && isset($m_feapro->idFeatureValue))
                $list[] = $m_feapro->idFeatureValue;
            else {
                $feaval = new FeatureValue;
                $feaval->id_feature = $value->id_feature;
                $list[] = $feaval;
            }
        }
        if (isset($_POST['FeatureValue'])) {
            $items = $this->getFeatureProductsToUpdate();

            $valid = true;
            foreach ($items as $item)
                $valid = $item->validate() && $valid;

            if ($valid) {
                foreach ($items as $i => $item) {
                    $items[$i] = $item->updateRecord();
                }
                Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                $this->redirect(array('product/index', 'id' => $model->id_product));
            } else
                $list = $items;
        }
        $this->render('features', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'fea_pro' => $fea_pro,
            'features' => $features,
            'list' => $list,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteFeature() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_feature = Yii::app()->getRequest()->getParam('id_feature', null);
            if ($fea_pro = FeatureProduct::model()->findByPk(array('id_product' => $id_product, 'id_feature' => $id_feature))) {
                $fea_pro->delete();
                Yii::app()->user->setFlash('success', 'đã xóa <strong>Thành công! </strong>');
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /*
     * http://www.yiiframework.com/wiki/278/cgridview-render-customized-complex-datacolumns/
     * http://www.yiiframework.com/forum/index.php/topic/27401-additional-columns-for-cgridview-with-data-provider/
     */

    public function getStringFromZones($data) {
        $rs = '';
        foreach ($data->tblZones as $zone) {
            if (isset($zone) && !empty($zone)) {
                $city = City::model()->findByPk($zone->id_city);
                $rs .= '[<b>' . $zone->name . '</b>(' . $zone->idCity->iso_code . ')] ';
            }
        }
        return $rs;
    }

    public function actionAddCarrier() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_carrier = Yii::app()->getRequest()->getParam('id_carrier', null);
            if (isset($id_product, $id_carrier)) {
                $model = ProductCarrier::model()->findByPk(array('id_carrier' => $id_carrier, 'id_product' => $id_product));
                if ($model === null) {
                    $model = new ProductCarrier;
                    $model->id_carrier = $id_carrier;
                    $model->id_product = $id_product;
                    $model->updateRecord();
                }
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteCarrier() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_carrier = Yii::app()->getRequest()->getParam('id_carrier', null);
            if ($pro_car = ProductCarrier::model()->findByPk(array('id_carrier' => $id_carrier, 'id_product' => $id_product))) {
                $pro_car->delete();
                Yii::app()->user->setFlash('success', 'đã xóa <strong>Thành công! </strong>');
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionCarrier($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
//        $pro_car = new ProductCarrier('searchByProduct');
//        $pro_car->unsetAttributes();  // clear any default values
//        $pro_car->id_product = $model->id_product;
//// This portion of code is belongs to Page size dropdown.
//        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($pro_car));
//        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($pro_car)) . 'PageSize', Yii::app()->params['defaultPageSize']);
//
//        if (isset($_GET['pageSize'])) {
//            $pageSize = (int) $_GET['pageSize'];
//            Yii::app()->user->setState($uni_id . lcfirst(get_class($pro_car)) . 'PageSize', $pageSize);
//            unset($_GET['pageSize']);
//        }
//
//        if (isset($_GET[get_class($pro_car) . '_page'])) {
//            $newsPage = (int) $_GET[get_class($pro_car) . '_page'] - 1;
//            Yii::app()->user->setState(get_class($pro_car) . '_page', $newsPage);
//            unset($_GET[get_class($pro_car) . '_page']);
//        } else if (isset($_GET['ajax'])) {
//            Yii::app()->user->setState(get_class($pro_car) . '_page', 0);
//        }
        /*         * *************************************************************************************** */
        $carrier = new Carrier('searchByNoProduct');
        $carrier->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($carrier));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($carrier)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($carrier)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($carrier) . '_page'])) {
            $newsPage = (int) $_GET[get_class($carrier) . '_page'] - 1;
            Yii::app()->user->setState(get_class($carrier) . '_page', $newsPage);
            unset($_GET[get_class($carrier) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($carrier) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        $this->render('carrier', array(
            'model' => $model,
            'pro_att' => $pro_att,
//            'pro_car' => $pro_car,
            'carrier' => $carrier,
            'pageSize' => $pageSize,
        ));
    }

    public function actionAddSupplier() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_supplier = Yii::app()->getRequest()->getParam('id_supplier', null);
            $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
            if (!isset($id_product_attribute) && isset($id_product, $id_supplier) && ($product = Product::model()->findByPk($id_product)) && ($supplier = Supplier::model()->findByPk($id_supplier))) {
                if ($models = ProductAttribute::model()->findAllByAttributes(array('id_product' => $id_product))) {
                    foreach ($models as $productattribute) {
                        $model = new ProductSupplier;
                        $model->id_supplier = $supplier->id_supplier;
                        $model->id_product = $productattribute->id_product;
                        $model->id_product_attribute = $productattribute->id_product_attribute;
                        $model->updateRecord();
                    }
                }
            } elseif (isset($id_product, $id_supplier, $id_product_attribute) && ($product = Product::model()->findByPk($id_product)) && ($supplier = Supplier::model()->findByPk($id_supplier)) && ($attribute = ProductAttribute::model()->findByPk($id_product_attribute))) {
                $model = ProductSupplier::model()->findByAttributes(array('id_product' => $id_product, 'id_supplier' => $id_supplier, 'id_product_attribute' => $id_product_attribute));
                if (empty($model)) {
                    $model = new ProductSupplier;
                    $model->id_supplier = $id_supplier;
                    $model->id_product = $id_product;
                    $model->id_product_attribute = $attribute->id_product_attribute;
                    $model->updateRecord();
                }
            } else {
                $suppliers = Yii::app()->getRequest()->getParam('sg_autoId', null);
                $product_attributes = Yii::app()->getRequest()->getParam('pag_autoId', null);
                if (empty($suppliers) || empty($product_attributes)) {
                    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again. Du lieu bi loi [' . $suppliers . $product_attributes . ']');
                } else {
                    foreach ($product_attributes as $product_attribute) {
                        foreach ($suppliers as $j => $supplier) {
                            $model = ProductSupplier::model()->findByAttributes(
                                    array('id_product' => $id_product,
                                        'id_supplier' => $supplier,
                                        'id_product_attribute' => $product_attribute
                                    )
                            );
                            if (empty($model)) {
                                $model = new ProductSupplier;
                                $model->id_supplier = $supplier;
                                $model->id_product = $id_product;
                                $model->id_product_attribute = $product_attribute;
                                $model->updateRecord();
                            }
                        }
                    }
                    /*                     * ***************************************************************************** */
                    $model = $this->loadModel($id_product);
                    /*                     * *************************************************************************************** */
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
                    /*                     * *************************************************************************************** */
                    $supplier = new Supplier('searchByNoProduct');
                    $supplier->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
                    $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($supplier));
                    $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($supplier)) . 'PageSize', Yii::app()->params['defaultPageSize']);

                    if (isset($_GET['pageSize'])) {
                        $pageSize = (int) $_GET['pageSize'];
                        Yii::app()->user->setState($uni_id . lcfirst(get_class($supplier)) . 'PageSize', $pageSize);
                        unset($_GET['pageSize']);
                    }

                    if (isset($_GET[get_class($supplier) . '_page'])) {
                        $newsPage = (int) $_GET[get_class($supplier) . '_page'] - 1;
                        Yii::app()->user->setState(get_class($supplier) . '_page', $newsPage);
                        unset($_GET[get_class($supplier) . '_page']);
                    } else if (isset($_GET['ajax'])) {
                        Yii::app()->user->setState(get_class($supplier) . '_page', 0);
                    }
                    /*                     * *************************************************************************************** */
                    $data = array();
                    $data['model'] = $model;
                    $data['pro_att'] = $pro_att;
                    $data['supplier'] = $supplier;
                    $data['pageSize'] = $pageSize;
                    $this->renderPartial('supplier', $data, false, true);
                    /*                     * *************************************************************************************** */
                }
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteSupplier() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_supplier = Yii::app()->getRequest()->getParam('id_supplier', null);
            $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
            if (!isset($id_product_attribute) && isset($id_product, $id_supplier) && ($product = Product::model()->findByPk($id_product)) && ($supplier = Supplier::model()->findByPk($id_supplier))) {
                if ($models = ProductAttribute::model()->findAllByAttributes(array('id_product' => $id_product))) {
                    foreach ($models as $productattribute) {
                        $model = ProductSupplier::model()->findByAttributes(array('id_product' => $id_product, 'id_supplier' => $id_supplier, 'id_product_attribute' => $productattribute->id_product_attribute));
                        if (!empty($model)) {
                            $model->delete();
                        }
                    }
                }
            } elseif (isset($id_product, $id_supplier, $id_product_attribute) && ($product = Product::model()->findByPk($id_product)) && ($supplier = Supplier::model()->findByPk($id_supplier)) && ($attribute = ProductAttribute::model()->findByPk($id_product_attribute))) {
                $model = ProductSupplier::model()->findByAttributes(array('id_product' => $id_product, 'id_supplier' => $id_supplier, 'id_product_attribute' => $id_product_attribute));
                if (!empty($model)) {
                    $model->delete();
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionSupplier($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
        $supplier = new Supplier('searchByNoProduct');
        $supplier->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($supplier));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($supplier)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($supplier)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($supplier) . '_page'])) {
            $newsPage = (int) $_GET[get_class($supplier) . '_page'] - 1;
            Yii::app()->user->setState(get_class($supplier) . '_page', $newsPage);
            unset($_GET[get_class($supplier) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($supplier) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['pro_att'] = $pro_att;
            $data['supplier'] = $supplier;
            $data['pageSize'] = $pageSize;
            $this->renderPartial('supplier', $data, false, true);
        } else {
            $this->render('supplier', array(
                'model' => $model,
                'pro_att' => $pro_att,
                'supplier' => $supplier,
                'pageSize' => $pageSize,
            ));
        }
    }

    public function actionAddWarehouse() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_warehouse = Yii::app()->getRequest()->getParam('id_warehouse', null);
            $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
            if (!isset($id_product_attribute) && isset($id_product, $id_warehouse) && ($product = Product::model()->findByPk($id_product)) && ($warehouse = Warehouse::model()->findByPk($id_warehouse))) {
                if ($models = ProductAttribute::model()->findAllByAttributes(array('id_product' => $id_product))) {
                    foreach ($models as $productattribute) {
                        $model = new WarehouseProductLocation;
                        $model->id_warehouse = $warehouse->id_warehouse;
                        $model->id_product = $productattribute->id_product;
                        $model->id_product_attribute = $productattribute->id_product_attribute;
                        $model->updateRecord();
                    }
                }
            } elseif (isset($id_product, $id_warehouse, $id_product_attribute) && ($product = Product::model()->findByPk($id_product)) && ($warehouse = Warehouse::model()->findByPk($id_warehouse)) && ($attribute = ProductAttribute::model()->findByPk($id_product_attribute))) {
                $model = WarehouseProductLocation::model()->findByAttributes(array('id_product' => $id_product, 'id_warehouse' => $id_warehouse, 'id_product_attribute' => $id_product_attribute));
                if (empty($model)) {
                    $model = new WarehouseProductLocation;
                    $model->id_warehouse = $id_warehouse;
                    $model->id_product = $id_product;
                    $model->id_product_attribute = $id_product_attribute;
                    $model->updateRecord();
                }
            } else {
                $warehouses = Yii::app()->getRequest()->getParam('sg_autoId', null);
                $product_attributes = Yii::app()->getRequest()->getParam('pag_autoId', null);
                if (empty($warehouses) || empty($product_attributes)) {
                    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again. Du lieu bi loi [' . $warehouses . $product_attributes . ']');
                } else {
                    foreach ($product_attributes as $i => $product_attribute) {
                        foreach ($warehouses as $j => $warehouse) {
                            $model = WarehouseProductLocation::model()->findByAttributes(
                                    array('id_product' => $id_product,
                                        'id_warehouse' => $warehouse,
                                        'id_product_attribute' => $product_attribute
                                    )
                            );
                            if (empty($model)) {
                                $model = new WarehouseProductLocation;
                                $model->id_warehouse = $warehouse;
                                $model->id_product = $id_product;
                                $model->id_product_attribute = $product_attribute;
                                $model->updateRecord();
                            }
                        }
                    }
                    /*                     * ***************************************************************************** */
                    $model = $this->loadModel($id_product);
                    /*                     * *************************************************************************************** */
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
                    /*                     * *************************************************************************************** */
                    $warehouse = new Warehouse('searchByNoProduct');
                    $warehouse->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
                    $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($warehouse));
                    $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($warehouse)) . 'PageSize', Yii::app()->params['defaultPageSize']);

                    if (isset($_GET['pageSize'])) {
                        $pageSize = (int) $_GET['pageSize'];
                        Yii::app()->user->setState($uni_id . lcfirst(get_class($warehouse)) . 'PageSize', $pageSize);
                        unset($_GET['pageSize']);
                    }

                    if (isset($_GET[get_class($warehouse) . '_page'])) {
                        $newsPage = (int) $_GET[get_class($warehouse) . '_page'] - 1;
                        Yii::app()->user->setState(get_class($warehouse) . '_page', $newsPage);
                        unset($_GET[get_class($warehouse) . '_page']);
                    } else if (isset($_GET['ajax'])) {
                        Yii::app()->user->setState(get_class($warehouse) . '_page', 0);
                    }
                    /*                     * *************************************************************************************** */
                    $data = array();
                    $data['model'] = $model;
                    $data['pro_att'] = $pro_att;
                    $data['warehouse'] = $warehouse;
                    $data['pageSize'] = $pageSize;
                    $this->renderPartial('warehouse', $data, false, true);
                    /*                     * *************************************************************************************** */
                }
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteWarehouse() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_warehouse = Yii::app()->getRequest()->getParam('id_warehouse', null);
            $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
            if (!isset($id_product_attribute) && isset($id_product, $id_warehouse) && ($product = Product::model()->findByPk($id_product)) && ($warehouse = Warehouse::model()->findByPk($id_warehouse))) {
                if ($models = ProductAttribute::model()->findAllByAttributes(array('id_product' => $id_product))) {
                    foreach ($models as $productattribute) {
                        $model = WarehouseProductLocation::model()->findByAttributes(array('id_product' => $id_product, 'id_warehouse' => $id_warehouse, 'id_product_attribute' => $productattribute->id_product_attribute));
                        if (!empty($model)) {
                            $model->delete();
                        }
                    }
                }
            } elseif (isset($id_product, $id_warehouse, $id_product_attribute) && ($product = Product::model()->findByPk($id_product)) && ($warehouse = Warehouse::model()->findByPk($id_warehouse)) && ($attribute = ProductAttribute::model()->findByPk($id_product_attribute))) {
                $model = WarehouseProductLocation::model()->findByAttributes(array('id_product' => $id_product, 'id_warehouse' => $id_warehouse, 'id_product_attribute' => $id_product_attribute));
                if (!empty($model)) {
                    $model->delete();
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionWarehouse($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
        $warehouse = new Warehouse('searchByNoProduct');
        $warehouse->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($warehouse));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($warehouse)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($warehouse)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($warehouse) . '_page'])) {
            $newsPage = (int) $_GET[get_class($warehouse) . '_page'] - 1;
            Yii::app()->user->setState(get_class($warehouse) . '_page', $newsPage);
            unset($_GET[get_class($warehouse) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($warehouse) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['pro_att'] = $pro_att;
            $data['warehouse'] = $warehouse;
            $data['pageSize'] = $pageSize;
            $this->renderPartial('warehouse', $data, false, true);
        } else {
            $this->render('warehouse', array(
                'model' => $model,
                'pro_att' => $pro_att,
                'warehouse' => $warehouse,
                'pageSize' => $pageSize,
            ));
        }
    }

    public function actionAddQuantities($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionDeleteQuantities($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionQuantities($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
         $model->scenario = "addQuantity";
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Product'];
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = Manufacturer::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_manufacturer, array('logo' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('product/index', 'id' => $model->id_product));
                        //$this->redirect(array('view', 'id' => $model->id_category));
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

       $this->render('quantities', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'pageSize' => $pageSize,
        ));
    }

    public function actionAddAccessory() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product_1 = Yii::app()->getRequest()->getParam('id_product_1', null);
            $id_product_2 = Yii::app()->getRequest()->getParam('id_product_2', null);
            if (isset($id_product_1, $id_product_2) && ($product_1 = Product::model()->findByPk($id_product_1)) && ($product_2 = Product::model()->findByPk($id_product_2))) {
                $model = Accessory::model()->findByAttributes(array('id_product_1' => $product_1->id_product, 'id_product_2' => $product_2->id_product));
                if (empty($model)) {
                    $model = new Accessory;
                    $model->id_product_1 = $product_1->id_product;
                    $model->id_product_2 = $product_2->id_product;
                    $model->updateRecord();
                }
            } else {
                $products = Yii::app()->getRequest()->getParam('p_autoId', null);
                $product_1 = Product::model()->findByPk($id_product_1);
                if (empty($products) || empty($product_1)) {
                    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again. Du lieu bi loi [' . $warehouses . $product_attributes . ']');
                } else {
                    foreach ($products as $product) {
                        $model = Accessory::model()->findByAttributes(array('id_product_1' => $product_1->id_product, 'id_product_2' => $product));
                        if (empty($model)) {
                            $model = new Accessory;
                            $model->id_product_1 = $product_1->id_product;
                            $model->id_product_2 = $product;
                            $model->updateRecord();
                        }
                    }
                }
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteAccessory() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product_1 = Yii::app()->getRequest()->getParam('id_product_1', null);
            $id_product_2 = Yii::app()->getRequest()->getParam('id_product_2', null);
            if (isset($id_product_1, $id_product_2) && ($product_1 = Product::model()->findByPk($id_product_1)) && ($product_2 = Product::model()->findByPk($id_product_2))) {
                $model = Accessory::model()->findByAttributes(array('id_product_1' => $product_1->id_product, 'id_product_2' => $product_2->id_product));
                if (!empty($model)) {
                    $model->delete();
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAccessory($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
        $product1 = new Product('searchByNoAccessory');
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
        $product2 = new Product('searchByNoAccessory');
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
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['pro_att'] = $pro_att;
            $data['product1'] = $product1;
            $data['product2'] = $product2;
            $data['pageSize'] = $pageSize;
            $this->renderPartial('accessory', $data, false, true);
        } else {
            $this->render('accessory', array(
                'model' => $model,
                'pro_att' => $pro_att,
                'product1' => $product1,
                'product2' => $product2,
                'pageSize' => $pageSize,
            ));
        }
    }
    
   public function actionAddCategory() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_category = Yii::app()->getRequest()->getParam('id_category', null);
            if (isset($id_product, $id_category) && ($product = Product::model()->findByPk($id_product)) && ($category = Category::model()->findByPk($id_category))) {
                $model = new CategoryProduct;
                        $model->id_category = $category->id_category;
                        $model->id_product = $product->id_product;                        
                        $model->updateRecord();
            } 
            
               
                    /*                     * ***************************************************************************** */
                    $model = $this->loadModel($id_product);
                    /*                     * *************************************************************************************** */
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
                    /*                     * *************************************************************************************** */
                    $category = new Category('searchByNoProduct');
                    $category->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
                    $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($category));
                    $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($category)) . 'PageSize', Yii::app()->params['defaultPageSize']);

                    if (isset($_GET['pageSize'])) {
                        $pageSize = (int) $_GET['pageSize'];
                        Yii::app()->user->setState($uni_id . lcfirst(get_class($category)) . 'PageSize', $pageSize);
                        unset($_GET['pageSize']);
                    }

                    if (isset($_GET[get_class($category) . '_page'])) {
                        $newsPage = (int) $_GET[get_class($category) . '_page'] - 1;
                        Yii::app()->user->setState(get_class($category) . '_page', $newsPage);
                        unset($_GET[get_class($category) . '_page']);
                    } else if (isset($_GET['ajax'])) {
                        Yii::app()->user->setState(get_class($category) . '_page', 0);
                    }
                    /*                     * *************************************************************************************** */
                    $data = array();
                    $data['model'] = $model;
                    $data['pro_att'] = $pro_att;
                    $data['category'] = $category;
                    $data['pageSize'] = $pageSize;
                    $this->renderPartial('category', $data, false, true);
                    /*                     * *************************************************************************************** */
                
            

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Yêu cầu này không hợp lệ. Vui lòng đừng lập lại hành động này một lần nữa.');
    }

    public function actionDeleteCategory() {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $id_product = Yii::app()->getRequest()->getParam('id_product', null);
            $id_category = Yii::app()->getRequest()->getParam('id_category', null);
            $id_product_attribute = Yii::app()->getRequest()->getParam('id_product_attribute', null);
            if (isset($id_product, $id_category) && ($product = Product::model()->findByPk($id_product)) && ($category = Category::model()->findByPk($id_category)) ) {
                $model = CategoryProduct::model()->findByAttributes(array('id_product' => $id_product, 'id_category' => $id_category));
                if (!empty($model)) {
                    $model->delete();
                }
            } else {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            }

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Yêu cầu này không hợp lệ. Vui lòng đừng lập lại hành động này một lần nữa.');
    }

    public function actionCategory($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */
        $category = new Category('searchByNoProduct');
        $category->unsetAttributes();  // clear any default values
// This portion of code is belongs to Page size dropdown.
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($category));
        $pageSize = Yii::app()->user->getState($uni_id . lcfirst(get_class($category)) . 'PageSize', Yii::app()->params['defaultPageSize']);

        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . lcfirst(get_class($category)) . 'PageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET[get_class($category) . '_page'])) {
            $newsPage = (int) $_GET[get_class($category) . '_page'] - 1;
            Yii::app()->user->setState(get_class($category) . '_page', $newsPage);
            unset($_GET[get_class($category) . '_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState(get_class($category) . '_page', 0);
        }
        /*         * *************************************************************************************** */
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['pro_att'] = $pro_att;
            $data['category'] = $category;
            $data['pageSize'] = $pageSize;
            $this->renderPartial('category', $data, false, true);
        } else {
            $this->render('category', array(
                'model' => $model,
                'pro_att' => $pro_att,
                'category' => $category,
                'pageSize' => $pageSize,
            ));
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        /*         * *************************************************************************************** */
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
        /*         * *************************************************************************************** */

        $this->render('view', array(
            'model' => $model,
            'pro_att' => $pro_att,
            'pageSize' => $pageSize,
        ));
    }

    protected function resizePhoto($fileName, $width, $height, $inputPath = null, $outputPath = null) {
        $ext = ImageHelper::FilenameExtension($fileName);
        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpeg', 'jpg', 'gif', 'png');
        if (in_array($ext, $upload_permitted_image_types)) {
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                } else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
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
            if (!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE))
                chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

            $this->resizePhoto($fileName, 640, 480);
            $this->resizePhoto($fileName, 240, 180);
            $this->resizePhoto($fileName, 50, 50);
            return true;
        } else
            return false;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Product;
// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Product'];
            
            if ($model->validate()) {
                //dump($model);exit();
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = Manufacturer::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_manufacturer, array('logo' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('product/index', 'id' => $model->id_product));
                        //$this->redirect(array('view', 'id' => $model->id_category));
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

        if (isset($_POST['Product'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'img');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Product'];
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Product::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        // note: img luu truc tiep tren folder. se xu ly rac va loi sau.
//                        $model = Manufacturer::model()->findByPk($model->getPrimaryKey());                         
//                        $model->updateByPk($model->id_manufacturer, array('logo' => $fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('product/index', 'id' => $model->id_product));
                        //$this->redirect(array('view', 'id' => $model->id_category));
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
            //$this->loadModel($id)->deleteByPk($id);
Product::model()->updateByPk($id, array('active' => 0, 'date_upd' => new CDbExpression('NOW()')));
// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else{
            Product::model()->updateByPk($id, array('active' => 0, 'date_upd' => new CDbExpression('NOW()')));
            $this->redirect(array('product/index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Product('search');
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
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

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
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
