<?php

class AddressController extends Controller {
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
                'actions' => array('updateform1', 'updateform2', 'index', 'deletePack', 'view', 'create', 'update', 'deletecart', 'getcarrier', 'countcart', 'editcart'),
                'users' => array('@'),
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

    public function actionUpdateform1() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Address;
            $flat = true;
            $this->renderpartial("form1", array('model' => $model, 'flat' => $flat));
            Yii::app()->end();
        }
    }

    public function actionUpdateform2() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Address;
            $flat = FALSE;
            $this->renderpartial("form1", array('model' => $model, 'flat' => $flat));
            Yii::app()->end();
        }
    }

    public function actionEditcart() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = Yii::app()->getRequest()->getParam('key', null);
            $quannty = Yii::app()->getRequest()->getParam('quannty', null);
            $cart = Yii::app()->session['cart'];
            $cart[$key]['soluong'] = $quannty;
            Yii::app()->session['cart'] = $cart;
            $data = $cart;
            $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $this->renderpartial("_viewCart", array('data' => $data, 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionDeletePack() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_pack = Yii::app()->getRequest()->getParam('key', null);
            $cart = Yii::app()->session['cart_pack'];
            unset($cart[$id_pack]);
            Yii::app()->session['cart_pack'] = $cart;
            $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
            $data_cart_pack = $cart;
            $this->renderpartial("_viewCart", array('data' => Yii::app()->session['cart'], 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionGetcarrier() {
        if (Yii::app()->request->isAjaxRequest) {
            $id_zone = Yii::app()->getRequest()->getParam('id_zone', null);
            $criteria = new CDbCriteria();
            $criteria->select = "id_carrier,name";
            $criteria->addCondition("id_carrier in (SELECT DISTINCT id_carrier FROM tbl_carrier_zone WHERE id_zone=:id_zone)");
            $criteria->params = array(':id_zone' => $id_zone);
            $data = Carrier::model()->findAll($criteria);
            $dropDown = "";
            $i = 0;
            $ck = "";
            $y = isset(Yii::app()->session['id_carrier']) ? Yii::app()->session['id_carrier'] : 0;
            foreach ($data as $value) {
                if ($y != 0) {
                    if ($y == $value->id_carrier) {
                        $ck = "checked='checked'";
                    } else {
                        $ck = "";
                    }
                } else {
                    if ($i == 0) {
                        $ck = "checked='checked'";
                    } else {
                        $ck = "";
                    }
                }
                $dropDown .= "<input " . $ck . " group ='id_carrier' type='radio' name='id_carrier' value='$value->id_carrier'>" . $value->name;
                $i++;
            }
            echo $dropDown;
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->layout = "//layouts/content";
        $model = new Address;
        $model1 = new Address;
        $flat = true;
        $cart = new Cart;
        if (isset(Yii::app()->session['address1']) && isset(Yii::app()->session['address2'])) {
            $model->fullname = Yii::app()->session['address1']['fullname'];
            $model->company = Yii::app()->session['address1']['company'];
            $model->address1 = Yii::app()->session['address1']['address1'];
            $model->phone = Yii::app()->session['address1']['phone'];
            $model->mobile = Yii::app()->session['address1']['mobile'];
            $model->id_city = Yii::app()->session['address1']['id_city'];
            $model->id_zone = Yii::app()->session['address1']['id_zone'];

            $model1->fullname = Yii::app()->session['address2']['fullname'];
            $model1->company = Yii::app()->session['address2']['company'];
            $model1->address1 = Yii::app()->session['address2']['address1'];
            $model1->phone = Yii::app()->session['address2']['phone'];
            $model1->mobile = Yii::app()->session['address2']['mobile'];
            $model1->id_city = Yii::app()->session['address2']['id_city'];
            $model1->id_zone = Yii::app()->session['address2']['id_zone'];
            $cart->id_carrier = Yii::app()->session['id_carrier'];
        } elseif ($order=Orders::model()->findByAttributes(array('id_customer' => Yii::app()->user->id))) {
            $address1 = Address::model()->findByPk($order->id_address_invoice);
            $address2 = Address::model()->findByPk($order->id_address_delivery);

            $model->fullname = $address1->fullname;
            $model->company = $address1->company;
            $model->address1 = $address1->address1;
            $model->phone = $address1->phone;
            $model->mobile = $address1->mobile;
            $model->id_city = $address1->id_city;
            $model->id_zone = $address1->id_zone;

            $model1->fullname = $address2->fullname;
            $model1->company = $address2->company;
            $model1->address1 = $address2->address1;
            $model1->phone = $address2->phone;
            $model1->mobile = $address2->mobile;
            $model1->id_city = $address2->id_city;
            $model1->id_zone = $address2->id_zone;
        }
        if (isset($_POST['Address'])) {
            //xet sự tồn tại giỏ hàng
            if (isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0) {
                //xét nếu không cùng địa chỉ
                if (!isset($_POST['type'])) {
                    if (isset(Yii::app()->session['check'])) {
                        unset(Yii::app()->session['check']);
                    }
                    $model->attributes = $_POST['Address'][1];
                    $model1->attributes = $_POST['Address'][2];
                    if ($model->validate() && $model1->validate()) {
                        // khởi tạo session để lưu địa chỉ
                        if (!isset(Yii::app()->session['address1'])) {
                            Yii::app()->session['address1'] = array();
                        }
                        $temp = Yii::app()->session['address1'];
                        $temp['fullname'] = $_POST['Address'][1]['fullname'];
                        $temp['company'] = $_POST['Address'][1]['company'];
                        $temp['address1'] = $_POST['Address'][1]['address1'];
                        $temp['phone'] = $_POST['Address'][1]['phone'];
                        $temp['mobile'] = $_POST['Address'][1]['mobile'];
                        $temp['id_city'] = (int) $_POST['Address'][1]['id_city'];
                        $temp['id_zone'] = (int) $_POST['Address'][1]['id_zone'];
                        Yii::app()->session['address1'] = $temp;

                        if (!isset(Yii::app()->session['address2'])) {
                            Yii::app()->session['address2'] = array();
                        }
                        $temp0 = Yii::app()->session['address2'];
                        $temp0['fullname'] = $_POST['Address'][2]['fullname'];
                        $temp0['company'] = $_POST['Address'][2]['company'];
                        $temp0['address1'] = $_POST['Address'][2]['address1'];
                        $temp0['phone'] = $_POST['Address'][2]['phone'];
                        $temp0['mobile'] = $_POST['Address'][2]['mobile'];
                        $temp0['id_city'] = (int) $_POST['Address'][2]['id_city'];
                        $temp0['id_zone'] = (int) $_POST['Address'][2]['id_zone'];
                        Yii::app()->session['address2'] = $temp0;
                        Yii::app()->session['id_carrier'] = isset($_POST['id_carrier']) ? (int) $_POST['id_carrier'] : 1;
                        if (isset(Yii::app()->request->cookies['count']) && Yii::app()->request->cookies['count']->value == 0) {
                            Yii::app()->request->cookies['count'] = new CHttpCookie('count', 1);
                        }
                        $this->redirect(array('cart/create'));
                    }
                } elseif (isset($_POST['type']) && $_POST['type'] == 1) {
                    // nếu đia chỉ nhận hàng và giao hàng trùng nhau tạo session
                    if (!isset(Yii::app()->session['check'])) {
                        Yii::app()->session['check'] = 1;
                    }
                    $model1->attributes = $_POST['Address'][2];
                    if ($model1->validate()) {
                        if (!isset(Yii::app()->session['address1'])) {
                            Yii::app()->session['address1'] = array();
                        }

                        $temp = Yii::app()->session['address1'];
                        $temp['fullname'] = $_POST['Address'][2]['fullname'];
                        $temp['company'] = $_POST['Address'][2]['company'];
                        $temp['address1'] = $_POST['Address'][2]['address1'];
                        $temp['phone'] = $_POST['Address'][2]['phone'];
                        $temp['mobile'] = $_POST['Address'][2]['mobile'];
                        $temp['id_city'] = (int) $_POST['Address'][2]['id_city'];
                        $temp['id_zone'] = (int) $_POST['Address'][2]['id_zone'];
                        Yii::app()->session['address1'] = $temp;

                        if (!isset(Yii::app()->session['address2'])) {
                            Yii::app()->session['address2'] = array();
                        }
                        $temp0 = Yii::app()->session['address2'];
                        $temp0['fullname'] = $_POST['Address'][2]['fullname'];
                        $temp0['company'] = $_POST['Address'][2]['company'];
                        $temp0['address1'] = $_POST['Address'][2]['address1'];
                        $temp0['phone'] = $_POST['Address'][2]['phone'];
                        $temp0['mobile'] = $_POST['Address'][2]['mobile'];
                        $temp0['id_city'] = (int) $_POST['Address'][2]['id_city'];
                        $temp0['id_zone'] = (int) $_POST['Address'][2]['id_zone'];
                        Yii::app()->session['address2'] = $temp0;
                        Yii::app()->session['id_carrier'] = isset($_POST['id_carrier']) ? (int) $_POST['id_carrier'] : 1;
                        if (isset(Yii::app()->request->cookies['count']) && Yii::app()->request->cookies['count']->value == 0) {
                            Yii::app()->request->cookies['count'] = new CHttpCookie('count', 1);
                        }
                        $this->redirect(array('cart/create'));
                    }
                }
            } else {
                $this->redirect(array('site/index'));
            }
        }
        if (isset($_POST['back_sh'])) {
            $this->redirect(array('product/showCart'));
        }
        $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
        $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
        $this->render('create', array(
            'model' => $model,
            'model1' => $model1,
            'cart' => $cart,
            'data' => $data,
            'data_cart_pack' => $data_cart_pack,
            'flat' => $flat,
        ));
    }

    public function actionCountcart() {
        if (Yii::app()->request->isAjaxRequest) {
            echo count(Yii::app()->session['cart']);
            Yii::app()->end();
        }
    }

    public function actionDeletecart() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = Yii::app()->getRequest()->getParam('key', null);
            $cart = Yii::app()->session['cart'];
            unset($cart[$key]);
            Yii::app()->session['cart'] = $cart;
            $data = $cart;
            $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $this->renderpartial("_viewCart", array('data' => $data, 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'address-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
