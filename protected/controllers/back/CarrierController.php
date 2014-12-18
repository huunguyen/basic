<?php

class CarrierController extends Controller {

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
                'actions' => array('index', 'view', 'create', 'update', 'viewRange', 'createRange', 'sCRange', 'updateRange', 'updateCities', 'updateZones', 'delivery', 'uDelivery', 'calShipCost', 'updateRanges'),
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

    public function calCost($cost, $min, $max, $price) {
        if (!isset($cost, $min, $max))
            return $price;
        if (($min <= $cost) && ($cost <= $max)) {
            return $price;
        } elseif ($cost < $min) {
            return $price;
        } elseif ($max > 0) {
            return $price * (round($cost / $max, 0) + 1);
        } else
            return $price;
    }

    public function calCostByWeight(OrderCarrier $oc) {
        $criteria = new CDbCriteria();
        $criteria->compare('id_carrier', $oc->id_carrier);

        $criteria->compare('range_price', $oc->_id_range);
        $criteria->addCondition("range_weight IS NULL");
        $criteria->addCondition("range_distant IS NULL");

        if (($delivery = Delivery::model()->find($criteria)) && ($price = RangeWeight::model()->findByPk($oc->_id_range))) {
            if ($oc->price < $price->delimiter2)
                return $delivery->price;
            else {
                return $this->calCost($oc->price, $price->delimiter1, $price->delimiter2, $delivery->price);
            }
        } else
            return $oc->price;
    }

    public function calCostByDistant(OrderCarrier $oc) {
        $criteria = new CDbCriteria();
        $criteria->compare('id_carrier', $oc->id_carrier);

        $criteria->compare('range_price', $oc->_id_range);
        $criteria->addCondition("range_weight IS NULL");
        $criteria->addCondition("range_distant IS NULL");

        if (($delivery = Delivery::model()->find($criteria)) && ($price = RangeDistant::model()->findByPk($oc->_id_range))) {
            if ($oc->price < $price->delimiter2)
                return $delivery->price;
            else {
                return $this->calCost($oc->price, $price->delimiter1, $price->delimiter2, $delivery->price);
            }
        } else
            return $oc->price;
    }

    public function calCostByPrice(OrderCarrier $oc) {
        $criteria = new CDbCriteria();
        $criteria->compare('id_carrier', $oc->id_carrier);

        $criteria->compare('range_price', $oc->_id_range);
        $criteria->addCondition("range_weight IS NULL");
        $criteria->addCondition("range_distant IS NULL");

        if (($delivery = Delivery::model()->find($criteria)) && ($price = RangePrice::model()->findByPk($oc->_id_range))) {
            if ($oc->price < $price->delimiter2)
                return $delivery->price;
            else {
                return $this->calCost($oc->price, $price->delimiter1, $price->delimiter2, $delivery->price);
            }
        } else
            return $oc->price;
    }

    public function calCostByComplex(OrderCarrier $oc) {
        return $oc->price;
    }

    public function actionUpdateRanges() {
        $method = Yii::app()->getRequest()->getParam('method', null);
        $id_carrier = Yii::app()->getRequest()->getParam('id_carrier', null);
        $dropDown = "<option value=''>Chọn KC | KL | Giá</option>";
        if (!is_null($method) && ($carrier = Carrier::model()->findByPk($id_carrier))) {
            switch ($method) {
                case "weight":
                    $data = CHtml::listData($carrier->rangeWeights, 'id_range_weight', 'name');
                    break;
                case "distant":
                    $data = CHtml::listData($carrier->rangeDistants, 'id_range_distant', 'name');
                    break;
                case "price":
                    $data = CHtml::listData($carrier->rangePrices, 'id_range_price', 'name');
                    break;
                default :
                    $deliveries = Delivery::model()->findAll();
                    $data = CHtml::listData($deliveries, 'id_delivery', 'fullname');
                    break;
            }
            foreach ($data as $value => $name)
                $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            echo CJSON::encode(array(
                'dropDown' => $dropDown,
                'method' => $method
            ));
        } else {
            echo CJSON::encode(array(
                'dropDown' => $dropDown,
                'method' => ""
            ));
        }
        Yii::app()->end();
    }

    public function actionCalShipCost() {
        header('Content-type: application/json');
        $id_order = Yii::app()->getRequest()->getParam('id_order', null);
        $id_carrier = Yii::app()->getRequest()->getParam('id_carrier', null);
        $method = Yii::app()->getRequest()->getParam('method', null);
        $model = new OrderCarrier;
        if (isset($_POST['OrderCarrier'])) {
            $model->attributes = $_POST['OrderCarrier'];
            $model->_id_range = $_POST['OrderCarrier']['_id_range'];
            $id_order = $model->id_order;
            $id_carrier = $model->id_carrier;
            $method = $model->method;
        }
        if (!isset($id_order, $id_carrier)) {
            throw new CHttpException(400, 'Đơn hàng không tồn tại trong hệ thống. Vui lòng đừng lập lại hành động này một lần nữa.');
        }
        $cost = 0;
        switch ($method) {
            case "weight":
                $cost = $this->calCostByWeight($model);
                break;
            case "distant":
                $cost = $this->calCostByDistant($model);
                break;
            case "price":
                $cost = $this->calCostByPrice($model);
                break;
            default :
                $cost = $this->calCostByComplex($model);
                break;
        }
        echo CJSON::encode(array(
            "id_order" => $id_order,
            "id_carrier" => $id_carrier,
            "cost" => $cost,
            "method" => $method,
        ));
        Yii::app()->end();
    }

    public function actionUDelivery($id) {
        $model = OrderCarrier::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(400, 'Đơn hàng không tồn tại trong hệ thống. Vui lòng đừng lập lại hành động này một lần nữa.');
        $this->render('uocarrier', array(
            'model' => $model,
            'order' => $model->idOrder,
            'carrier' => $model->idCarrier
                )
        );
    }

    public function actionDelivery($id) {
        $order = Orders::model()->findByPk($id);
        $id_carrier = Yii::app()->getRequest()->getParam('id_carrier', null);
        $carrier = Carrier::model()->findByPk($id_carrier);
        if (($order === null) || ($carrier === null))
            throw new CHttpException(400, 'Đơn hàng không tồn tại trong hệ thống. Vui lòng đừng lập lại hành động này một lần nữa.');
        $model = OrderCarrier::model()->findByAttributes(array('id_order' => $order->id_order, 'id_carrier' => $carrier->id_carrier));
        if ($model === null) {
            $model = new OrderCarrier;
            $model->id_order = $order->id_order;
            $model->id_carrier = $carrier->id_carrier;
            $model->price = $order->total_paid_tax_excl;
        }
        if (isset($_POST['OrderCarrier'])) {
            $model->attributes = $_POST['OrderCarrier'];
            $model->_id_range = $_POST['OrderCarrier']['_id_range'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Đã lưu thành công');
                $this->redirect(array('carrier/view', 'id' => $model->id_carrier));
            }
        }
        $this->render('cocarrier', array(
            'model' => $model,
            'order' => $order,
            'carrier' => $carrier
                )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $order = new Orders('searchByCarrier');
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'order' => $order,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewRange($id) {
        $model = $this->loadModel($id);
        $act = Yii::app()->getRequest()->getParam('act', "");
        $id_delivery = Yii::app()->getRequest()->getParam('id_delivery', null);
        $delivery = Delivery::model()->findByPk($id_delivery);
        $id_range = Yii::app()->getRequest()->getParam('id_range', null);
        if (Yii::app()->request->isPostRequest && ($act == 'del') && ($delivery != null)) {

            if (!empty($delivery->rangePrice)) {
                $range = RangePrice::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_range_price' => $delivery->rangePrice->id_range_price));
                if ($range != null) {
                    $delivery->delete();
                    $range->delete();
                }
            }

            if (!empty($delivery->rangeWeight)) {
                $range = RangeWeight::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_range_weight' => $delivery->rangeWeight->id_range_weight));
                if ($range != null) {
                    $delivery->delete();
                    $range->delete();
                }
            }

            if (!empty($delivery->rangeDistant)) {
                $range = RangeDistant::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_range_distant' => $delivery->rangeDistant->id_range_distant));
                if ($range != null) {
                    $delivery->delete();
                    $range->delete();
                }
            }
        }
        $this->render('vrange', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionCreateRange($id) {
        $model = $this->loadModel($id);
        $delivery = $prange = $wrange = $drange = array();
        $act = Yii::app()->getRequest()->getParam('act', "");
        $id_zone = Yii::app()->getRequest()->getParam('id_zone', null);
        $status = 'fail';
        if (Yii::app()->request->isPostRequest && ($act == 'del') && ($id_zone != null)) {
            $carrierzone = CarrierZone::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_zone' => $id_zone));
            if ($carrierzone != null) {
                $exist_deliveries = Delivery::model()->findAll(array(
                    'condition' => 'id_carrier=:id_carrier AND id_zone=:id_zone',
                    'params' => array(':id_carrier' => $model->id_carrier, ':id_zone' => $id_zone)
                        )
                );
                if ($exist_deliveries != null) {
                    foreach ($exist_deliveries as $exist_delivery) {
                        $exist_delivery->delete();
                        if (!empty($exist_delivery->rangePrice)) {
                            $exist_delivery->rangePrice->delete();
                        }
                        if (!empty($exist_delivery->rangeWeight)) {
                            $exist_delivery->rangeWeight->delete();
                        }
                        if (!empty($exist_delivery->rangeDistant)) {
                            $exist_delivery->rangeDistant->delete();
                        }
                    }
                }
                $carrierzone->delete();
            }
            $status = 'success';
        }

        if (isset($model->tblZones) && !empty($model->tblZones)) {
            $count = 0;
            foreach ($model->tblZones as $zone) {
                if ($zone->active >= 1) {
                    $delivery[] = new Delivery();
                    $delivery[$count]->id_zone = $zone->id_zone;
                    $prange[] = new RangePrice();
                    $wrange[] = new RangeWeight();
                    $drange[] = new RangeDistant();
                }
                $count++;
            }
        } else {
            Yii::app()->user->setFlash('fail', 'Cần tạo vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Trước khi tạo chi tiết phân phối trong khu vực');
            $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
        }

        if (isset($_POST['Delivery'])) {
            $count = 0;
            //$transaction2 = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['Delivery'] as $row) {
                    $delivery[$count]->attributes = $row;
                    $exist_models_delivery = Delivery::model()->findAll(array(
                        'condition' => 'id_carrier=:id_carrier AND id_zone=:id_zone',
                        'params' => array(':id_carrier' => $model->id_carrier, ':id_zone' => $delivery[$count]->id_zone)
                            )
                    );
                    $idRangelist = array();
                    //dump($delivery[$count]);exit();
                    if ($model->range_behavior <= 1) {
                        $prange[$count]->attributes = isset($_POST['RangePrice'][$count]) ? $_POST['RangePrice'][$count] : null;
                        $prange[$count]->id_carrier = $model->id_carrier;

                        if ($exist_models_delivery != null) {
                            foreach ($exist_models_delivery as $exist_model_delivery) {
                                if (!empty($exist_model_delivery->rangePrice) && isset($exist_model_delivery->rangePrice)) {
                                    $idRangelist[] = $exist_model_delivery->rangePrice->id_range_price;
                                }
                            }
                        }
                        if (count($idRangelist) > 0) {
                            $criteria = new CDbCriteria;
                            $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                    . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                    . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                    . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                    . ')';
                            $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $prange[$count]->delimiter1, ':delimiter2' => $prange[$count]->delimiter2);
                            $criteria->addInCondition('id_range_price', $idRangelist);
                            $exist_a_model = RangePrice::model()->find($criteria);
                        }

                        // update row
                        if (isset($exist_a_model) && ($exist_a_model != null)) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } else
                        if ($prange[$count]->save()) {
                            $delivery[$count]->range_price = $prange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_price' => $delivery[$count]->range_price
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_price = $delivery[$count]->range_price;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    }
                    else
                    if ($model->range_behavior == 2) {
                        $wrange[$count]->attributes = isset($_POST['RangeWeight'][$count]) ? $_POST['RangeWeight'][$count] : null;


                        $wrange[$count]->id_carrier = $model->id_carrier;
                        $delivery[$count]->delimiter1 = $wrange[$count]->delimiter1;
                        $delivery[$count]->delimiter2 = $wrange[$count]->delimiter2;
                        $criteria = new CDbCriteria;
                        $criteria->compare('id_carrier', $model->id_carrier);
                        $criteria->compare('id_zone', $delivery[$count]->id_zone);
                        $criteria->addCondition("range_weight IS NOT NULL");
                        $criteria->addCondition("range_price IS NULL");
                        $criteria->addCondition("range_distant IS NULL");
                        $flag = true;
                        if ($deliveries = Delivery::model()->findAll($criteria)) {
                            foreach ($deliveries as $delivery1) {
                                $delimiter1 = $delivery1->rangeWeight->delimiter1;
                                $delimiter2 = $delivery1->rangeWeight->delimiter2;
                                if (($delimiter1 < $wrange[$count]->delimiter1 & $wrange[$count]->delimiter1 < $delimiter2) ||
                                        ($delimiter1 < $wrange[$count]->delimiter2 & $wrange[$count]->delimiter2 < $delimiter2) ||
                                        ($wrange[$count]->delimiter1 <= $delimiter1 & $wrange[$count]->delimiter2 >= $delimiter2)
                                ) {
                                    $flag = false;
                                }
                            }
                        }
                        if ($flag && $wrange[$count]->save()) {
                            $delivery[$count]->range_weight = $wrange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_weight' => $delivery[$count]->range_weight
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_weight = $delivery[$count]->range_weight;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    }
                    else
                    if ($model->range_behavior == 3) {
                        $drange[$count]->attributes = isset($_POST['RangeDistant'][$count]) ? $_POST['RangeDistant'][$count] : null;

                        $drange[$count]->id_carrier = $model->id_carrier;
                        $criteria = new CDbCriteria;
                        $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                . ')';
                        $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $drange[$count]->delimiter1, ':delimiter2' => $drange[$count]->delimiter2);
                        $exist_a_model = RangeDistant::model()->find($criteria);

                        // update row
                        if ($exist_a_model != null) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } elseif ($drange[$count]->save()) {
                            $delivery[$count]->range_distant = $drange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_distant' => $delivery[$count]->range_distant
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_distant = $delivery[$count]->range_distant;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    }
                    else {
                        Yii::app()->user->setFlash('fail', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Chưa được xử lý');
                        $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
                    }
                    $count++;
                }
            } catch (Exception $exc) {
                //$transaction2->rollback();
                Yii::app()->user->setFlash('fail', 'Tạo Chi tiết vùng và khu vực cho <strong>Nhà Phân Phối!</strong>' . $exc->getMessage());
            }
            //$transaction2->commit();
            Yii::app()->user->setFlash('success', 'Tạo thành công <strong>Bản giá tính!</strong>');
            $this->redirect(array('carrier/viewRange', 'id' => $model->id_carrier));
        }

        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['delivery'] = $delivery;
            $data['prange'] = $prange;
            $data['wrange'] = $wrange;
            $data['drange'] = $drange;
            $data['status'] = $status;

            if ($model->range_behavior <= 1)
                $this->renderPartial('_form_rprice', $data, false, true);
            elseif ($model->range_behavior == 2)
                $this->renderPartial('_form_rweight', $data, false, true);
            elseif ($model->range_behavior == 3)
                $this->renderPartial('_form_rdistant', $data, false, true);
            else
                $this->renderPartial('_form_range', $data, false, true);
            Yii::app()->end();
        }
        else {
            $this->render('crange', array(
                'model' => $this->loadModel($id),
                'delivery' => $delivery,
                'prange' => $prange,
                'wrange' => $wrange,
                'drange' => $drange
                    )
            );
        }
    }
 /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionSCRange($id) {
        $model = $this->loadModel($id);
        $delivery = $prange = $wrange = $drange = array();
        $act = Yii::app()->getRequest()->getParam('act', "");
        $id_zone = Yii::app()->getRequest()->getParam('id_zone', null);
        $status = 'fail';
        if (Yii::app()->request->isPostRequest && ($act == 'del') && ($id_zone != null)) {
            $carrierzone = CarrierZone::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_zone' => $id_zone));
            if ($carrierzone != null) {
                $exist_deliveries = Delivery::model()->findAll(array(
                    'condition' => 'id_carrier=:id_carrier AND id_zone=:id_zone',
                    'params' => array(':id_carrier' => $model->id_carrier, ':id_zone' => $id_zone)
                        )
                );
                if ($exist_deliveries != null) {
                    foreach ($exist_deliveries as $exist_delivery) {
                        $exist_delivery->delete();
                        if (!empty($exist_delivery->rangePrice)) {
                            $exist_delivery->rangePrice->delete();
                        }
                        if (!empty($exist_delivery->rangeWeight)) {
                            $exist_delivery->rangeWeight->delete();
                        }
                        if (!empty($exist_delivery->rangeDistant)) {
                            $exist_delivery->rangeDistant->delete();
                        }
                    }
                }
                $carrierzone->delete();
            }
            $status = 'success';
        }

        if (isset($model->tblZones) && !empty($model->tblZones)) {
            $count = 0;
            foreach ($model->tblZones as $zone) {
                if ($zone->active >= 1) {
                    $delivery[] = new Delivery();
                    $delivery[$count]->id_zone = $zone->id_zone;
                    $prange[] = new RangePrice();
                    $wrange[] = new RangeWeight();
                    $drange[] = new RangeDistant();
                }
                $count++;
            }
        } else {
            Yii::app()->user->setFlash('fail', 'Cần tạo vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Trước khi tạo chi tiết phân phối trong khu vực');
            $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
        }

        if (isset($_POST['Delivery'])) {
            $count = 0;
            //$transaction2 = Yii::app()->db->beginTransaction();
            try {
                foreach ($_POST['Delivery'] as $row) {
                    $delivery[$count]->attributes = $row;
                    $exist_models_delivery = Delivery::model()->findAll(array(
                        'condition' => 'id_carrier=:id_carrier AND id_zone=:id_zone',
                        'params' => array(':id_carrier' => $model->id_carrier, ':id_zone' => $delivery[$count]->id_zone)
                            )
                    );
                    $idRangelist = array();
                    //dump($delivery[$count]);exit();
                    if ($model->range_behavior <= 1) {
                        $prange[$count]->attributes = isset($_POST['RangePrice'][$count]) ? $_POST['RangePrice'][$count] : null;
                        $prange[$count]->id_carrier = $model->id_carrier;

                        if ($exist_models_delivery != null) {
                            foreach ($exist_models_delivery as $exist_model_delivery) {
                                if (!empty($exist_model_delivery->rangePrice) && isset($exist_model_delivery->rangePrice)) {
                                    $idRangelist[] = $exist_model_delivery->rangePrice->id_range_price;
                                }
                            }
                        }
                        if (count($idRangelist) > 0) {
                            $criteria = new CDbCriteria;
                            $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                    . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                    . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                    . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                    . ')';
                            $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $prange[$count]->delimiter1, ':delimiter2' => $prange[$count]->delimiter2);
                            $criteria->addInCondition('id_range_price', $idRangelist);
                            $exist_a_model = RangePrice::model()->find($criteria);
                        }

                        // update row
                        if (isset($exist_a_model) && ($exist_a_model != null)) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } else
                        if ($prange[$count]->save()) {
                            $delivery[$count]->range_price = $prange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_price' => $delivery[$count]->range_price
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_price = $delivery[$count]->range_price;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    }
                    else
                    if ($model->range_behavior == 2) {
                        $wrange[$count]->attributes = isset($_POST['RangeWeight'][$count]) ? $_POST['RangeWeight'][$count] : null;


                        $wrange[$count]->id_carrier = $model->id_carrier;
                        $delivery[$count]->delimiter1 = $wrange[$count]->delimiter1;
                        $delivery[$count]->delimiter2 = $wrange[$count]->delimiter2;
                        $criteria = new CDbCriteria;
                        $criteria->compare('id_carrier', $model->id_carrier);
                        $criteria->compare('id_zone', $delivery[$count]->id_zone);
                        $criteria->addCondition("range_weight IS NOT NULL");
                        $criteria->addCondition("range_price IS NULL");
                        $criteria->addCondition("range_distant IS NULL");
                        $flag = true;
                        if ($deliveries = Delivery::model()->findAll($criteria)) {
                            foreach ($deliveries as $delivery1) {
                                $delimiter1 = $delivery1->rangeWeight->delimiter1;
                                $delimiter2 = $delivery1->rangeWeight->delimiter2;
                                if (($delimiter1 < $wrange[$count]->delimiter1 & $wrange[$count]->delimiter1 < $delimiter2) ||
                                        ($delimiter1 < $wrange[$count]->delimiter2 & $wrange[$count]->delimiter2 < $delimiter2) ||
                                        ($wrange[$count]->delimiter1 <= $delimiter1 & $wrange[$count]->delimiter2 >= $delimiter2)
                                ) {
                                    $flag = false;
                                }
                            }
                        }
                        if ($flag && $wrange[$count]->save()) {
                            $delivery[$count]->range_weight = $wrange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_weight' => $delivery[$count]->range_weight
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_weight = $delivery[$count]->range_weight;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    }
                    else
                    if ($model->range_behavior == 3) {
                        $drange[$count]->attributes = isset($_POST['RangeDistant'][$count]) ? $_POST['RangeDistant'][$count] : null;

                        $drange[$count]->id_carrier = $model->id_carrier;
                        $criteria = new CDbCriteria;
                        $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                . ')';
                        $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $drange[$count]->delimiter1, ':delimiter2' => $drange[$count]->delimiter2);
                        $exist_a_model = RangeDistant::model()->find($criteria);

                        // update row
                        if ($exist_a_model != null) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } elseif ($drange[$count]->save()) {
                            $delivery[$count]->range_distant = $drange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_distant' => $delivery[$count]->range_distant
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_distant = $delivery[$count]->range_distant;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    }
                    else {
                        Yii::app()->user->setFlash('fail', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Chưa được xử lý');
                        $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
                    }
                    $count++;
                }
            } catch (Exception $exc) {
                //$transaction2->rollback();
                Yii::app()->user->setFlash('fail', 'Tạo Chi tiết vùng và khu vực cho <strong>Nhà Phân Phối!</strong>' . $exc->getMessage());
            }
            //$transaction2->commit();
            Yii::app()->user->setFlash('success', 'Tạo thành công <strong>Bản giá tính!</strong>');
            $this->redirect(array('carrier/viewRange', 'id' => $model->id_carrier));
        }

        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['delivery'] = $delivery;
            $data['prange'] = $prange;
            $data['wrange'] = $wrange;
            $data['drange'] = $drange;
            $data['status'] = $status;

            if ($model->range_behavior <= 1)
                $this->renderPartial('_form_rprice', $data, false, true);
            elseif ($model->range_behavior == 2)
                $this->renderPartial('_form_rweight', $data, false, true);
            elseif ($model->range_behavior == 3)
                $this->renderPartial('_form_rdistant', $data, false, true);
            else
                $this->renderPartial('_form_range', $data, false, true);
            Yii::app()->end();
        }
        else {
            $this->render('crange', array(
                'model' => $this->loadModel($id),
                'delivery' => $delivery,
                'prange' => $prange,
                'wrange' => $wrange,
                'drange' => $drange
                    )
            );
        }
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     * @param integer $zid the ID of the zone model to be displayed
     * @param integer $rid the ID of the range model to be displayed
     */
    public function actionUpdateRange($id, $zid, $rid) {
        $model = $this->loadModel($id);
        $delivery = $prange = $wrange = $drange = array();
        $act = Yii::app()->getRequest()->getParam('act', "");
        $id_zone = Yii::app()->getRequest()->getParam('id_zone', null);
        $status = 'fail';
        if (Yii::app()->request->isPostRequest && ($act == 'del') && ($id_zone != null)) {
            $carrierzone = CarrierZone::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_zone' => $id_zone));
            if ($carrierzone != null) {
                $exist_deliveries = Delivery::model()->findAll(array(
                    'condition' => 'id_carrier=:id_carrier AND id_zone=:id_zone',
                    'params' => array(':id_carrier' => $model->id_carrier, ':id_zone' => $id_zone)
                        )
                );
                if ($exist_deliveries != null) {
                    foreach ($exist_deliveries as $exist_delivery) {
                        $exist_delivery->delete();
                        if (!empty($exist_delivery->rangePrice)) {
                            $exist_delivery->rangePrice->delete();
                        }
                        if (!empty($exist_delivery->rangeWeight)) {
                            $exist_delivery->rangeWeight->delete();
                        }
                        if (!empty($exist_delivery->rangeDistant)) {
                            $exist_delivery->rangeDistant->delete();
                        }
                    }
                }
                $carrierzone->delete();
            }
            $status = 'success';
        }

        if (isset($model->tblZones) && !empty($model->tblZones)) {
            $count = 0;
            foreach ($model->tblZones as $zone) {
                if ($zone->active >= 1) {
                    $delivery[] = new Delivery();
                    $delivery[$count]->id_zone = $zone->id_zone;
                    $prange[] = new RangePrice();
                    $wrange[] = new RangeWeight();
                    $drange[] = new RangeDistant();
                }
                $count++;
            }
        } else {
            Yii::app()->user->setFlash('fail', 'Cần tạo vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Trước khi tạo chi tiết phân phối trong khu vực');
            $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
        }

        if (isset($_POST['Delivery'])) {
            $count = 0;
            foreach ($_POST['Delivery'] as $row) {
                $delivery[$count]->attributes = $row;
                $exist_models_delivery = Delivery::model()->findAll(array(
                    'condition' => 'id_carrier=:id_carrier AND id_zone=:id_zone',
                    'params' => array(':id_carrier' => $model->id_carrier, ':id_zone' => $delivery[$count]->id_zone)
                        )
                );
                $idRangelist = array();
                if ($model->range_behavior <= 1) {
                    $prange[$count]->attributes = isset($_POST['RangePrice'][$count]) ? $_POST['RangePrice'][$count] : null;
                    $prange[$count]->id_carrier = $model->id_carrier;
                    //$transaction = Yii::app()->db->beginTransaction();
                    try {
                        if ($exist_models_delivery != null) {
                            foreach ($exist_models_delivery as $exist_model_delivery) {
                                if (!empty($exist_model_delivery->rangePrice) && isset($exist_model_delivery->rangePrice)) {
                                    $idRangelist[] = $exist_model_delivery->rangePrice->id_range_price;
                                }
                            }
                        }
                        if (count($idRangelist) > 0) {
                            $criteria = new CDbCriteria;
                            $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                    . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                    . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                    . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                    . ')';
                            $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $prange[$count]->delimiter1, ':delimiter2' => $prange[$count]->delimiter2);
                            $criteria->addInCondition('id_range_price', $idRangelist);
                            $exist_a_model = RangePrice::model()->find($criteria);
                        }

                        // update row
                        if (isset($exist_a_model) && ($exist_a_model != null)) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } elseif ($prange[$count]->save()) {
                            $delivery[$count]->range_price = $prange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_price' => $delivery[$count]->range_price
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_price = $delivery[$count]->range_price;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    } catch (Exception $exc) {
                        //$transaction->rollback();
                        Yii::app()->user->setFlash('fail', 'Tạo Chi tiết vùng và khu vực cho <strong>Nhà Phân Phối!</strong>' . $exc->getMessage());
                    }
                    //$transaction->commit();
                } elseif ($model->range_behavior == 2) {
                    $wrange[$count]->attributes = isset($_POST['RangeWeight'][$count]) ? $_POST['RangeWeight'][$count] : null;
                    //$transaction = Yii::app()->db->beginTransaction();
                    try {
                        $wrange[$count]->id_carrier = $model->id_carrier;
                        $criteria = new CDbCriteria;
                        $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                . ')';
                        $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $wrange[$count]->delimiter1, ':delimiter2' => $wrange[$count]->delimiter2);
                        $exist_a_model = RangePrice::model()->find($criteria);

                        // update row
                        if ($exist_a_model != null) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } elseif ($wrange[$count]->save()) {
                            $delivery[$count]->range_weight = $wrange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_weight' => $delivery[$count]->range_weight
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_weight = $delivery[$count]->range_weight;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    } catch (Exception $exc) {
                        //$transaction->rollback();
                        Yii::app()->user->setFlash('fail', 'Tạo Chi tiết vùng và khu vực cho <strong>Nhà Phân Phối!</strong>' . $exc->getMessage());
                    }
                    //$transaction->commit();
                } elseif ($model->range_behavior == 3) {
                    $drange[$count]->attributes = isset($_POST['RangeDistant'][$count]) ? $_POST['RangeDistant'][$count] : null;
                    //$transaction = Yii::app()->db->beginTransaction();
                    try {
                        $drange[$count]->id_carrier = $model->id_carrier;
                        $criteria = new CDbCriteria;
                        $criteria->condition = 'id_carrier=:id_carrier AND ( '
                                . '(:delimiter1 < delimiter1 AND delimiter1 < :delimiter2) '
                                . 'OR (:delimiter1 < delimiter2 AND delimiter2 < :delimiter2) '
                                . 'OR (delimiter1<=:delimiter1 AND delimiter2>=:delimiter2) '
                                . ')';
                        $criteria->params = array(':id_carrier' => $model->id_carrier, ':delimiter1' => $drange[$count]->delimiter1, ':delimiter2' => $drange[$count]->delimiter2);
                        $exist_a_model = RangePrice::model()->find($criteria);

                        // update row
                        if ($exist_a_model != null) {
                            Yii::app()->user->setFlash('error', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Đã tồn tại.');
                        } elseif ($drange[$count]->save()) {
                            $delivery[$count]->range_distant = $drange[$count]->getPrimaryKey();
                            $delivery[$count]->id_carrier = $model->id_carrier;
                            $exist_a_model = Delivery::model()->findByAttributes(
                                    array('id_carrier' => $model->id_carrier,
                                        'range_distant' => $delivery[$count]->range_distant
                                    )
                            );
                            // update row
                            if ($exist_a_model != null) {
                                $exist_a_model->id_carrier = $model->id_carrier;
                                $exist_a_model->range_distant = $delivery[$count]->range_distant;
                                $delivery[$count] = $exist_a_model;
                                Yii::app()->user->setFlash('error', 'Vùng và khu vực <strong>Phân Phối! </strong> Đã tồn tại.');
                            } elseif (!$delivery[$count]->save()) {
                                throw new CException('Transaction failed: ');
                            }
                        } else
                            throw new CException('Transaction failed: ');
                    } catch (Exception $exc) {
                        //$transaction->rollback();
                        Yii::app()->user->setFlash('fail', 'Tạo Chi tiết vùng và khu vực cho <strong>Nhà Phân Phối!</strong>' . $exc->getMessage());
                    }
                    //$transaction->commit();
                } else {
                    Yii::app()->user->setFlash('fail', 'Vùng và khu vực cho <strong>Nhà Phân Phối! </strong> Chưa được xử lý');
                    $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
                }
                $count++;
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['model'] = $model;
            $data['delivery'] = $delivery;
            $data['prange'] = $prange;
            $data['wrange'] = $wrange;
            $data['drange'] = $drange;
            $data['status'] = $status;

            if ($model->range_behavior <= 1)
                $this->renderPartial('_form_rprice', $data, false, true);
            elseif ($model->range_behavior == 2)
                $this->renderPartial('_form_rweight', $data, false, true);
            elseif ($model->range_behavior == 3)
                $this->renderPartial('_form_rdistant', $data, false, true);
            else
                $this->renderPartial('_form_range', $data, false, true);
            Yii::app()->end();
        }
        else {
            $this->render('urange', array(
                'model' => $this->loadModel($id),
                'delivery' => $delivery,
                'prange' => $prange,
                'wrange' => $wrange,
                'drange' => $drange
                    )
            );
        }
    }

    public function actionLoadRange() {
        if ($model = $this->loadModel(Yii::app()->getRequest()->getParam('id_carrier', null))) {
            $OutArray = array(
                'status' => 'success',
                'model' => $model,
                'Action' => 'load',
            );
        } else {
            $OutArray = array(
                'status' => 'fail',
                'Action' => 'load',
            );
        }


        echo cjson::encode($outArray);
        Yii::app()->end();
    }

    public function actionUpdateCities() {
        $style = Yii::app()->getRequest()->getParam('style', "");
        $data = CHtml::listData(City::model()->findAll('style=:style', array(':style' => $style)), 'id_city', 'name');
        $dropDown = "<option value=''>Chọn thành phố | tỉnh thành</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    public function actionUpdateZones() {
        if ($id_city = Yii::app()->getRequest()->getParam('city', null)) {
            $data = CHtml::listData(Zone::model()->findAll('id_city=:id_city AND active>=:active', array(':id_city' => $id_city, ':active' => 1)), 'id_zone', 'name');
        } else {
            $data = CHtml::listData(Zone::model()->findAll(array('order' => 'id_city ASC')), 'id_zone', 'name');
        }
        $dropDown = "<option value=''>Chọn Vùng</option>";
        foreach ($data as $value => $name)
            $dropDown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        echo CJSON::encode(array(
            'dropDown' => $dropDown
        ));
        Yii::app()->end();
    }

    /*
     * http://www.yiiframework.com/wiki/278/cgridview-render-customized-complex-datacolumns/
     * http://www.yiiframework.com/forum/index.php/topic/27401-additional-columns-for-cgridview-with-data-provider/
     */
//
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

    protected function resizePhoto($fileName, $width, $height, $inputPath = null, $outputPath = null) {
        $ext = ImageHelper::FilenameExtension($fileName);
        $upload_permitted_image_types = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png', 'jpeg', 'jpg', 'gif', 'png');
        if (in_array($ext, $upload_permitted_image_types)) {
            $inputPath = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . $fileName;
            $outputDirectory = Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . 'thumbnail';
            // check exist location if not exist to create location
            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . 'thumbnail')) {
                if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE)) {
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE, 0777);
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                } else
                    mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
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
            if (!is_writeable(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE))
                chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE, 0777);
            $uploadedFile->saveAs(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . $fileName);
            chmod(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . $fileName, 0777);

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
        $model = new Carrier;

// Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Carrier'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'logo');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Carrier'];
            $model->city = isset($_POST['Carrier']['city']) ? $_POST['Carrier']['city'] : null;
            $model->zones = isset($_POST['Carrier']['zones']) ? $_POST['Carrier']['zones'] : array();
            $model->warehouses = isset($_POST['Carrier']['warehouses']) ? $_POST['Carrier']['warehouses'] : array();
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->logo = $fileName;
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $fileName = $model->getPrimaryKey() . '.' . ImageHelper::FilenameExtension($fileName);
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        foreach ($model->zones as $zone) {
                            $carrierzone = CarrierZone::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_zone' => $zone));
                            if ($carrierzone === null) {
                                $carrierzone = new CarrierZone;
                                $carrierzone->id_carrier = $model->id_carrier;
                                $carrierzone->id_zone = $zone;
                                $carrierzone->updateRecord();
                            }
                        }
                        foreach ($model->warehouses as $warehouse) {
                            $warehousecarrier = WarehouseCarrier::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_warehouse' => $warehouse));
                            if ($warehousecarrier === null) {
                                $warehousecarrier = new WarehouseCarrier;
                                $warehousecarrier->id_carrier = $model->id_carrier;
                                $warehousecarrier->id_warehouse = $warehouse;
                                $warehousecarrier->updateRecord();
                            }
                        }
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
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

        if (isset($_POST['Carrier'])) {
            $rnd = rand(0, 9999);  // generate random number between 0-9999
            $uploadedFile = CUploadedFile::getInstance($model, 'logo');
            $fileName = preg_replace('/[.][.]+/s', '.', preg_replace('/[^a-zA-Z0-9.]/s', '', "{$rnd}_{$uploadedFile}"));
            $model->attributes = $_POST['Carrier'];
            $model->city = isset($_POST['Carrier']['city']) ? $_POST['Carrier']['city'] : null;
            $model->zones = isset($_POST['Carrier']['zones']) ? $_POST['Carrier']['zones'] : array();
            $model->warehouses = isset($_POST['Carrier']['warehouses']) ? $_POST['Carrier']['warehouses'] : array();
            if (is_object($uploadedFile) && !$uploadedFile->hasError)
                $model->logo = $fileName = $model->id_carrier . '.' . ImageHelper::FilenameExtension($fileName);
            if ($model->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($model->save(false)) {   // modify existing line to pass in false param
                        if (is_object($uploadedFile)) {
                            // check exist location if not exist to create location
                            if (!file_exists(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE)) {
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE, 0777);
                                mkdir(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE . DIRECTORY_SEPARATOR . 'thumbnail', 0777);
                            }
                            $this->savePhoto($uploadedFile, $fileName);
                        }
                        foreach ($model->zones as $zone) {
                            $carrierzone = CarrierZone::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_zone' => $zone));
                            if ($carrierzone === null) {
                                $carrierzone = new CarrierZone;
                                $carrierzone->id_carrier = $model->id_carrier;
                                $carrierzone->id_zone = $zone;
                                $carrierzone->updateRecord();
                            }
                        }
                        foreach ($model->warehouses as $warehouse) {
                            $warehousecarrier = WarehouseCarrier::model()->findByPk(array('id_carrier' => $model->id_carrier, 'id_warehouse' => $warehouse));
                            if ($warehousecarrier === null) {
                                $warehousecarrier = new WarehouseCarrier;
                                $warehousecarrier->id_carrier = $model->id_carrier;
                                $warehousecarrier->id_warehouse = $warehouse;
                                $warehousecarrier->updateRecord();
                            }
                        }
                        $transaction->commit();
                        ImageHelper::delOtherImage(Yii::getPathOfAlias('uploads') . DIRECTORY_SEPARATOR . Carrier::TYPE, $model->getPrimaryKey(), ImageHelper::FilenameExtension($fileName));
                        Yii::app()->user->setFlash('success', 'đã được tạo <strong>Thành công! </strong>');
                        $this->redirect(array('carrier/index', 'id' => $model->id_carrier));
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
        $model = new Carrier('search');
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

        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Carrier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Carrier']))
            $model->attributes = $_GET['Carrier'];

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
        $model = Carrier::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'carrier-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
