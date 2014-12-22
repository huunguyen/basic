<?php

class SiteController extends BEController {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    /**
     * change setup
     */
    public function actionSetup(){
        
    }
    /**
     * load setup
     */
    public function actionLoadSetup(){
        
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if (!Yii::app()->user->isGuest)
            $this->render('dashboard');
        else
            $this->redirect(array('login'));
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionDashboard() {
        if (!Yii::app()->user->isGuest)
            $this->render('dashboard');
        else
            $this->redirect(array('login'));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->createUrl("site/index", array("theme" => 'admin')));
        $this->layout = "//layouts/login";
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('index.php');
    }

    public function actionExpXLS() {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'xls') . DIRECTORY_SEPARATOR;
        $this->checkPath("xls");
    }

    public function actionExpDOC() {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'doc') . DIRECTORY_SEPARATOR;
        $this->checkPath("doc");
        // New Word Document
        $PHPWord = new PHPWord();

        $document = $PHPWord->loadTemplate($path . 'Template.docx');

        $document->setValue('Value1', 'Sun');
        $document->setValue('Value2', 'Mercury');
        $document->setValue('Value3', 'Venus');
        $document->setValue('Value4', 'Earth');
        $document->setValue('Value5', 'Mars');
        $document->setValue('Value6', 'Jupiter');
        $document->setValue('Value7', 'Saturn');
        $document->setValue('Value8', 'Uranus');
        $document->setValue('Value9', 'Neptun');
        $document->setValue('Value10', 'Pluto');

        $document->setValue('weekday', date('l'));
        $document->setValue('time', date('H:i'));

        $document->save($path . 'Solarsystem.docx');
        chmod($path . 'Solarsystem.docx', 0777);
// New Word Document
        $PHPWord = new PHPWord();

// New portrait section
        $section = $PHPWord->createSection();

// Add text elements
        $section->addText('You can open this OLE object by double clicking on the icon:');
        $section->addTextBreak(2);

// Add object
        $section->addObject($path . '_sheet.xls');

// Save File
        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save($path . 'Object.docx');
        chmod($path . 'Object.docx', 0777);
        echo "okie";
    }

    public function checkPath($type = null) {
        if ($type === null)
            return false;
        else {
            $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads') . DIRECTORY_SEPARATOR;
            //var_dump($path);exit();
            if (!file_exists($path . DIRECTORY_SEPARATOR . $type)) {
                mkdir($path . DIRECTORY_SEPARATOR . $type, 0777);
                chmod($path . DIRECTORY_SEPARATOR . $type, 0777);
            } elseif (!is_writeable($path . DIRECTORY_SEPARATOR . $type)) {
                chmod($path . DIRECTORY_SEPARATOR . $type, 0777);
            }
        }
    }

    public function actionExpPPT() {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'ppt') . DIRECTORY_SEPARATOR;
        $this->checkPath("ppt");
        // Create new PHPPowerPoint object
        echo date('H:i:s') . " Create new PHPPowerPoint object\n";
        $objPHPPowerPoint = new PHPPowerPoint();

// Set properties
        echo date('H:i:s') . " Set properties\n";
        $objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw");
        $objPHPPowerPoint->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPPowerPoint->getProperties()->setTitle("Office 2007 PPTX Test Document");
        $objPHPPowerPoint->getProperties()->setSubject("Office 2007 PPTX Test Document");
        $objPHPPowerPoint->getProperties()->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.");
        $objPHPPowerPoint->getProperties()->setKeywords("office 2007 openxml php");
        $objPHPPowerPoint->getProperties()->setCategory("Test result file");

// Create slide
        echo date('H:i:s') . " Create slide\n";
        $currentSlide = $objPHPPowerPoint->getActiveSlide();

// Create a shape (drawing)
        echo date('H:i:s') . " Create a shape (drawing)\n";
        $shape = $currentSlide->createDrawingShape();
        $shape->setName('PHPPowerPoint logo');
        $shape->setDescription('PHPPowerPoint logo');
        $shape->setPath($path . '..' . DIRECTORY_SEPARATOR . 'image.png');
        $shape->setHeight(36);
        $shape->setOffsetX(10);
        $shape->setOffsetY(10);
//$shape->setRotation(25);
        $shape->getShadow()->setVisible(true);
        $shape->getShadow()->setDirection(45);
        $shape->getShadow()->setDistance(10);

// Create a shape (text)
        echo date('H:i:s') . " Create a shape (rich text)\n";
        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(300);
        $shape->setWidth(600);
        $shape->setOffsetX(170);
        $shape->setOffsetY(180);
        $shape->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER);
        $textRun = $shape->createTextRun('Thank you for using PHPPowerPoint!');
        $textRun->getFont()->setBold(true);
        $textRun->getFont()->setSize(60);
        $textRun->getFont()->setColor(new PHPPowerPoint_Style_Color('FFC00000'));

// Save PowerPoint 2007 file
        echo date('H:i:s') . " Write to PowerPoint2007 format\n";
        $objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');

        $objWriter->save(str_replace('.php', '.pptx', $path . 'Basic.pptx'));
        chmod($path . 'Basic.pptx', 0777);
// Echo memory peak usage
        echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";

// Echo done
        echo date('H:i:s') . " Done writing file.\r\n";


        echo "okie";
    }
public function actionSend() {
       $body = "theOutput";
            try {
                $config = array(
                    'host' => Yii::app()->params["host"],
                    'auth' => Yii::app()->params["auth"],
                    'username' => Yii::app()->params["email"],
                    'password' => Yii::app()->params["password"],
                    'ssl' => Yii::app()->params["ssl"],
                    'port' => Yii::app()->params["port"]
                );
                //var_dump($config);exit();
                $transport = new Zend_Mail_Transport_Smtp(Yii::app()->params["host"], $config);
                Zend_Mail::setDefaultTransport($transport);
                Zend_Mail::setDefaultFrom(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail = new Zend_Mail('utf-8');
                $mail->setHeaderEncoding(Zend_Mime::ENCODING_QUOTEDPRINTABLE);
                $mail->setReplyTo(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail->setFrom(Yii::app()->params["email"], Yii::app()->params["name"]);
                //$mail->addCc(Yii::app()->params["email"], Yii::app()->params["name"]);
                $mail->addBcc(Yii::app()->params["email"], Yii::app()->params["name"]);

                $mail->addTo('nguyen.huu.nguyen@gmail.com', 'Test mail yii');
                $mail->addHeader('MIME-Version', '1.0');
                $mail->addHeader('Content-Transfer-Encoding', '8bit');
                $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());

                $mail->setSubject("Thông tin hóa đơn mua hàng");
                $mail->setBodyText($body);
                $mail->setBodyHtml($body);
                $mail->send($transport);
                Yii::app()->user->setFlash('success', '<strong>Thông tin đã được gửi thành công! </strong>');
                $this->redirect(array('site/index'));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', '<strong>Thất bại! </strong> ' . $e->getMessage());
                $this->redirect(array('site/index'));
            }
    }
}
