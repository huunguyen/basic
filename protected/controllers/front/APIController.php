<?php

//Yii::import("common.vendors.Classes.PHPExcel", true);
class APIController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'payments';

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('success', 'fail', 'verify', 'fancy', 'openExcel', 'downloadExcel'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'payment', 'payments', 'updateTotal', 'sumTotal', 'ajaxPayments', 'books', 'index', 'view', 'viewbooks', 'resGoogle', 'reqGoogle', 'oAuthGoogle', 'authGoogle', 'sentEmail', 'sendEmail', 'receiverEmail', 'smtpGoogle', 'imapGoogle', 'export', 'exportBook', 'exportBooks', 'exportPayment', 'exportPayments', 'delExcel'),
                'users' => array('admin'),
            ),
            array('allow',
                'actions' => array('admin', 'delete'),
                'users' => array('supper'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }



   
   public function actionSentEmail($id=null, $m=null) {
        $id = Yii::app()->getRequest()->getParam('id', $id);
        $m = Yii::app()->getRequest()->getParam('m', $m);        
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_Oauth2Service.php');
        require_once (Yii::getPathOfAlias('common.lib') . '/common.php');
        $client = new Google_Client();
        $client->setApplicationName('Google Verification Email');
        $client->setClientId('563886264634-miscapglb30i5lh7cbtockp25p99bjm4.apps.googleusercontent.com');
        $client->setClientSecret('4CPh0AmVgI3Eo-RshtxMGRei');
        $client->setRedirectUri(YII_DEBUG ? 'http://localhost/admin/payment/sentEmail' : 'http://nhadatthuongmai.com/admin/payment/sentEmail');
        $client->setDeveloperKey('AIzaSyCGPfWuFYVBuju6qqPH1fMY8ONmOIS1_EU');
        $client->setScopes('https://mail.google.com');
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        
        if( !is_null($id) & !is_null($m) ){
            $_SESSION['id'] = $id;
            $_SESSION['m'] = $m;
            $client->setState(CJSON::encode(array($_SESSION['id'],$_SESSION['m'])));
        }        
        $oauth2 = new Google_Oauth2Service($client);
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $client->authenticate($code);
            $_SESSION['token'] = $client->getAccessToken();
            header(YII_DEBUG ? 'Location: http://localhost/admin/payment/sentEmail' : 'Location: http://nhadatthuongmai.com/admin/payment/sentEmail');
            Yii::app()->end();
        } 
        elseif (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
            if(extension_loaded('apc') && ini_get('apc.enabled')){
                Yii::app()->cache->set('qcdn.master',$client->getAccessToken(),60*60*24*365);
            }            
        }
        elseif ((extension_loaded('apc') && ini_get('apc.enabled')) && ($cache_key = Yii::app()->cache->get('qcdn.master'))) {            
            $client->setAccessToken($cache_key);
            $tokenObj = CJSON::decode($cache_key);
            if($client->isAccessTokenExpired()) {
                $tokenObj = CJSON::decode($cache_key);
                var_dump($cache_key);var_dump($tokenObj);
                try {
                    $url = 'https://accounts.google.com/o/oauth2/token';
                    $params = array(
                        "refresh_token" => $tokenObj['refresh_token'],
                        "client_id" => "563886264634-miscapglb30i5lh7cbtockp25p99bjm4.apps.googleusercontent.com",
                        "grant_type"=>"refresh_token",
                        "client_secret"=>"4CPh0AmVgI3Eo-RshtxMGRei",
                    );
                    $output = CJSON::decode(Yii::app()->curl->post($url, $params));                    
                    if(isset($output['error'])){
                        throw new CHttpException(400, '400 - HTTPBadRequest. Please do not repeat this request again.');
                    }
                    $tokenObj['access_token'] = $output['access_token'];
                    $tokenObj = CJSON::encode($tokenObj);
                    $client->setAccessToken($tokenObj);
                } catch (Exception $exc) {
                    $client->authenticate();
                    Yii::app()->end();
                }
                $_SESSION['token'] = $client->getAccessToken();
                Yii::app()->cache->set('qcdn.master',$_SESSION['token'],60*60*24*365);
            }
            else
                $_SESSION['token'] = $cache_key;
        } 
         else {
            $client->authenticate();
            Yii::app()->end();
        }
        
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['token']);
            $client->revokeToken();
            Yii::app()->end();
        }
        
        if ( isset($_SESSION['token']) & isset($_SESSION['id']) & isset($_SESSION['m'])) {
            //restore id & m
            $id = $_SESSION['id'];
            $m = $_SESSION['m'];
            if(isset($_SESSION['status_id_m'.$_SESSION['id'].$_SESSION['m']]) && $_SESSION['status_id_m'.$_SESSION['id'].$_SESSION['m']]){
                Yii::app()->user->setFlash('error', '<strong>Lỗi! </strong>Thông tin đã được gửi đến người dùng rồi!');
                $this->redirect(array('payment/books'));
                Yii::app()->end();
            }
            if (!is_null($id) && ($m == 'b')) {
                $b = Books::model()->findByPk($id);
                $body = 'Thông tin Giỏ Hàng<br/>';
                $body .= $b->paymentkey . '<br/>';
                $body .= $b->description . '<br/>';
                $body .= $b->status . '<br/>';
                $body .= $b->paymentkey . '<br/>';
                $body .= $b->totalofmoney . '<br/>';
                $body .= 'Ngày bắt đầu thanh toán: ' . $b->start_date_payment . ' Ngày kết thúc thanh toán: ' . $b->end_date_payment . '<br/>';
                $body .= $b->info . '<br/>';
                //var_dump($b);
            } elseif (!is_null($id) && ($m == 'p')) {
                $p = Payment::model()->findByPk($id);
                $b = Books::model()->findByPk($p->books_id);
                $body = 'Thông tin Giỏ Hàng<br/>';
                $body .= $b->paymentkey . '<br/>';
                $body .= $b->description . '<br/>';
                $body .= $b->status . '<br/>';
                $body .= $b->paymentkey . '<br/>';
                $body .= $b->totalofmoney . '<br/>';
                $body .= 'Ngày bắt đầu thanh toán: ' . $b->start_date_payment . ' Ngày kết thúc thanh toán: ' . $b->end_date_payment . '<br/>';
                $body .= $b->info . '<br/>';
                // Thông tin thanh toán
                $body .= 'Thông tin Thanh Toán<br/>';
                $body .= $p->payerid . '<br/>';
                $body .= $p->money_total . '<br/>';
                $body .= $p->payment_date . '<br/>';
                $body .= $p->methodsofpayment . '<br/>';
                //var_dump($p);var_dump($b);
            } else {
                throw new CHttpException(412, 'HTTPPreconditionFailed. Please do not repeat this request again.');
                exit();
            }
            $u = User::model()->findByPk($b->custommer_id);
            try {
                $config = array(
                    'host' => 'smtp.gmail.com',
                    'auth' => 'login',
                    'username' => 'qcdn.master@gmail.com',
                    'password' => '@dm!n1978',
                    'ssl' => 'tls',
                    'port' => 587
                );
                $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
                Zend_Mail::setDefaultTransport($transport);
                Zend_Mail::setDefaultFrom('qcdn.master@gmail.com', 'Cao Quang');
                $mail = new Zend_Mail('utf-8');
                $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
                $mail->setReplyTo('qcdn.master@gmail.com', 'qcdn.master');
                $mail->setFrom('qcdn.master@gmail.com', 'Cao Quang');
                $mail->addCc('nguyen@4sao.com', 'Nguyen 4Sao.Com');
                $mail->addBcc('guitinhtho@gmail.com', 'Gui Tinh Tho');
                $mail->addTo($u->email, isset($u->author_name) ? $u->author_name : $u->username );
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

                $mail->setSubject(isset($p) ? 'Thông tin thanh toán: giỏ hàng' . $b->paymentkey : 'Thông tin giỏ hàng: ' . $b->paymentkey );
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
                // deleted session
                $_SESSION['status_id_m'.$_SESSION['id'].$_SESSION['m']] = true;
                unset($_SESSION['id']);
                unset($_SESSION['m']);
            } catch (Exception $e) {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.' . $e->getMessage());
                exit();
            }
            if (isset($p) || isset($b)) {
                $this->render('sendmail', array(
                    'model' => isset($p) ? $p : $b,
                    'status' => true
                ));
            } else {
                $this->render('sendmail', array(
                    'status' => false
                ));
            }
        } else {
            $this->redirect(array('payment/books'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Payment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

 
    /**
     * Builds an OAuth2 authentication string for the given email address and access
     * token.
     */
    public function constructAuthString($email, $accessToken) {
        return base64_encode("user=$email\1auth=Bearer $accessToken\1\1");
    }

    /**
     * Given an open IMAP connection, attempts to authenticate with OAuth2.
     *
     * $imap is an open IMAP connection.
     * $email is a Gmail address.
     * $accessToken is a valid OAuth 2.0 access token for the given email address.
     *
     * Returns true on successful authentication, false otherwise.
     */
    public function oauth2Authenticate($imap, $email, $accessToken) {
        try {
            $authenticateParams = array('XOAUTH2',
                $this->constructAuthString($email, $accessToken));
            $imap->sendRequest('AUTHENTICATE', $authenticateParams);
            while (true) {
                $response = "";
                $is_plus = $imap->readLine($response, '+', true);
                if ($is_plus) {
                    error_log("got an extra server challenge: $response");
                    // Send empty client response.
                    $imap->sendRequest('');
                } else {
                    if (preg_match('/^NO /i', $response) ||
                            preg_match('/^BAD /i', $response)) {
                        error_log("got failure response: $response");
                        return false;
                    } else if (preg_match("/^OK /i", $response)) {
                        return true;
                    } else {
                        // Some untagged response, such as CAPABILITY
                    }
                }
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

// Request Google
    public function actionReqGoogle() {
        $url = "https://accounts.google.com/o/oauth2/auth";
        $params = array(
            "response_type" => "code",
            "client_id" => "563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com",
            "redirect_uri" => "http://localhost/admin/payment/resGoogle",
            "scope" => "https://www.googleapis.com/auth/plus.me",
            "login_hint" => "qcdn.master@gmail.com"
        );
        $request_to = $url . '?' . http_build_query($params);
        header("Location: " . $request_to);
    }

    public function actionRequestGoogle() {
        $url = "https://accounts.google.com/o/oauth2/auth";
        $params = array(
            "response_type" => "code",
            "client_id" => "563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com",
            "redirect_uri" => "http://localhost/admin/payment/resGoogle",
            "scope" => "https://www.googleapis.com/auth/plus.me",
            "approval_prompt" => "auto",
            "login_hint" => "qcdn.master@gmail.com"
        );
        $request_to = $url . '?' . http_build_query($params);
        header("Location: " . $request_to);
    }

// response Google
    public function actionResGoogle() {
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_PlusService.php');
        $client = new Google_Client();
        $client->setApplicationName("Google+ PHP Starter Application");
        $client->setClientId('563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com');
        $client->setClientSecret('KomfbIKZbZ5oxUPHr5KOqs8i');
        $client->setRedirectUri('http://localhost/admin/payment/resGoogle');
        $client->setDeveloperKey('AIzaSyBdnMcTvjBGuJnPvmaIaawfchKzOR6WjR0');
        $plus = new Google_PlusService($client);
        if (isset($_GET['logout'])) {
            unset($_SESSION['access_token']);
        }
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: http://localhost/admin/payment/resGoogle');
        }
        if (isset($_SESSION['access_token'])) {
            $client->setAccessToken($_SESSION['access_token']);
        }
        if ($client->getAccessToken()) {
            $me = $plus->people->get('me');
            $url = filter_var($me['url'], FILTER_VALIDATE_URL);
            $img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
            $name = filter_var($me['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
            $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

            $optParams = array('maxResults' => 100);
            $activities = $plus->activities->listActivities('me', 'public', $optParams);
            $activityMarkup = '';
            foreach ($activities['items'] as $activity) {
                $url = filter_var($activity['url'], FILTER_VALIDATE_URL);
                $title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
            }

            $_SESSION['access_token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
        }
        /* if (isset($_GET['code'])) {
          // try to get an access token
          $code = $_GET['code'];
          $client->authenticate($_GET['code']);
          $url = 'https://accounts.google.com/o/oauth2/token';
          $params = array(
          "code" => $code,
          "client_id" => "563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com",
          "client_secret" => "KomfbIKZbZ5oxUPHr5KOqs8i",
          "redirect_uri" => "http://localhost/admin/payment/resGoogle",
          "grant_type" => "authorization_code"
          );

          $_SESSION['access_token'] = $client->getAccessToken();
          // Goi den server
          //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          // or
          $output = Yii::app()->curl->post($url, $params);
          //nhan gia tri tra ve?????


          $responseObj = CJSON::decode($output);
          $email = 'qcdn.master@gmail.com';
          $accessToken = null;

          if (isset($responseObj) && isset($responseObj['access_token'])) {
          $accessToken = $_SESSION['access_token'] = $responseObj['access_token'];
          $id_token = $_SESSION['id_token'] = $responseObj['id_token'];
          }
          if ($email && $accessToken) {
          $imap = new Zend_Mail_Protocol_Imap('imap.gmail.com', '993', true);
          if ($this->oauth2Authenticate($imap, $email, $accessToken)) {
          echo '<h1>Successfully authenticated!</h1>';
          //$this->showInbox($imap);
          } else {
          echo '<h1>Failed to login</h1>';
          }
          }
          if ($client->getAccessToken()) {
          $me = $plus->people->get('me');

          // These fields are currently filtered through the PHP sanitize filters.
          // See http://www.php.net/manual/en/filter.filters.sanitize.php
          $url = filter_var($me['url'], FILTER_VALIDATE_URL);
          $img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
          $name = filter_var($me['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
          $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

          $optParams = array('maxResults' => 100);
          $activities = $plus->activities->listActivities('me', 'public', $optParams);
          $activityMarkup = '';
          foreach ($activities['items'] as $activity) {
          // These fields are currently filtered through the PHP sanitize filters.
          // See http://www.php.net/manual/en/filter.filters.sanitize.php
          $url = filter_var($activity['url'], FILTER_VALIDATE_URL);
          $title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
          $content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
          $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
          }

          // The access token may have been updated lazily.
          $_SESSION['access_token'] = $client->getAccessToken();
          } else {
          $authUrl = $client->createAuthUrl();
          }
          var_dump($output);
          } */
        ?>
        <!doctype html>
        <html>
            <head>
                <meta charset="utf-8">
            <body>
                <header><h1>Google+ App</h1></header>
                <div class="box">

                    <?php if (isset($personMarkup)): ?>
                        <div class="me"><?php print $personMarkup ?></div>
                    <?php endif ?>

                    <?php if (isset($activityMarkup)): ?>
                        <div class="activities">Your Activities: <?php print $activityMarkup ?></div>
                    <?php endif ?>
                    <?php
                    if (!isset($authUrl)) {
                        print_r($me);
                        print "<a class='logout' href='?logout'>Logout</a>";
                    } else {
                        print "<a class='login' id='g_pop' href='$authUrl'>Connect Me!</a>";
                    }
                    ?>
                </div>
            </body>
        </html>
        <?php
    }

    public function actionResponseGoogle() {
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_PlusService.php');
        $client = new Google_Client();
        $client->setApplicationName("Google+ PHP Starter Application");
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
        $client->setClientId('563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com');
        $client->setClientSecret('KomfbIKZbZ5oxUPHr5KOqs8i');
        $client->setRedirectUri('http://localhost/admin/payment/resGoogle');
        $client->setDeveloperKey('AIzaSyBdnMcTvjBGuJnPvmaIaawfchKzOR6WjR0');
        $plus = new Google_PlusService($client);
        if (isset($_GET['logout'])) {
            unset($_SESSION['access_token']);
        }
        if (isset($_GET['code'])) {
            // try to get an access token
            $code = $_GET['code'];
            $client->authenticate($code);
            $url = 'https://accounts.google.com/o/oauth2/token';
            $params = array(
                "code" => $code,
                "client_id" => "563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com",
                "client_secret" => "KomfbIKZbZ5oxUPHr5KOqs8i",
                "redirect_uri" => "http://localhost/admin/payment/resGoogle",
                "grant_type" => "authorization_code"
            );

            $_SESSION['access_token'] = $client->getAccessToken();
            // Goi den server
            //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);            
            $output = Yii::app()->curl->post($url, $params);
            //nhan gia tri tra ve?????
            if (isset($_SESSION['access_token'])) {
                $client->setAccessToken($_SESSION['access_token']);
            }
            $responseObj = CJSON::decode($output);
            $email = 'qcdn.master@gmail.com';
            $accessToken = null;

            if (isset($responseObj) && isset($responseObj['access_token'])) {
                $accessToken = $_SESSION['access_token'] = $responseObj['access_token'];
                $id_token = $_SESSION['id_token'] = $responseObj['id_token'];
            }
            if ($email && $accessToken) {
                $imap = new Zend_Mail_Protocol_Imap('imap.gmail.com', '993', true);
                if ($this->oauth2Authenticate($imap, $email, $accessToken)) {
                    echo '<h1>Successfully authenticated!</h1>';
                    //$this->showInbox($imap);
                } else {
                    echo '<h1>Failed to login</h1>';
                }
            }
            if ($client->getAccessToken()) {
                $me = $plus->people->get('me');

                // These fields are currently filtered through the PHP sanitize filters.
                // See http://www.php.net/manual/en/filter.filters.sanitize.php
                $url = filter_var($me['url'], FILTER_VALIDATE_URL);
                $img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
                $name = filter_var($me['displayName'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

                $optParams = array('maxResults' => 100);
                $activities = $plus->activities->listActivities('me', 'public', $optParams);
                $activityMarkup = '';
                foreach ($activities['items'] as $activity) {
                    // These fields are currently filtered through the PHP sanitize filters.
                    // See http://www.php.net/manual/en/filter.filters.sanitize.php
                    $url = filter_var($activity['url'], FILTER_VALIDATE_URL);
                    $title = filter_var($activity['title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                    $content = filter_var($activity['object']['content'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                    $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
                }

                // The access token may have been updated lazily.
                $_SESSION['access_token'] = $client->getAccessToken();
            } else {
                $authUrl = $client->createAuthUrl();
            }
            var_dump($output);
        }
        if (isset($authUrl)) {
            //print "<a class='login' href='$authUrl'>Connect Me!</a>";
            Yii::app()->request->redirect($authUrl);
        } else {
            print "<a class='logout' href='?logout'>Logout</a>";
        }
    }

    public function actionOAuthGoogle() {
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_Oauth2Service.php');
        require_once (Yii::getPathOfAlias('common.lib') . '/common.php');
        $client = new Google_Client();
        $client->setApplicationName('Google UserInfo');
        $client->setClientId('563886264634-12dootcsbvgpi4s7lche6s9f1351qv2i.apps.googleusercontent.com');
        $client->setClientSecret('8NaMudyejVNCBUuwY5bmPaI-');
        $client->setRedirectUri('http://localhost/admin/payment/oAuthGoogle');
        $client->setDeveloperKey('AIzaSyCGPfWuFYVBuju6qqPH1fMY8ONmOIS1_EU');
        //$client->setScopes('https://mail.google.com');
        $oauth2 = new Google_Oauth2Service($client);

        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $client->authenticate($code);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: http://localhost/admin/payment/oAuthGoogle');
            Yii::app()->end();
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['token']);
            $client->revokeToken();
        }
        if ($client->getAccessToken()) {
            $user = $oauth2->userinfo->get();

            // These fields are currently filtered through the PHP sanitize filters.
            // See http://www.php.net/manual/en/filter.filters.sanitize.php
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
            $personMarkup = "$email<div><img src='$img?sz=50'></div>";

            // We're not done yet. Remember to update the cached access token.
            // Remember to replace $_SESSION with a real database or memcached.
            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
        }
        ?>
        <!doctype html>
        <html>
            <head><meta charset="utf-8"></head>
            <body>
                <header><h1>Google UserInfo</h1></header>
                <?php if (isset($personMarkup)): ?>
                    <?php print $personMarkup ?>
                <?php endif ?>
                <?php
                if (isset($authUrl)) {
                    print "<a class='login' href='$authUrl'>Connect Me!</a>";
                } else {
                    print "<a class='logout' href='?logout'>Logout</a>";
                    if ($email && $_SESSION['token']) {
                        /**
                         * Setup OAuth
                         */
                        $options = array(
                            'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER,
                            'version' => '1.0',
                            'consumerKey' => $THREE_LEGGED_CONSUMER_KEY,
                            'callbackUrl' => 'http://localhost/admin/payment/oAuthGoogle',
                            'requestTokenUrl' => 'https://www.google.com/accounts/OAuthGetRequestToken',
                            'userAuthorizationUrl' => 'https://www.google.com/accounts/OAuthAuthorizeToken',
                            'accessTokenUrl' => 'https://www.google.com/accounts/OAuthGetAccessToken'
                        );

                        if ($THREE_LEGGED_SIGNATURE_METHOD == 'RSA-SHA1') {
                            $options['signatureMethod'] = 'RSA-SHA1';
                            $options['consumerSecret'] = new Zend_Crypt_Rsa_Key_Private(
                                    file_get_contents(realpath($THREE_LEGGED_RSA_PRIVATE_KEY)));
                        } else {
                            $options['signatureMethod'] = 'HMAC-SHA1';
                            $options['consumerSecret'] = $THREE_LEGGED_CONSUMER_SECRET_HMAC;
                        }
                        var_dump($options);
                        $consumer = new Zend_Oauth_Consumer($options);
                        if (!isset($_SESSION['ACCESS_TOKEN'])) {
                            if (!isset($_SESSION['REQUEST_TOKEN'])) {
                                // Get Request Token and redirect to Google
                                $_SESSION['REQUEST_TOKEN'] = serialize($consumer->getRequestToken(array('scope' => implode(' ', $THREE_LEGGED_SCOPES))));
                                $consumer->redirect();
                            } else {
                                // Have Request Token already, Get Access Token
                                $_SESSION['ACCESS_TOKEN'] = serialize($consumer->getAccessToken($_GET, unserialize($_SESSION['REQUEST_TOKEN'])));
                                header('Location: ' . getCurrentUrl(false));
                                exit;
                            }
                        } else {
                            // Retrieve mail using Access Token
                            $accessToken = unserialize($_SESSION['ACCESS_TOKEN']);
                            $config = new Zend_Oauth_Config();
                            $config->setOptions($options);
                            $config->setToken($accessToken);
                            $config->setRequestMethod('GET');
                            $url = 'https://mail.google.com/mail/b/' . $email . '/imap/';

                            $httpUtility = new Zend_Oauth_Http_Utility();

                            /**
                             * Get an unsorted array of oauth params,
                             * including the signature based off those params.
                             */
                            $params = $httpUtility->assembleParams($url, $config);

                            /**
                             * Sort parameters based on their names, as required
                             * by OAuth.
                             */
                            ksort($params);

                            /**
                             * Construct a comma-deliminated,ordered,quoted list of 
                             * OAuth params as required by XOAUTH.
                             * 
                             * Example: oauth_param1="foo",oauth_param2="bar"
                             */
                            $first = true;
                            $oauthParams = '';
                            foreach ($params as $key => $value) {
                                // only include standard oauth params
                                if (strpos($key, 'oauth_') === 0) {
                                    if (!$first) {
                                        $oauthParams .= ',';
                                    }
                                    $oauthParams .= $key . '="' . urlencode($value) . '"';
                                    $first = false;
                                }
                            }

                            /**
                             * Generate SASL client request, using base64 encoded 
                             * OAuth params
                             */
                            $initClientRequest = 'GET ' . $url . ' ' . $oauthParams;
                            $initClientRequestEncoded = base64_encode($initClientRequest);

                            /**
                             * Make the IMAP connection and send the auth request
                             */
                            $imap = new Zend_Mail_Protocol_Imap('imap.gmail.com', '993', true);
                            $authenticateParams = array('XOAUTH', $initClientRequestEncoded);
                            $imap->requestAndResponse('AUTHENTICATE', $authenticateParams);

                            /**
                             * Print the INBOX message count and the subject of all messages
                             * in the INBOX
                             */
                            $storage = new Zend_Mail_Storage_Imap($imap);

                            include 'header.php';
                            echo '<h1>Total messages: ' . $storage->countMessages() . "</h1>\n";

                            /**
                             * Retrieve first 5 messages.  If retrieving more, you'll want
                             * to directly use Zend_Mail_Protocol_Imap and do a batch retrieval,
                             * plus retrieve only the headers
                             */
                            echo 'First five messages: <ul>';
                            for ($i = 1; $i <= $storage->countMessages() && $i <= 5; $i++) {
                                echo '<li>' . htmlentities($storage->getMessage($i)->subject) . "</li>\n";
                            }
                            echo '</ul>';
                            include 'footer.php';
                        }
                    }
                }
                ?>
            </body></html>
        <?php
    }

    public function actionAuthGoogle() {
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_PlusService.php');
        $client = new Google_Client();
        $client->setApplicationName('Google+ PHP Starter Application');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
        $client->setClientId('563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com');
        $client->setClientSecret('KomfbIKZbZ5oxUPHr5KOqs8i');
        $client->setRedirectUri('http://localhost/admin/payment/resGoogle');
        $client->setDeveloperKey('AIzaSyBdnMcTvjBGuJnPvmaIaawfchKzOR6WjR0');
        $plus = new Google_PlusService($client);

        if (isset($_GET['code'])) {
            $client->authenticate();
            $_SESSION['token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }

        if ($client->getAccessToken()) {
            $activities = $plus->activities->listActivities('me', 'public');
            print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

            // We're not done yet. Remember to update the cached access token.
            // Remember to replace $_SESSION with a real database or memcached.
            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
            //print "<a href='$authUrl'>Connect Me!</a>";
            Yii::app()->request->redirect($authUrl);
        }
    }

    public function actionAuthPlusGoogle() {
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_PlusService.php');
        $client = new Google_Client();
        $client->setApplicationName('Google+ PHP Starter Application');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
        $client->setClientId('563886264634-j3te3nc00r0oli8b8as3o79jpvflki1e.apps.googleusercontent.com');
        $client->setClientSecret('KomfbIKZbZ5oxUPHr5KOqs8i');
        $client->setRedirectUri('http://localhost/admin/payment/resGoogle');
        $client->setDeveloperKey('AIzaSyBdnMcTvjBGuJnPvmaIaawfchKzOR6WjR0');
        $plus = new Google_PlusService($client);

        if (isset($_GET['code'])) {
            $client->authenticate();
            $_SESSION['token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        }

        if ($client->getAccessToken()) {
            $activities = $plus->activities->listActivities('me', 'public');
            print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

            // We're not done yet. Remember to update the cached access token.
            // Remember to replace $_SESSION with a real database or memcached.
            $_SESSION['token'] = $client->getAccessToken();
        } else {
            $authUrl = $client->createAuthUrl();
            //print "<a href='$authUrl'>Connect Me!</a>";
            Yii::app()->request->redirect($authUrl);
        }
    }

    public function actionImapGoogle() {
        require_once (Yii::getPathOfAlias('common.lib') . '/common.php');
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['ACCESS_TOKEN']);
            unset($_SESSION['REQUEST_TOKEN']);
            Yii::app()->end();
        }

        $email = $THREE_LEGGED_EMAIL_ADDRESS; /* 'qcdn.master@gmail.com' */
        /**
         * Setup OAuth
         */
        $options = array(
            'requestScheme' => Zend_Oauth::REQUEST_SCHEME_HEADER,
            'version' => '1.0',
            'consumerKey' => $THREE_LEGGED_CONSUMER_KEY,
            'callbackUrl' => YII_DEBUG ? 'http://localhost/admin/payment/imapGoogle' : 'http://nhadatthuongmai.com/admin/payment/imapGoogle',
            'requestTokenUrl' => 'https://www.google.com/accounts/OAuthGetRequestToken',
            'userAuthorizationUrl' => 'https://www.google.com/accounts/OAuthAuthorizeToken',
            'accessTokenUrl' => 'https://www.google.com/accounts/OAuthGetAccessToken'
        );

        if ($THREE_LEGGED_SIGNATURE_METHOD == 'RSA-SHA1') {
            $options['signatureMethod'] = 'RSA-SHA1';
            $options['consumerSecret'] = new Zend_Crypt_Rsa_Key_Private(
                    file_get_contents(realpath($THREE_LEGGED_RSA_PRIVATE_KEY)));
        } else {
            $options['signatureMethod'] = 'HMAC-SHA1';
            $options['consumerSecret'] = $THREE_LEGGED_CONSUMER_SECRET_HMAC;
        }
        $consumer = new Zend_Oauth_Consumer($options);
        if (!isset($_SESSION['ACCESS_TOKEN'])) {
            try {
                if (!isset($_SESSION['REQUEST_TOKEN'])) {
                    // Get Request Token and redirect to Google
                    $_SESSION['REQUEST_TOKEN'] = serialize($consumer->getRequestToken(array('scope' => implode(' ', $THREE_LEGGED_SCOPES))));
                    $consumer->redirect();
                    Yii::app()->end();
                } else {
                    // Have Request Token already, Get Access Token
                    $_SESSION['ACCESS_TOKEN'] = serialize($consumer->getAccessToken($_GET, unserialize($_SESSION['REQUEST_TOKEN'])));
                    header(YII_DEBUG ? 'Location: http://localhost/admin/payment/imapGoogle' : 'Location: http://nhadatthuongmai.com/admin/payment/imapGoogle');
                    Yii::app()->end();
                }
            } catch (Exception $exc) {
                unset($_SESSION['ACCESS_TOKEN']);
                unset($_SESSION['REQUEST_TOKEN']);
                header(YII_DEBUG ? 'Location: http://localhost/admin/payment/imapGoogle' : 'Location: http://nhadatthuongmai.com/admin/payment/imapGoogle');
                Yii::app()->end();
            }
        } else {
            // Retrieve mail using Access Token
            $accessToken = unserialize($_SESSION['ACCESS_TOKEN']);
            $config = new Zend_Oauth_Config();
            $config->setOptions($options);
            $config->setToken($accessToken);
            $config->setRequestMethod('GET');
            $url = 'https://mail.google.com/mail/b/' . $email . '/imap/';

            $httpUtility = new Zend_Oauth_Http_Utility();

            /**
             * Get an unsorted array of oauth params,
             * including the signature based off those params.
             */
            $params = $httpUtility->assembleParams($url, $config);

            /**
             * Sort parameters based on their names, as required
             * by OAuth.
             */
            ksort($params);

            /**
             * Construct a comma-deliminated,ordered,quoted list of 
             * OAuth params as required by XOAUTH.
             * 
             * Example: oauth_param1="foo",oauth_param2="bar"
             */
            $first = true;
            $oauthParams = '';
            foreach ($params as $key => $value) {
                // only include standard oauth params
                if (strpos($key, 'oauth_') === 0) {
                    if (!$first) {
                        $oauthParams .= ',';
                    }
                    $oauthParams .= $key . '="' . urlencode($value) . '"';
                    $first = false;
                }
            }

            /**
             * Generate SASL client request, using base64 encoded 
             * OAuth params
             */
            $initClientRequest = 'GET ' . $url . ' ' . $oauthParams;
            $initClientRequestEncoded = base64_encode($initClientRequest);

            /**
             * Make the IMAP connection and send the auth request
             */
            $imap = new Zend_Mail_Protocol_Imap('imap.gmail.com', '993', true);
            $authenticateParams = array('XOAUTH', $initClientRequestEncoded);
            $imap->requestAndResponse('AUTHENTICATE', $authenticateParams);

            /**
             * Print the INBOX message count and the subject of all messages
             * in the INBOX
             */
            $storage = new Zend_Mail_Storage_Imap($imap);
            //$storage->selectFolder("[Gmail]/All Mail");

            echo '<h1>Total messages: ' . $storage->countMessages() . "</h1>\n";
            // output first text/plain part
            $foundPart = null;
            foreach (new RecursiveIteratorIterator($storage->getMessage(1)) as $part) {
                try {
                    if (strtok($part->contentType, ';') == 'text/plain') {
                        $foundPart = $part;
                        break;
                    }
                } catch (Zend_Mail_Exception $e) {
                    // ignore
                }
            }
            if (!$foundPart) {
                echo 'no plain text part found';
            } else {
                echo "plain text part: \n" . htmlentities($foundPart);
            }
            /**
             * Retrieve first 5 messages.  If retrieving more, you'll want
             * to directly use Zend_Mail_Protocol_Imap and do a batch retrieval,
             * plus retrieve only the headers
             */
            echo 'First five messages: <ul>';
            for ($i = 1; $i <= $storage->countMessages() && $i <= 3; $i++) {
                try {
                    $uniqueId = $storage->getUniqueId($i);
                    $message = $storage->getMessage($i);
                } catch (Exception $ex) {
                    log("Error getting Unique id", 'index');
                    log($ex->getMessage(), 'index');
                    log($ex->getTraceAsString(), 'index');

                    if ($ex->getMessage() == 'cannot read - connection closed?') {
                        //Timeout :(
                        return true;
                    }
                    else
                        continue;
                }
                // get the first none multipart part
                $part = $message;
                while ($part->isMultipart()) {
                    $part = $message->getPart(1);
                }
                echo '<li>' . 'Type of this part is ' . strtok($part->contentType, ';') . $part->getContent() . "</li>\n";
            }
            echo '</ul>';
        }
        ?>
        <!doctype html>
        <html>
            <head>
                <meta charset="utf-8">
                <title>OAuth IMAP example with Gmail</title>
            </head>
            <body>
                <header><h1>OAuth IMAP example with Gmail</h1></header>
                <?php
                if (!isset($_SESSION['ACCESS_TOKEN'])) {
                    print "<a class='login' href='$authUrl'>Connect Me!</a>";
                } else {
                    print "<a class='logout' href='?logout'>Logout</a>";
                }
                ?>
            </body>
        </html>
        <?php
    }

    public function actionImapOkieGoogle() {
        $mail = new Zend_Mail_Storage_Imap(array(
            'host' => 'imap.gmail.com',
            'user' => 'qcdn.master@gmail.com',
            'port' => 993,
            'ssl' => 'SSL',
            'password' => '@dm!n1978'
        ));
        echo $maxMessage = $mail->countMessages() . " messages found<br/>";
    }

    public function actionSmtpGoogle() {
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/Google_Client.php');
        require_once (Yii::getPathOfAlias('common.vendors.google') . '/contrib/Google_Oauth2Service.php');
        require_once (Yii::getPathOfAlias('common.lib') . '/common.php');
        $client = new Google_Client();
        $client->setApplicationName('Google Oauth2Service');
        $client->setClientId('563886264634-qpg04g1teqng5hlk1isra7cq3l2u617n.apps.googleusercontent.com');
        $client->setClientSecret('7nuPpnHbUPZiBtJLP9Y9470Z');
        $client->setRedirectUri(YII_DEBUG ? 'http://localhost/admin/payment/smtpGoogle' : 'http://nhadatthuongmai.com/admin/payment/smtpGoogle');
        $client->setDeveloperKey('AIzaSyCGPfWuFYVBuju6qqPH1fMY8ONmOIS1_EU');
        $client->setScopes('https://mail.google.com');
        $oauth2 = new Google_Oauth2Service($client);

        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $client->authenticate($code);
            $_SESSION['token'] = $client->getAccessToken();
            header(YII_DEBUG ? 'Location: http://localhost/admin/payment/smtpGoogle' : 'Location: http://nhadatthuongmai.com/admin/payment/smtpGoogle');
            Yii::app()->end();
        } elseif (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
        } else {
            $client->authenticate();
            Yii::app()->end();
        }
        if (isset($_REQUEST['logout'])) {
            unset($_SESSION['token']);
            $client->revokeToken();
            Yii::app()->end();
        }
        if (isset($_SESSION['token'])) {
            $email = $THREE_LEGGED_EMAIL_ADDRESS; /* 'qcdn.master@gmail.com' */
            $accessToken = $_SESSION['token'] = $client->getAccessToken();
            var_dump($accessToken);exit();
            $initClientRequestEncoded = base64_encode("user={$email}\1auth=Bearer {$accessToken}\1\1");
            $config = array('ssl' => 'ssl',
                'port' => '465',
                'auth' => 'oauth2',
                'xoauth2_request' => $initClientRequestEncoded);

            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            $mail = new Zend_Mail('utf-8');
            $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
            $mail->setReplyTo('qcdn.master@gmail.com', 'qcdn.master');
            $mail->setFrom('qcdn.master@gmail.com', 'quang cao dong nai');
            $mail->addTo('nguyen@4sao.com', 'Huu Nguyen');
            $mail->addHeader('MIME-Version', '1.0');
            $mail->addHeader('Content-Transfer-Encoding', '8bit');
            $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

            $mail->setSubject('XOAUTH Thông tin thanh toán: giỏ hàng' . rand(1000, 9999));
            $mail->setBodyText('Thông tin thanh toán: giỏ hàng');
            $mail->setBodyHtml('<b>Thông tin thanh toán: giỏ hàng</b>');
            $mail->send($transport);
        }
    }

    public function actionSmtpOkieGoogle() {
        try {
            $config = array(
                'host' => 'smtp.gmail.com',
                'auth' => 'login',
                'username' => 'qcdn.master@gmail.com',
                'password' => '@dm!n1978',
                'ssl' => 'tls',
                'port' => 587
            );
            $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            Zend_Mail::setDefaultTransport($transport);
            Zend_Mail::setDefaultFrom('qcdn.master@gmail.com', 'Cao Quang');
            $mail = new Zend_Mail('utf-8');
            $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
            $mail->setReplyTo('qcdn.master@gmail.com', 'qcdn.master');
            $mail->setFrom('qcdn.master@gmail.com', 'Cao Quang');
            $mail->addTo('nguyen@4sao.com', 'Huu Nguyen');
            $mail->addHeader('MIME-Version', '1.0');
            $mail->addHeader('Content-Transfer-Encoding', '8bit');
            $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

            $mail->setSubject('Thông tin thanh toán: giỏ hàng');
            $mail->setBodyText('Thông tin thanh toán: giỏ hàng');
            $mail->setBodyHtml('<b>Thông tin thanh toán: giỏ hàng</b>');
            $mail->send($transport);
        } catch (Exception $e) {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.' . $e->getMessage());
            exit();
        }
    }

}

