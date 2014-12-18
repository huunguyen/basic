<?php

class CartController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('bank', 'index', 'sentEmail', 'deletePack', 'createOder', 'create', 'deletecart', 'erro', 'editcart'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update'),
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

    public function actionBank() {
        $id = Yii::app()->getRequest()->getParam("id_bank", NULL);
        $model = Bank::model()->findByPk($id);
        $this->renderPartial('bankdetail', array('model' => $model), FALSE, TRUE);
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
            $this->renderpartial("_viewpro", array('data' => $data, 'data_cart_pack' => $data_cart_pack), FALSE, true);
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
            $this->renderpartial("_viewpro", array('data' => $data, 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function actionCreate() {
        $this->layout = "//layouts/content8";
        if (isset($_POST['Cart']) && isset($_POST['ok'])) {
            if (isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack'])) {
                if (isset(Yii::app()->request->cookies['count']) && Yii::app()->request->cookies['count']->value <= 2) {
                    Yii::app()->request->cookies['count'] = new CHttpCookie('count', 2);
                }
                $this->redirect(array('cart/createOder'));
            } elseif (!isset(Yii::app()->session['cart']) || count(Yii::app()->session['cart']) == 0) {
                $this->UnsetSession();
                $this->redirect(array('site/index'));
            }
        }

        if (isset($_POST['back'])) {
            $this->redirect(array('address/create'));
        }

        $model = Post::model()->findByPk(16);
        $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
        $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
        $this->render('create', array(
            'model' => $model,
            'data' => $data,
            'data_cart_pack' => $data_cart_pack,
        ));
    }

    public function actionCreateOder() {
        $this->layout = "//layouts/content8";
        if (isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0) {
            $model = new Address;
            $model1 = new Address;
            if (isset($_POST['next'])) {
                if (isset(Yii::app()->session['cart']) && count(Yii::app()->session['cart']) != 0 || isset(Yii::app()->session['cart_pack']) && count(Yii::app()->session['cart_pack']) != 0) {
                    $data = Yii::app()->session['cart'];
                    $data_pack = Yii::app()->session['cart_pack'];
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        //luu địa chi
                        $model = $this->address_deliverySave($model);
                        $model1 = $this->address_invoiceSave($model1);
                        if ($model && $model1) {

                            $id_address_delivery = $model->id_address;
                            $id_address_invoice = $model1->id_address;
                            //lưu cart
                            $cart = $this->CartSave($id_address_delivery, $id_address_invoice);
                            if ($cart) {
                                // chạy vòng lặp của cart.
                                $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : array();
                                if (!empty($data)) {
                                    //mang temp dùng để lưu vào cartproduct
                                    $temp = array();
                                    foreach ($data as $key => $value) {

                                        if (isset($temp[$value['id_sp']])) {
                                            $temp[$value['id_sp']] = (int) $temp[$value['id_sp']] + (int) $value['soluong'];
                                        } else {
                                            $temp[$value['id_sp']] = (int) $value['soluong'];
                                        }

                                        $product = Product::model()->findByPk($value['id_sp']);
                                        //trừ sản phẩm trong stock
                                        if ($product->stock_management == 0) {
                                            $product_attribute = ProductAttribute::model()->findByAttributes(array('id_product' => $value['id_sp'], 'id_product_attribute' => $value['id_att']));
                                            if (!empty($product_attribute)) {
                                                $product_attribute->quantity = $product_attribute->quantity - $value['soluong'];
                                                $product_attribute->save(FALSE);
                                            }
                                        }
                                        // thêm sản phẩm vào Customization 
                                        $Customization = Customization::model()->findByAttributes(array('id_product' => $value['id_sp'], 'id_product_attribute' => $value['id_att'], 'id_cart' => $cart->id_cart));
                                        if (!empty($Customization)) {
                                            $Customization->quantity = $Customization->quantity + $value['soluong'];
                                            $Customization->save();
                                        } else {
                                            $this->customizationSave($cart->id_cart, $value['id_sp'], $value['id_att'], $id_address_delivery, $value['soluong']);
                                        }
                                        // truy vấn lấy SpecificPriceRule
                                        $date = date('Y-m-d');
                                        $criteria_spe = new CDbCriteria();
                                        $criteria_spe->condition = "t.to>='$date' AND t.from<='$date'";
                                        $spe = SpecificPriceRule::model()->findAll($criteria_spe);
                                        $item = array();
                                        foreach ($spe as $value_spe) {
                                            $item[] = $value_spe->id_specific_price_rule;
                                        }
                                        $str = implode(",", $item);
                                        if ($str != '') {
                                            $criteria_hot = new CDbCriteria();
                                            $criteria_hot->addCondition('id_product=' . $value['id_sp'] . ' AND id_specific_price_rule in(' . $str . ')');
                                            $hot_deal = ProductHotDeal::model()->find($criteria_hot);

                                            if (!empty($hot_deal)) {
                                                $id_specific_price_rule = $hot_deal->id_specific_price_rule;
                                                $reduction = SpecificPriceRule::model()->findByPk($hot_deal->id_specific_price_rule);
                                                $reduction_type = $reduction->reduction_type;
                                                $reduction = $reduction->reduction;
                                            } else {
                                                $id_specific_price_rule = NULL;
                                                $reduction_type = 'amount';
                                                $reduction = 0;
                                            }
                                        } else {
                                            $id_specific_price_rule = NULL;
                                            $reduction_type = 'amount';
                                            $reduction = 0;
                                        }
                                        $specific_price = SpecificPrice::model()->findByAttributes(array('id_cart_rule' => NULL, 'id_cart' => $cart->id_cart, 'id_product' => $value['id_sp'], 'id_product_attribute' => $value['id_att']));
                                        if (!empty($specific_price)) {
                                            $specific_price->from_quantity = $specific_price->from_quantity + $value['soluong'];
                                            $specific_price->save();
                                        } else {
                                            $this->specificSave($id_specific_price_rule, $cart->id_cart, null, $value['id_sp'], $value['id_att'], $value['gia'], $value['soluong'], $reduction, $reduction_type);
                                        }
                                    }
                                    if (!empty($temp)) {
                                        foreach ($temp as $id_pr => $quantity) {
                                            $CartProduct = CartProduct::model()->findByPk(array('id_cart' => $cart->id_cart, 'id_product' => $id_pr));
                                            if (!empty($CartProduct)) {
                                                $CartProduct->quantity = $CartProduct->quantity + $quantity;
                                                $CartProduct->save();
                                            } else {
                                                $this->CartProductSave($cart->id_cart, $id_pr, $quantity, $id_address_delivery);
                                            }
                                        }
                                    }
                                }
                                if (!empty($data_pack)) {
                                    $temp_pack = array();
                                    foreach ($data_pack as $key => $data_value1) {
                                        foreach ($data_value1 as $value1) {
                                            if (isset($temp_pack[$value1['id_sp']])) {
                                                $temp_pack[$value1['id_sp']] = (int) $temp_pack[$value1['id_sp']] + (int) $value1['soluong'];
                                            } else {
                                                $temp_pack[$value1['id_sp']] = (int) $value1['soluong'];
                                            }
                                            $Customization = Customization::model()->findByAttributes(array('id_product' => $value1['id_sp'], 'id_product_attribute' => $value1['id_att'], 'id_cart' => $cart->id_cart));
                                            if (!empty($Customization)) {
                                                $Customization->quantity = $Customization->quantity + $value1['soluong'];
                                                $Customization->save();
                                            } else {
                                                $this->customizationSave($cart->id_cart, $value1['id_sp'], $value1['id_att'], $id_address_delivery, $value1['soluong']);
                                            }
                                            $product = Product::model()->findByPk($value1['id_sp']);
                                            if ($product->stock_management == 0) {
                                                $product_attribute = ProductAttribute::model()->findByAttributes(array('id_product' => $value1['id_sp'], 'id_product_attribute' => $value1['id_att']));
                                                if (!empty($product_attribute)) {
                                                    $product_attribute->quantity = $product_attribute->quantity - $value1['soluong'];
                                                    $product_attribute->save(FALSE);
                                                }
                                            }
                                            $pack_group = PackGroup::model()->findByPk($value1['id_pack_group']);
                                            $reduction_amount = 0;
                                            $reduction_percent = 0;
                                            $reduction = 0;
                                            if ($pack_group->reduction_type == 'amount') {
                                                $reduction = $value1['reduction'];
                                                $reduction_amount = $value1['reduction'];
                                            } elseif ($pack_group->reduction_type == 'percentage') {
                                                $reduction = $pack_group->reduction;
                                                $reduction_percent = $pack_group->reduction;
                                            }
                                            $CartRule = $this->CartRuleSave($value1['id_pack'], $reduction_percent, $reduction_amount, $value1['total_pack']);
                                            $this->CartCartRuleSave($cart->id_cart, $CartRule->id_cart_rule);
                                            $id_specific_price_rule = NULL;
                                            $specific_price_pack = SpecificPrice::model()->findByAttributes(array('id_cart' => $cart->id_cart, 'id_cart_rule' => $CartRule->id_cart_rule, 'id_product' => $value1['id_sp'], 'id_product_attribute' => $value1['id_att']));
                                            if (!empty($specific_price_pack)) {
                                                $specific_price_pack->from_quantity = $specific_price_pack->from_quantity + $value1['soluong'];
                                                $specific_price_pack->save();
                                            } else {
                                                $this->specificSave($id_specific_price_rule, $cart->id_cart, $CartRule->id_cart_rule, $value1['id_sp'], $value1['id_att'], $value1['gia'], $value1['soluong'], $reduction, $pack_group->reduction_type);
                                            }
                                        }
                                    }
                                    if (!empty($temp_pack)) {
                                        foreach ($temp_pack as $id_pr => $quantity) {
                                            $CartProduct = CartProduct::model()->findByPk(array('id_cart' => $cart->id_cart, 'id_product' => $id_pr));
                                            if (!empty($CartProduct)) {
                                                $CartProduct->quantity = $CartProduct->quantity + $quantity;
                                                $CartProduct->save();
                                            } else {
                                                $this->CartProductSave($cart->id_cart, $id_pr, $quantity, $id_address_delivery);
                                            }
                                        }
                                    }
                                }
                                $order = new Orders();
                                $order = $order->setCart($cart->id_cart);
                                $id_order = $order->getPrimaryKey();
                                $detail = OrderDetail::model()->findAllByAttributes(array('id_order' => $id_order));
                                $this->SaveStock($id_order);
                                $listpro = "";
                                foreach ($detail as $value) {
                                    $name = "";
                                    $SpecificPrice = SpecificPrice::model()->findByAttributes(array('id_cart' => $order->id_cart, 'id_product' => $value->id_product, 'id_product_attribute' => $value->id_product_attribute));
                                    if ($value->id_product_attribute != null) {
                                        $name = $value->idProductAttribute->fullname;
                                    } else {
                                        $name = $value->idProduct->name;
                                    }
                                    $listpro.="<tr>
                                    <td>" . $name . "</td>
                                    <td>" . $value->idProduct->description_short . "</td>
                                    <td>" . number_format($SpecificPrice->price) . "VND</td>
                                    <td>" . $value->quantity . "</td>
                                    <td>" . number_format($value->price) . "VND</td>
                                </tr>";
                                }
                                $message = new Message;
                                $message->id_customer = Yii::app()->user->id;
                                $message->id_cart = $cart->id_cart;
                                $message->id_order = $id_order;
                                $message->title = "Thông tin xác nhận giỏ hàng $order->secure_key tại qc-ngày " . date("h:i:sa d-,Y") . "";
                                $ms = "
                            <div style='border-radius:5px;border: 1px solid #a1a1a1;background:none repeat scroll 0% 0% rgba(255, 255, 255, 0.75);padding:15px'>
                            Kính chào " . Yii::app()->user->name . "<br>

                            Cám ơn quý khách đã mua hàng tại QCDN. <br>
                            Mã số đơn hàng của quý khách là:

                            #" . $order->secure_key . "
                            <br>
                            QCDN sẽ không thực hiện cuộc gọi xác nhận đơn hàng trừ khi cần làm rõ thêm thông tin với quý khách. Thời gian giao hàng cụ thể sẽ được thông báo qua email và tin nhắn qua tài khoản quý khách đã đăng ký.
                            <br>
                            Xin lưu ý: 
                            <br>
                            - Đơn hàng của quý khách có thể sẽ được giao thành nhiều lần nếu có sản phẩm được bán bởi các đơn vị Thương nhân khác nhau.
                            <br>
                            Mọi thắc mắc hoặc hỗ trợ khác, vui lòng để lại lời nhắn tại http://localhost/base/frontend/www/site/mail/.
                            <br>
                            Kính chúc quý khách những trải nghiệm mua sắm trực tuyến tuyệt vời nhất tại QCDN – kênh bán lẻ trực tuyến hàng đầu tại Việt Nam.
                            <br>
                            Trân trọng,
                            <br>
                            Đội ngũ QCDN.
                            <br>
                            Nếu không tìm thấy email thông báo trong hộp thư đến, quý khách vui lòng kiểm tra hộp thư spam.
                            <br>
                            Trở về trang chủ nhadatthuongmai.com<br>
                                <table style='border:1px solid #dee2e3;width:100%'>
                                <thead style='border:0px none;'>
                                    <tr>
                                        <td style='font-size:12px;font-family:Arial,Helvetica,sans-serif;background:#dceff5;font-weight:bold'>Tên sản phẩm</th>
                                        <td style='font-size:12px;font-family:Arial,Helvetica,sans-serif;background:#dceff5;font-weight:bold'>Thông tin</th>
                                        <td style='font-size:12px;font-family:Arial,Helvetica,sans-serif;background:#dceff5;font-weight:bold'>Giá</th>
                                        <td style='font-size:12px;font-family:Arial,Helvetica,sans-serif;background:#dceff5;font-weight:bold'>Số Lượng</th>
                                        <td style='font-size:12px;font-family:Arial,Helvetica,sans-serif;background:#dceff5;font-weight:bold'>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    " . $listpro . "
                                   <tr>
                                        <td colspan='3' valign='top' align='right' style='font-size:12px;font-family:Arial,Helvetica,sans-serif;font-weight:bold'>
                                            <div align='right'>phí thực hiện đơn hàng</div>
                                        </td>
                                        <td colspan='3' valign='top' colspan='2' style='font-size:12px;font-family:Arial,Helvetica,sans-serif'>
                                        " . number_format($order->total_paid_tax_excl) . "VND
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' valign='top' align='right' style='font-size:12px;font-family:Arial,Helvetica,sans-serif;font-weight:bold'>
                                            <div align='right'>phí vận chuyển</div>
                                        </td>
                                        <td valign='top' colspan='2' style='font-size:12px;font-family:Arial,Helvetica,sans-serif'>
                                        " . number_format($order->total_shipping_tax_incl) . "VND
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' valign='top' align='right' style='font-size:12px;font-family:Arial,Helvetica,sans-serif;font-weight:bold'>
                                            <div align='right'>Tổng cộng</div>
                                        </td>
                                        <td valign='top' colspan='2' style='font-size:12px;font-family:Arial,Helvetica,sans-serif'>
                                            " . number_format($order->total_paid_tax_excl) . "
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                                </div>
                            ";
                                $message->message = $ms;
                                $message->date_add = date("Y-m-d h:i:sa");
                                $message->date_upd = date("Y-m-d h:i:sa");
                                $message->save();
                                $this->sentEmail($message->getPrimaryKey());
                                $transaction->commit();
                                $this->UnsetSession();
                                if (isset($_POST['money'])) {
                                    $this->redirect(array('paypal/Success'));
                                }if (isset($_POST['payment'])) {
                                    $this->redirect(array('paypal/buy', 'id' => $id_order));
                                }if (isset($_POST['chuyenkhoan'])) {
                                    $bankorder = new BankOrder();
                                    $bankorder->id_bank = $_POST['bank'];
                                    $bankorder->id_order = $id_order;
                                    if ($bankorder->save()) {
                                        $this->redirect(array('paypal/Success','model' => $order->secure_key));
                                    } else {
                                        $erro = "lỗi khi thêm bank. vui lòng liên hệ để được giúp đỡ.";
                                        $this->redirect(array('cart/erro', 'erro' => $erro));
                                    }
                                }
                            }
                        }
                    } catch (Exception $exc) {
                        $transaction->rollback();
                        $erro = $exc->getMessage();
                        $this->UnsetSession();
                        $this->redirect(array('cart/erro', 'erro' => $erro));
                    }
                } else {
                    $this->UnsetSession();
                    $this->redirect(array('site/index'));
                }
            }
            if (isset($_POST['back_cart'])) {
                $this->redirect(array('cart/create'));
            }
            $post = Post::model()->findByPk(17);
            $data = isset(Yii::app()->session['cart']) ? Yii::app()->session['cart'] : null;
            $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $bank = Bank::model()->findAllByAttributes(array('active'=>'1'));
            $this->render('create_order', array(
                'post' => $post,
                'data' => $data,
                'bank' => $bank,
                'data_cart_pack' => $data_cart_pack
            ));
        } else {
            $this->redirect(array('site/index'));
        }
    }

    public function CartRuleSave($id_pack, $reduction_percent, $reduction_amount, $total) {
        $model = new CartRule();
        $model->id_pack = $id_pack;
        $model->reduction_percent = $reduction_percent;
        $model->reduction_amount = $reduction_amount;
        $model->id_customer = Yii::app()->user->id;
        $model->date_add = date("Y-m-d h:i:sa");
        $model->date_upd = date("Y-m-d h:i:sa");
        $model->active = 1;
        $model->total_pack = $total;
        $model->save();
        return $model;
    }

    public function SaveStock($id_order) {
        $order_detail = OrderDetail::model()->findAllByAttributes(array('id_order' => $id_order));
        foreach ($order_detail as $value):
            $product = Product::model()->findByPk($value->id_product);
            if ($product->stock_management == 1):
                $Stock = Stock::model()->findByAttributes(array('id_product' => $value->id_product, 'id_product_attribute' => $value->id_product_attribute));
                if (!empty($Stock)):
                    $StockMvt = StockMvt::model()->findByAttributes(array('id_stock' => $Stock->id_stock, 'id_order' => NULL));
                    $model = new StockMvt();
                    $model->id_stock = $Stock->id_stock;
                    $model->id_order = $id_order;
                    $model->physical_quantity = $value->quantity;
                    $model->date_add = date("Y-m-d h:i:sa");
                    $model->id_user = $StockMvt->id_user;
                    $model->id_stock_mvt_reason = 7;
                    $StockMvt->id_stock_mvt_reason = 6;
                    $StockMvt->physical_quantity = $StockMvt->physical_quantity - $value->quantity;
                    if ($StockMvt->save() && $model->save()) {
                        
                    } else {
                        echo 'bai';
                        exit();
                    }
                endif;
            endif;
        endforeach;
    }

    public function CartCartRuleSave($id_cart, $id_cart_rule) {
        $model = new CartCartRule();
        $model->id_cart = $id_cart;
        $model->id_cart_rule = $id_cart_rule;
        $model->save();
        return $model;
    }

    public function specificSave($id_specific_price_rule, $id_cart, $id_cart_rule, $id_product, $id_product_attribute, $price, $from_quantity, $reduction, $reduction_type) {

        $specific_price = new SpecificPrice();
        $specific_price->id_specific_price_rule = $id_specific_price_rule;
        $specific_price->id_cart = $id_cart;
        $specific_price->id_cart_rule = $id_cart_rule;
        $specific_price->id_product = $id_product;
        $specific_price->id_product_attribute = $id_product_attribute;
        $specific_price->id_customer = Yii::app()->user->id;
        $specific_price->price = $price;
        $specific_price->from_quantity = $from_quantity;
        $specific_price->reduction = $reduction;
        $specific_price->reduction_type = $reduction_type;
        $specific_price->from = date("Y-m-d h:i:sa");
        $specific_price->to = date("Y-m-d h:i:sa");
        if ($specific_price->save()) {
            return $specific_price;
        } else {
            dump($specific_price->errors);
            exit();
        }
    }

    public function customizationSave($id_cart, $id_product, $id_product_attribute, $id_address_delivery, $quantity) {

        $customization = new Customization();
        $customization->id_cart = $id_cart;
        $customization->id_product = $id_product;
        $customization->id_product_attribute = $id_product_attribute;
        $customization->id_address_delivery = $id_address_delivery;
        $customization->quantity = $quantity;
        $customization->in_cart = 1;
        $customization->save();
    }

    public function CartSave($id_address_delivery, $id_address_invoice) {

        $modelcart = new Cart;
        $modelcart->id_store = Yii::app()->session['id_store'];
        $modelcart->id_address_delivery = $id_address_delivery;
        $modelcart->id_address_invoice = $id_address_invoice;
        $modelcart->id_guest = Yii::app()->session['id_client'];
        $modelcart->id_customer = Yii::app()->user->id;
        $modelcart->id_carrier = isset(Yii::app()->session['id_carrier']) ? Yii::app()->session['id_carrier'] : 1;
        $modelcart->date_upd = getdate();
        $modelcart->date_add = getdate();
        if ($modelcart->save()) {
            return $modelcart;
        } else {
            dump($modelcart->errors);
            exit();
        }
    }

    public function CartProductSave($id_cart, $id_product, $quantity, $id_address_delivery) {

        $cart_product = new CartProduct();
        $cart_product->id_cart = $id_cart;
        $cart_product->id_product = $id_product;
        $cart_product->quantity = $quantity;
        $cart_product->date_add = date("Y-m-d h:i:sa");
        $cart_product->id_address_delivery = $id_address_delivery;
        $cart_product->save();
        return $cart_product;
    }

    public function actionErro() {
        $this->layout = "//layouts/content8";
        $erro = isset($_GET['erro']) ? $_GET['erro'] : '';
        $this->render('erro', array('erro' => $erro));
    }

    public function actionDeletecart() {
        if (Yii::app()->request->isAjaxRequest) {
            $key = Yii::app()->getRequest()->getParam('key', null);
            $cart = Yii::app()->session['cart'];
            unset($cart[$key]);
            Yii::app()->session['cart'] = $cart;
            $data = $cart;
            $data_cart_pack = isset(Yii::app()->session['cart_pack']) ? Yii::app()->session['cart_pack'] : null;
            $this->renderpartial("_viewpro", array('data' => $data, 'data_cart_pack' => $data_cart_pack), FALSE, true);
            Yii::app()->end();
        }
    }

    public function address_deliverySave($model) {
        $model->fullname = addslashes(Yii::app()->session['address1']['fullname']);
        $model->company = addslashes(Yii::app()->session['address1']['company']);
        $model->address1 = addslashes(Yii::app()->session['address1']['address1']);
        $model->phone = addslashes(Yii::app()->session['address1']['phone']);
        $model->mobile = addslashes(Yii::app()->session['address1']['mobile']);
        $model->id_store = Yii::app()->session['id_store'];
        $model->id_city = Yii::app()->session['address1']['id_city'];
        $model->id_zone = Yii::app()->session['address1']['id_zone'];
        $model->save();
        return $model;
    }

    public function address_invoiceSave($model1) {
        $model1->fullname = addslashes(Yii::app()->session['address2']['fullname']);
        $model1->company = addslashes(Yii::app()->session['address2']['company']);
        $model1->id_store = Yii::app()->session['id_store'];
        $model1->address1 = addslashes(Yii::app()->session['address2']['address1']);
        $model1->phone = addslashes(Yii::app()->session['address2']['phone']);
        $model1->mobile = addslashes(Yii::app()->session['address2']['mobile']);
        $model1->id_city = addslashes(Yii::app()->session['address2']['id_city']);
        $model1->id_zone = Yii::app()->session['address2']['id_zone'];
        $model1->save();
        return $model1;
    }

    public function UnsetSession() {
        unset(Yii::app()->session['address1']);
        unset(Yii::app()->session['address2']);
        unset(Yii::app()->session['cart']);
        unset(Yii::app()->session['id_carrier']);
        unset(Yii::app()->session['cart_pack']);
        unset(Yii::app()->session['count']);
    }

    public function SentEmail($id = null) {
        $model = Message::model()->findByPk($id);
        if (($model !== null) && ($cus = Customer::model()->findByPk($model->id_customer))) {
            $dcus = Detail::model()->findByAttributes(array('id_customer' => $cus->id_customer));
            $body = $model->message;
            try {
                $config = array(
                    'host' => Yii::app()->params["host"],
                    'auth' => Yii::app()->params["auth"],
                    'username' => Yii::app()->params["email"],
                    'password' => Yii::app()->params["password"],
                    'ssl' => Yii::app()->params["ssl"],
                    'port' => Yii::app()->params["port"]
                );
                //dump($config);exit();
                $transport = new Zend_Mail_Transport_Smtp(Yii::app()->params["host"], $config);
                Zend_Mail::setDefaultTransport($transport);
                Zend_Mail::setDefaultFrom(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail = new Zend_Mail('utf-8');
                $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
                $mail->setReplyTo(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail->setFrom(Yii::app()->params["email"], Yii::app()->params["name"]);

                $mail->addTo($cus->email, ($dcus !== null) ? $dcus->firstname . " " . $dcus->lastname : $cus->username );
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

                $mail->setSubject($model->title);
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
                Yii::app()->user->setFlash('success', '<strong>Thông tin đã được gửi thành công! </strong>');
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
            }
        } else {
            Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong>');
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cart-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
