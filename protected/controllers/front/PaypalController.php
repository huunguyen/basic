<?php

class PaypalController extends Controller {
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('confirm','sentEmail', 'cancel', 'buy', 'success'),
                'users' => array('@'),
            ),
        );
    }

    public function actionConfirm() {
        $this->layout = "//layouts/content8";
        $token = trim($_GET['token']);
        $payerId = trim($_GET['PayerID']);
        $key = trim($_GET['key']);

        $result = Yii::app()->Paypal->GetExpressCheckoutDetails($token);
        $result['PAYERID'] = $payerId;
        $result['TOKEN'] = $token;
        $order = Orders::model()->findByAttributes(array(
            'secure_key' => $key
        ));
        $result['ORDERTOTAL'] = round((empty($order) ? 0 : $order->total_paid) / FinanceHelper::USDvsVND, 2);

        $result['ITEMAMT'] = round((empty($order) ? 0 : $order->total_paid) / FinanceHelper::USDvsVND, 2);
        $result['TAXAMT'] = round($result['ITEMAMT'] * FinanceHelper::TAXAMT, 2);
        $result['SHIPPINGAMT'] = FinanceHelper::SHIPPINGAMT;

        if ($result['ORDERTOTAL'] != 0) {
            $result['ORDERTOTAL'] = $result['ORDERTOTAL'] + round($result['ORDERTOTAL'] * FinanceHelper::TAXAMT, 2) + FinanceHelper::SHIPPINGAMT;
        }
        //Detect errors 
        if (empty($order) || (!Yii::app()->Paypal->isCallSucceeded($result))) {
            if (Yii::app()->Paypal->apiLive === true) {
                //Live mode basic error message
                $error = 'Xin lỗi!Chúng tôi không thể xử lý đơn hàng này. Vui lòng cố gắng lại lần sau!';
            } else {
                $error = 'Chúng tôi không thể xử lý đơn hàng này. Vui lòng cố gắng lại lần sau!(Sandbox mode)';
            }
            $this->render('fail', array('error' => $error));
            Yii::app()->end();
        } else {
            Yii::app()->user->setState('after-result', $result);
            $paymentResult = Yii::app()->Paypal->DoExpressCheckoutPayment($result);
            Yii::app()->user->setState('last-result', $paymentResult);
            //Detect errors  
            if (!Yii::app()->Paypal->isCallSucceeded($paymentResult)) {
                if (Yii::app()->Paypal->apiLive === true) {
                    //Live mode basic error message
                    $order->updateByPk($order->id_order, array('current_state' => 23, 'secure_key' => $order->secure_key));
                    $error = 'Xin lỗi!Chúng tôi không thể xử lý đơn hàng này. Vui lòng cố gắng lại lần sau!';
                } else {
                    $order->updateByPk($order->id_order, array('current_state' => 23, 'secure_key' => $order->secure_key));
                    $error = 'Chúng tôi không thể xử lý đơn hàng này. Vui lòng cố gắng lại lần sau!(Sandbox mode)';
                }
                $this->render('fail', array('error' => $error));
                Yii::app()->end();
            } else {
                //payment was completed successfully
                $order->updateByPk($order->id_order, array('current_state' => 5, 'secure_key' => $order->secure_key, 'payment' => $payerId));
                $message = new Message;
                $message->id_customer = Yii::app()->user->id;
                $message->id_cart = $order->id_cart;
                $message->id_order = $order->id_order;
                $message->title = "Thông tin xác nhận mua hàng tại qcdn";
                $ms="
                            Kính chào ".Yii::app()->user->name."

                            Cám ơn quý khách đã mua hàng tại QCDN. Mã số đơn hàng của quý khách là:<br>

                            #".$order->getPrimaryKey()."
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
                            Trở về trang chủ nhadatthuongmai.com  
                            ";
                $message->message =$ms;
                $message->date_add = date("Y-m-d h:i:sa");
                $message->date_upd = date("Y-m-d h:i:sa");
                $message->save();
                $this->sentEmail($message->getPrimaryKey());
                $this->render('confirm');
            }
        }
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
                //$mail->addCc(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail->addBcc(Yii::app()->params["email"], Yii::app()->params["name"]);

                $mail->addTo($cus->email, ($dcus !== null) ? $dcus->firstname . " " . $dcus->lastname : $cus->username );
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

                $mail->setSubject($model->title);
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
                Yii::app()->user->setFlash('success', '<strong>Thông tin đã được gửi thành công! </strong>');
            }catch (Exception $e) {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
               
            }
        } else {
            Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong>');
        }
    }
    
    public function actionCancel() {
        //The token of the cancelled payment typically used to cancel the payment within your application
        $token = $_GET['token'];
        $key = trim($_GET['key']);
        $order = Orders::model()->findByAttributes(array(
            'secure_key' => $key
        ));
        $order->updateByPk($order->id_order, array('current_state' =>23, 'secure_key' => $order->secure_key));
        $this->render('cancel');
    }

    public function actionBuy($id = null) {
            $order = Orders::model()->findByPk($id);
            if ($order->current_state ==4||$order->current_state ==3) {
                $paymentInfo['Order']['theTotal'] = round($order->total_paid_real / FinanceHelper::USDvsVND);
                $paymentInfo['Order']['description'] = "Nội dung thanh toán:<br/> ";
                $paymentInfo['Order']['quantity'] = '1';
                $paymentInfo['Order']['paymentkey'] = $order->secure_key;
                $result = Yii::app()->Paypal->SetExpressCheckout($paymentInfo);
                Yii::app()->user->setState('before-result', $result);
                //Detect Errors 
                if (!Yii::app()->Paypal->isCallSucceeded($result)) {
                    if (Yii::app()->Paypal->apiLive === true) {
                        $error = 'Xin lỗi!Chúng tôi không thể xử lý đơn hàng này. Vui lòng cố gắng lại lần sau!';
                        $order->updateByPk($order->id_order, array('current_state' => 23, 'secure_key' => $order->secure_key));
                    } else {
                        $error = 'Chúng tôi không thể xử lý đơn hàng này. Vui lòng cố gắng lại lần sau!(Sandbox mode)' . $result['L_LONGMESSAGE0'];
                        $order->updateByPk($order->id_order, array('current_state' => 23, 'secure_key' => $order->secure_key));
                    }
                    $this->render('fail', array('error' => $error));
                    Yii::app()->end();
                } else {
                    $order->updateByPk($order->id_order, array('current_state' =>3, 'secure_key' => $order->secure_key));
                    // send user to paypal 
                    $token = urldecode($result["TOKEN"]);

                    $payPalURL = Yii::app()->Paypal->paypalUrl . $token;
                    $this->redirect($payPalURL);
                }
            } else {
                $error = 'Chúng tôi không thể xử lý đơn hàng này. Do đơn hàng này đã ở trạng thái đang hoặc đã thanh toán!';
                $this->render('fail', array('error' => $error));
                Yii::app()->end();
            }
    }

    public function actionSuccess() {
        $this->layout = "//layouts/content8";
        $this->render('success');
    }

}
