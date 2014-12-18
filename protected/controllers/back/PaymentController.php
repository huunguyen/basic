<?php

//Yii::import("common.vendors.Classes.PHPExcel", true);
class PaymentController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'index';

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
                'actions' => array('admin', 'payment', 'payments', 'updateTotal', 'sumTotal', 'ajaxPayments', 'books', 'index', 'view', 'viewbooks', 'sentEmail',  'imapGoogle', 'smtpGoogle', 'export', 'exportBook', 'exportBooks', 'exportPayment', 'exportPayments', 'delExcel'),
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

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => Books::model()->findByPk($id),
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionOpenExcel($file) {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        //$publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        $inputFileType = 'Excel2007';
        $inputFileName = isset($file) ? $file : isset($_GET['file']) ? $_GET['file'] : null;
        if (($inputFileName != null) && is_file($path . $inputFileName)) {
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path . $inputFileName);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
            $objWriter->save('php://output');
            exit;
        } else {
            Yii::app()->user->setFlash('error', '<strong>Lỗi! </strong>File này không tồn tại trên server!');
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDownloadExcel($file) {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        //$publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        $inputFileType = 'Excel2007';
        $inputFileName = isset($file) ? $file : isset($_GET['file']) ? $_GET['file'] : null;
        if (($inputFileName != null) && is_file($path . $inputFileName)) {
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path . $inputFileName);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $inputFileName . '"');
            header('Cache-Control: max-age=1');
            $objWriter->save('php://output');
            exit;
        } else {
            Yii::app()->user->setFlash('error', '<strong>Lỗi! </strong>File này không tồn tại trên server!');
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDelExcel() {
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        //$publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        $inputFileType = 'Excel2007';
        $inputFileName = isset($file) ? $file : isset($_GET['file']) ? $_GET['file'] : null;
        if (($inputFileName != null) && is_file($path . $inputFileName)) {
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($path . $inputFileName);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
            $objWriter->save('php://output');
            unlink($path . $inputFileName);
            Yii::app()->user->setFlash('success', '<strong>Thành công! </strong>File đã được xóa trên server!');
            exit;
        } else {
            Yii::app()->user->setFlash('error', '<strong>Lỗi! </strong>File này không tồn tại trên server!');
            $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionExport($id) {
        $model = Books::model()->findByPk($id);
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        $publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Nguyen Huu Nguyen")
                ->setLastModifiedBy("Nguyen Huu Nguyen")
                ->setTitle("QCDN - Nguyen Huu Nguyen")
                ->setSubject("Báo cáo tài chính")
                ->setDescription("Báo cáo tài chính. QCDN - Nguyen Huu Nguyen")
                ->setKeywords("office PHPExcel php")
                ->setCategory("QCDN");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                ->setSize(10);
        $iheader = 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Báo cáo tài chính. QCDN - Books');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Mã thanh toán')
                ->setCellValue('B2', 'Ngày tạo')
                ->setCellValue('C2', 'Phân loại')
                ->setCellValue('D2', 'Mô tả')
                ->setCellValue('E2', 'Ngày bắt đầu thanh toán')
                ->setCellValue('F2', 'Ngày kết thúc thanh toán')
                ->setCellValue('G2', 'Tổng số tiền')
                ->setCellValue('H2', 'Đơn vị tính')
                ->setCellValue('I2', 'Bằng chữ');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', $model->paymentkey)
                ->setCellValue('B3', $model->create_date)
                ->setCellValue('C3', $model->categories)
                ->setCellValue('D3', $model->description . $model->info)
                ->setCellValue('E3', $model->start_date_payment)
                ->setCellValue('F3', $model->end_date_payment)
                ->setCellValue('G3', $model->totalofmoney)
                ->setCellValue('H3', 'VND')
                ->setCellValue('I3', FinanceHelper::changeNumberToString($model->totalofmoney));
        $ifooter = 4;
        $dateTimeNow = time();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H' . $ifooter, 'Biên hòa, Ngày')
                ->setCellValue('I' . $ifooter, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
        $objPHPExcel->getActiveSheet()->getStyle('I' . $ifooter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
// Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $file = $path . $model->paymentkey . '.xlsx';
        if (is_file($file)) {
            unlink($file);
        }
        $objWriter->save($path . $model->paymentkey . '.xlsx');
        chmod($path . $model->paymentkey . '.xlsx', 0777);
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        $this->render('export', array(
            'model' => $model,
            'file' => $model->paymentkey . '.xlsx'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionExportBook($id) {
        $model = Books::model()->findByPk($id);
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        $publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Nguyen Huu Nguyen")
                ->setLastModifiedBy("Nguyen Huu Nguyen")
                ->setTitle("QCDN - Nguyen Huu Nguyen")
                ->setSubject("Báo cáo tài chính")
                ->setDescription("Báo cáo tài chính. QCDN - Nguyen Huu Nguyen")
                ->setKeywords("office PHPExcel php")
                ->setCategory("QCDN");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                ->setSize(10);
        $iheader = 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Báo cáo tài chính. QCDN - Books');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Mã thanh toán')
                ->setCellValue('B2', 'Ngày tạo')
                ->setCellValue('C2', 'Phân loại')
                ->setCellValue('D2', 'Mô tả')
                ->setCellValue('E2', 'Ngày bắt đầu thanh toán')
                ->setCellValue('F2', 'Ngày kết thúc thanh toán')
                ->setCellValue('G2', 'Tổng số tiền')
                ->setCellValue('H2', 'Đơn vị tính')
                ->setCellValue('I2', 'Bằng chữ');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', $model->paymentkey)
                ->setCellValue('B3', $model->create_date)
                ->setCellValue('C3', $model->categories)
                ->setCellValue('D3', $model->description . $model->info)
                ->setCellValue('E3', $model->start_date_payment)
                ->setCellValue('F3', $model->end_date_payment)
                ->setCellValue('G3', $model->totalofmoney)
                ->setCellValue('H3', 'VND')
                ->setCellValue('I3', FinanceHelper::changeNumberToString($model->totalofmoney));
        $ifooter = 4;
        $dateTimeNow = time();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H' . $ifooter, 'Biên hòa, Ngày')
                ->setCellValue('I' . $ifooter, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
        $objPHPExcel->getActiveSheet()->getStyle('I' . $ifooter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
// Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $file = $path . $model->paymentkey . '.xlsx';
        if (is_file($file)) {
            unlink($file);
        }
        $objWriter->save($path . $model->paymentkey . '.xlsx');
        chmod($path . $model->paymentkey . '.xlsx', 0777);
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        $this->render('export', array(
            'model' => $model,
            'file' => $model->paymentkey . '.xlsx'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionExportPayment($id) {
        $payment = Payment::model()->findByPk($id);
        $model = Books::model()->findByPk($payment->books_id);
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        $publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Nguyen Huu Nguyen")
                ->setLastModifiedBy("Nguyen Huu Nguyen")
                ->setTitle("QCDN - Nguyen Huu Nguyen")
                ->setSubject("Báo cáo tài chính")
                ->setDescription("Báo cáo tài chính. QCDN - Nguyen Huu Nguyen")
                ->setKeywords("office PHPExcel php")
                ->setCategory("QCDN");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                ->setSize(10);
        $iheader = 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Báo cáo tài chính. QCDN - Books');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Mã thanh toán')
                ->setCellValue('B2', 'Ngày tạo')
                ->setCellValue('C2', 'Phân loại')
                ->setCellValue('D2', 'Mô tả')
                ->setCellValue('E2', 'Ngày bắt đầu thanh toán')
                ->setCellValue('F2', 'Ngày kết thúc thanh toán')
                ->setCellValue('G2', 'Tổng số tiền')
                ->setCellValue('H2', 'Đơn vị tính')
                ->setCellValue('I2', 'Bằng chữ');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A3', $model->paymentkey)
                ->setCellValue('B3', $model->create_date)
                ->setCellValue('C3', $model->categories)
                ->setCellValue('D3', $model->description . $model->info)
                ->setCellValue('E3', $model->start_date_payment)
                ->setCellValue('F3', $model->end_date_payment)
                ->setCellValue('G3', $model->totalofmoney)
                ->setCellValue('H3', 'VND')
                ->setCellValue('I3', FinanceHelper::changeNumberToString($model->totalofmoney));
        $ifooter = 4;
        $dateTimeNow = time();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('H' . $ifooter, 'Biên hòa, Ngày')
                ->setCellValue('I' . $ifooter, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
        $objPHPExcel->getActiveSheet()->getStyle('I' . $ifooter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
// Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $file = $path . $model->paymentkey . '.xlsx';
        if (is_file($file)) {
            unlink($file);
        }
        $objWriter->save($path . $model->paymentkey . '.xlsx');
        chmod($path . $model->paymentkey . '.xlsx', 0777);
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        $this->render('export', array(
            'model' => $model,
            'file' => $model->paymentkey . '.xlsx'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionExportBooks($load = false) {
        //$models = Books::model()->findAll();
        $models = Books::model()->findAll(array(
            "condition" => "status = 'COMPLETED'",
            "order" => "create_date DESC",
            'offset' => 0,
            "limit" => 20,
        ));
        $user = User::model()->findByPk(Yii::app()->user->id);
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        //$publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        if ($load) {
            $objPHPExcel = PHPExcel_IOFactory::load($path . "Template.xlsx");
        }
        else
            $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Nguyen Huu Nguyen")
                ->setLastModifiedBy(isset($user->author_name) ? $user->author_name : $user->username)
                ->setTitle("QCDN - Kế Toán & Tài Chính")
                ->setSubject("Báo cáo tài chính - Phòng Kế toán")
                ->setDescription("Báo cáo tài chính. QCDN - Giám đốc: Ông. Cao Trí")
                ->setKeywords("Quảng Cáo, Đồng Nai")
                ->setCategory("QCDN");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                ->setSize(10);
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
        $iheader = 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $iheader . ':I' . $iheader);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Bản Thống kê Các Giỏ Hàng Trong hệ thống. Cty Quảng Cáo Đồng Nai');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setName('QCDN');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getAlignment()->setWrapText(true);
        // Add a drawing to the worksheet
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('QCDN Logo');
        $objDrawing->setPath($path . 'images' . DIRECTORY_SEPARATOR . 'logo_64x64.png');
        $objDrawing->setHeight(64);
        $objDrawing->setCoordinates('A' . $iheader);
        $objDrawing->setOffsetX(0);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(45);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->getRowDimension($iheader)->setRowHeight(64);

        $styleHeader = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->applyFromArray($styleHeader);
        ++$iheader;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Mã thanh toán')
                ->setCellValue('B' . $iheader, 'Ngày tạo')
                ->setCellValue('C' . $iheader, 'Phân loại')
                ->setCellValue('D' . $iheader, 'Mô tả')
                ->setCellValue('E' . $iheader, 'Ngày bắt đầu thanh toán')
                ->setCellValue('F' . $iheader, 'Ngày kết thúc thanh toán')
                ->setCellValue('G' . $iheader, 'Tổng số tiền')
                ->setCellValue('H' . $iheader, 'ĐVT')
                ->setCellValue('I' . $iheader, 'Bằng chữ');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getRowDimension($iheader)->setRowHeight(32);

        $objPHPExcel->getActiveSheet()
                ->getStyle('A1' . ':I' . $iheader)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $ibody = $iheader + 1;
        foreach ($models as $model) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ibody, $model->paymentkey)
                    ->setCellValue('B' . $ibody, $model->create_date)
                    ->setCellValue('C' . $ibody, Lookup::item("BooksCategories", $model->categories))
                    ->setCellValue('D' . $ibody, $model->description . str_replace("<br/>", "\r\n", $model->info))
                    ->setCellValue('E' . $ibody, $model->start_date_payment)
                    ->setCellValue('F' . $ibody, $model->end_date_payment)
                    ->setCellValue('G' . $ibody, $model->totalofmoney)
                    ->setCellValue('H' . $ibody, 'VND')
                    ->setCellValue('I' . $ibody, FinanceHelper::changeNumberToString($model->totalofmoney));
            if (( isset($model->newsCount) && ($model->newsCount > 0)) || (isset($model->bannerCount) && ($model->bannerCount > 0))) {
                $objPHPExcel->getActiveSheet()->getRowDimension($ibody)->setRowHeight(40);
            } else {
                $objPHPExcel->getActiveSheet()->getRowDimension($ibody)->setRowHeight(20);
            }
            ++$ibody;
        }
        // set grid for data
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($iheader) . ':I' . ($ibody - 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        $styleName = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        // set border for name range
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($iheader - 1) . ':I' . $iheader)->applyFromArray($styleName);

        $objPHPExcel->getActiveSheet()->getStyle('D' . ($iheader + 1) . ':D' . ($ibody - 1))->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D' . ($iheader + 1) . ':D' . ($ibody - 1))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);
        // set border for zone data
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . ($ibody - 1))->applyFromArray($styleName);
        $objPHPExcel->getActiveSheet()
                ->getStyle('A' . ($iheader + 1) . ':I' . ($ibody - 1))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        ++$ibody;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . $ibody, 'Tổng tiền trước thuế:')
                ->setCellValue('G' . $ibody, '=SUM(G' . ($iheader + 1) . ':G' . ($ibody - 2) . ')')
                ->setCellValue('H' . $ibody, 'VND');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . ($ibody + 1), 'Thuế (VAT): 10%')
                ->setCellValue('G' . ($ibody + 1), '=G' . $ibody . ' * 0.1')
                ->setCellValue('H' . ($ibody + 1), 'VND');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . ($ibody + 2), 'Tổng tiền sau thuế:')
                ->setCellValue('G' . ($ibody + 2), '=SUM(G' . $ibody . ' , G' . ($ibody + 1) . ')')
                ->setCellValue('H' . ($ibody + 2), 'VND');

        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->setAuthor('HuuNguyen');
        $objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->getText()->createTextRun('TỔNG TIỀN:');
        $objCommentRichText->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->getText()->createTextRun("\r\n");
        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->getText()->createTextRun('Tổng tiền bao gồm thuế VAT');
        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->setWidth('100pt');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ibody . ':I' . ($ibody + 2))->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ibody . ':I' . ($ibody + 2))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ibody . ':I' . ($ibody + 2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

        $objPHPExcel->getActiveSheet()->getStyle('G' . $ibody . ':G' . ($ibody + 2))->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $ibody . ':G' . ($ibody + 2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $ibody . ':G' . ($ibody + 2))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $styleTotal = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('F' . $ibody . ':H' . ($ibody + 2))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $ibody . ':H' . ($ibody + 2))->applyFromArray($styleTotal);
        $ifooter = $ibody + 4;
        $dateTimeNow = time();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G' . $ifooter, 'Biên hòa, Ngày')
                ->setCellValue('H' . $ifooter, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
        $objPHPExcel->getActiveSheet()->getStyle('H' . $ifooter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);

// Add a drawing to the worksheet
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Paid');
        $objDrawing->setDescription('Paid');
        $objDrawing->setPath($path . 'images' . DIRECTORY_SEPARATOR . 'paid.png');
        $objDrawing->setCoordinates('B15');
        $objDrawing->setOffsetX(110);
        $objDrawing->setRotation(25);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(45);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// Set layout
        $objPHPExcel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(75);
// Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setTitle('Bản In Báo Cáo Tài Chánh - QCDN');
        $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&R&H Quảng cáo đồng nai!');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&R Trang &P của &N Trang');
        $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();


// Set page orientation, size, Print Area and Fit To Pages
        $objPageSetup = new PHPExcel_Worksheet_PageSetup();
        $objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPageSetup->setPrintArea("A1:I" . $ifooter);
        $objPageSetup->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->setPageSetup($objPageSetup);
        // del old file or backup it
        $rnd = rand(0, 9999);
        if (is_file($path . 'ExportBooks.xlsx')) {
            rename($path . 'ExportBooks.xlsx', $path . 'ExportBooks' . $rnd . '.xlsx');
            /*
              $oldObjPHPExcel = PHPExcel_IOFactory::load($path . 'ExportBooks' . $rnd.'.xlsx');
              $objWorkSheetBase = $oldObjPHPExcel->getActiveSheet();
              $objWorkSheet1 = clone $objWorkSheetBase;
              $objWorkSheet1->setTitle('ExportBooks' . $rnd);
              $objPHPExcel->addSheet($objWorkSheet1);
             */
        }
// Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path . 'ExportBooks.xlsx');
        chmod($path . 'ExportBooks.xlsx', 0777);
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        $this->render('success', array(
            'models' => $models,
            'file' => 'ExportBooks.xlsx'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionExportPayments($load = false) {
        $models = new CActiveDataProvider(Payment::model(), array(
            'criteria' => array(
                'limit' => 20,
                'order' => 'payment_date DESC'
            ),
            'pagination' => false
                )
        );
        $models = Payment::model()->findAll();
        $user = User::model()->findByPk(Yii::app()->user->id);
        $path = realpath(Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL') . DIRECTORY_SEPARATOR;
        //$publicPath = Yii::app()->getBaseUrl() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'EXCEL' . DIRECTORY_SEPARATOR;
        if ($load) {
            $objPHPExcel = PHPExcel_IOFactory::load($path . "Template.xlsx");
        }
        else
            $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Nguyen Huu Nguyen")
                ->setLastModifiedBy(isset($user->author_name) ? $user->author_name : $user->username)
                ->setTitle("QCDN - Kế Toán & Tài Chính")
                ->setSubject("Báo cáo tài chính - Phòng Kế toán")
                ->setDescription("Báo cáo tài chính. QCDN - Giám đốc: Ông. Cao Trí")
                ->setKeywords("Quảng Cáo, Đồng Nai")
                ->setCategory("QCDN");
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                ->setSize(10);
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_HAIR,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
        $iheader = 1;
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $iheader . ':I' . $iheader);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Bản Thống kê Các Giỏ Hàng Trong hệ thống. Cty Quảng Cáo Đồng Nai');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setName('QCDN');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKBLUE);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader)->getAlignment()->setWrapText(true);
        // Add a drawing to the worksheet
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('QCDN Logo');
        $objDrawing->setPath($path . 'images' . DIRECTORY_SEPARATOR . 'logo_64x64.png');
        $objDrawing->setHeight(64);
        $objDrawing->setCoordinates('A' . $iheader);
        $objDrawing->setOffsetX(0);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(45);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->getRowDimension($iheader)->setRowHeight(64);

        $styleHeader = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->applyFromArray($styleHeader);
        ++$iheader;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $iheader, 'Mã thanh toán')
                ->setCellValue('B' . $iheader, 'Thời Gian')
                ->setCellValue('C' . $iheader, 'Phương Thức')
                ->setCellValue('D' . $iheader, 'Thông Tin Giỏ Hàng')
                ->setCellValue('E' . $iheader, 'Khoản Tiền')
                ->setCellValue('F' . $iheader, 'Bổ Sung')
                ->setCellValue('G' . $iheader, 'Tổng Số Tiền')
                ->setCellValue('H' . $iheader, 'ĐVT')
                ->setCellValue('I' . $iheader, 'Bằng Chữ');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . $iheader)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getRowDimension($iheader)->setRowHeight(32);

        $objPHPExcel->getActiveSheet()
                ->getStyle('A1' . ':I' . $iheader)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $ibody = $iheader + 1;
        foreach ($models as $model) {
            $info = $model->books->paymentkey . ': ' . $model->books->info;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $ibody, $model->payerid)
                    ->setCellValue('B' . $ibody, $model->payment_date)
                    ->setCellValue('C' . $ibody, Lookup::item("MethodsOfPayment", $model->methodsofpayment))
                    ->setCellValue('D' . $ibody, $info)
                    ->setCellValue('E' . $ibody, $model->amount)
                    ->setCellValue('F' . $ibody, isset($model->extraofpayments) ? $model->extraofpayments : 0)
                    ->setCellValue('G' . $ibody, $model->money_total)
                    ->setCellValue('H' . $ibody, 'VND')
                    ->setCellValue('I' . $ibody, FinanceHelper::changeNumberToString($model->money_total));
            $objPHPExcel->getActiveSheet()->getRowDimension($ibody)->setRowHeight(40);
            ++$ibody;
        }
        // set grid for data
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($iheader) . ':I' . ($ibody - 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        $styleName = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        // set border for name range
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($iheader - 1) . ':I' . $iheader)->applyFromArray($styleName);

        $objPHPExcel->getActiveSheet()->getStyle('D' . ($iheader + 1) . ':D' . ($ibody - 1))->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('D' . ($iheader + 1) . ':D' . ($ibody - 1))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKGREEN);
        // set border for zone data
        $objPHPExcel->getActiveSheet()->getStyle('A' . $iheader . ':I' . ($ibody - 1))->applyFromArray($styleName);
        $objPHPExcel->getActiveSheet()
                ->getStyle('A' . ($iheader + 1) . ':I' . ($ibody - 1))
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        ++$ibody;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . $ibody, 'Tổng tiền trước thuế:')
                ->setCellValue('G' . $ibody, '=SUM(G' . ($iheader + 1) . ':G' . ($ibody - 2) . ')')
                ->setCellValue('H' . $ibody, 'VND');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . ($ibody + 1), 'Thuế (VAT): 10%')
                ->setCellValue('G' . ($ibody + 1), '=G' . $ibody . ' * 0.1')
                ->setCellValue('H' . ($ibody + 1), 'VND');

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F' . ($ibody + 2), 'Tổng tiền sau thuế:')
                ->setCellValue('G' . ($ibody + 2), '=SUM(G' . $ibody . ' , G' . ($ibody + 1) . ')')
                ->setCellValue('H' . ($ibody + 2), 'VND');

        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->setAuthor('HuuNguyen');
        $objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->getText()->createTextRun('TỔNG TIỀN:');
        $objCommentRichText->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->getText()->createTextRun("\r\n");
        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->getText()->createTextRun('Tổng tiền bao gồm thuế VAT');
        $objPHPExcel->getActiveSheet()->getComment('G' . ($ibody + 2))->setWidth('100pt');
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ibody . ':I' . ($ibody + 2))->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ibody . ':I' . ($ibody + 2))->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $ibody . ':I' . ($ibody + 2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);

        $objPHPExcel->getActiveSheet()->getStyle('G' . $ibody . ':G' . ($ibody + 2))->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $ibody . ':G' . ($ibody + 2))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $ibody . ':G' . ($ibody + 2))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $styleTotal = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF993300'),
                ),
            ),
        );
        $objPHPExcel->getActiveSheet()->getStyle('F' . $ibody . ':H' . ($ibody + 2))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $ibody . ':H' . ($ibody + 2))->applyFromArray($styleTotal);
        $ifooter = $ibody + 4;
        $dateTimeNow = time();
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G' . $ifooter, 'Biên hòa, Ngày')
                ->setCellValue('H' . $ifooter, PHPExcel_Shared_Date::PHPToExcel($dateTimeNow));
        $objPHPExcel->getActiveSheet()->getStyle('H' . $ifooter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);

// Add a drawing to the worksheet
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Paid');
        $objDrawing->setDescription('Paid');
        $objDrawing->setPath($path . 'images' . DIRECTORY_SEPARATOR . 'paid.png');
        $objDrawing->setCoordinates('B15');
        $objDrawing->setOffsetX(110);
        $objDrawing->setRotation(25);
        $objDrawing->getShadow()->setVisible(true);
        $objDrawing->getShadow()->setDirection(45);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
// Set layout
        $objPHPExcel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_LAYOUT);
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(75);
// Set page orientation and size
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objPHPExcel->getActiveSheet()->setTitle('Bản In Báo Cáo Tài Chánh - QCDN');
        $objPHPExcel->getActiveSheet()->getTabColor()->setARGB('FF0094FF');

        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&R&H Quảng cáo đồng nai!');
        $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&R Trang &P của &N Trang');
        $objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();


// Set page orientation, size, Print Area and Fit To Pages
        $objPageSetup = new PHPExcel_Worksheet_PageSetup();
        $objPageSetup->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
        $objPageSetup->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPageSetup->setPrintArea("A1:I" . $ifooter);
        $objPageSetup->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->setPageSetup($objPageSetup);
        // del old file or backup it
        $rnd = rand(0, 9999);
        if (is_file($path . 'ExportPayments.xlsx')) {
            rename($path . 'ExportPayments.xlsx', $path . 'ExportPayments' . $rnd . '.xlsx');
        }
// Save Excel 2007 file
        $callStartTime = microtime(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($path . 'ExportPayments.xlsx');
        chmod($path . 'ExportPayments.xlsx', 0777);
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;

        $this->render('success', array(
            'models' => $models,
            'file' => 'ExportPayments.xlsx'
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionViewbooks($id) {
        $this->render('viewbooks', array(
            'model' => Books::model()->findByPk($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionPayment() {
        $redirect = true;
        if (isset($_GET['books_id'])) {
            $books_id = $_GET['books_id'];
            $books = Books::model()->findByPk($books_id);
        }
        if (isset($_GET['id'])) {
            $model = isset($model) ? $model : Payment::model()->findByPk($_GET['id']);
            $model->scenario = 'update';
        }

        if (isset($books)) {
            $redirect = false;
            $model = Payment::model()->findByAttributes(array('books_id' => $books->id));
        } elseif (isset($model)) {
            $redirect = false;
            $books = Books::model()->findByPk($model->books_id);
        }

        if (isset($books) && !isset($model)) {
            $redirect = false;
            $model = new Payment('create');
            $model->amount = $books->totalofmoney;
            $model->amount_string = FinanceHelper::changeNumberToString($model->amount);
            $model->books_id = $books_id;
            $model->transaction_info = CJSON::encode($books);
            $model->manager_id = Yii::app()->user->id;
            $model->custommer_id = $books->custommer_id;
        }

        if ($redirect) {
            Yii::app()->user->setFlash('error', "<strong>Lỗi! </strong>Bạn cần phải chọn shopping cart trước khi tạo payment cho nó.!");
            $this->redirect(array('index'));
        }


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment'])) {
            $model->attributes = $_POST['Payment'];
            $books->paymentkey = isset($_POST['Books']['paymentkey']) ? $_POST['Books']['paymentkey'] : $books->paymentkey;
            $model->transaction_info = CJSON::encode($books);
            $model->amount_string = FinanceHelper::changeNumberToString($model->amount);
            if (isset($model->extraofpayments) && is_numeric($model->extraofpayments)) {
                $model->extraofpayments_string = FinanceHelper::changeNumberToString($model->extraofpayments);
            }
            if ($model->save()) {
                if (isset($model->extraofpayments) && is_numeric($model->extraofpayments)) {
                    $books->updateByPk($books->id, array('status' => "EXTRACOMPLETED", 'paymentkey' => $books->paymentkey));
                } else {
                    $books->updateByPk($books->id, array('status' => "COMPLETED", 'paymentkey' => $books->paymentkey));
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        //var_dump($model); exit();
        $this->render('payment', array(
            'model' => $model,
            'books' => $books
        ));
    }

    /**
     * Lists all models.
     */
    public function actionBooks() {
        $model = new Books('searchOtherPayment');
        $model->unsetAttributes();  // clear any default values

        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . 'booksPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'booksPageSize', $pageSize);
            unset($_GET['pageSize']);
        }



        if (isset($_GET['ajax']) && ($_GET['ajax'] == 'books-grid') && isset($_GET['Books_page'])) {
            $booksPage = (int) $_GET['Books_page'] - 1;
            Yii::app()->user->setState($uni_id . 'books-grid' . 'Books_page', $booksPage);
            unset($_GET['Books_page']);
        } elseif (isset($_GET['ajax']) && ($_GET['ajax'] == 'allbooks-grid') && isset($_GET['Books_page'])) {
            $booksPage = (int) $_GET['Books_page'] - 1;
            Yii::app()->user->setState($uni_id . 'allbooks-grid' . 'Books_page', $booksPage);
            unset($_GET['Books_page']);
        } elseif (isset($_GET['ajax'])) {
            Yii::app()->user->setState($uni_id . 'Books_page', 0);
            Yii::app()->user->setState($uni_id . 'books-grid' . 'Books_page', 0);
            Yii::app()->user->setState($uni_id . 'allbooks-grid' . 'Books_page', 0);
        }

        $this->render('books', array(
            'dataProvider' => $model,
            'pageSize' => $pageSize,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionPayments() {
        $model = new Payment('searchpayment');
        $model->unsetAttributes();  // clear any default values
        $total = 0;
        $start_date = $end_date = null;
        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . 'paymentPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'paymentPageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['Payment_page'])) {
            $paymentPage = (int) $_GET['Payment_page'] - 1;
            Yii::app()->user->setState('Payment_page', $paymentPage);
            unset($_GET['Payment_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('Payment_page', 0);
        }
        $payment = new Payment('filter');
        if (Yii::app()->user->hasState('paymentDiv')) {
            $uniqid = Yii::app()->user->getState('paymentDiv');
            if (Yii::app()->user->hasState($uniqid)) {
                $payment->range_date = Yii::app()->user->getState($uniqid);
                //Yii::app()->user->setState($uniqid, null);
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data["dataProvider"] = $model;
            $data["pageSize"] = $pageSize;
            if (isset($_GET['range'])) {
                $range = isset($_GET['range']) ? $_GET['range'] : isset($_POST['Payment']['range_date']) ? $_POST['Payment']['range_date'] : null;
                $ranges = explode(" - ", $range);
                $payment->range_date = $range;
                $start_date = isset($ranges[0]) ? $ranges[0] : null;
                $end_date = isset($ranges[1]) ? $ranges[1] : null;
                $uniqid = Yii::app()->user->getState('paymentDiv');
                if ((($start_date != null) && (!(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $start_date)))) || (($end_date != null) && (!(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $end_date))))) {
                    $start_date = $end_date = null;
                    Yii::app()->user->setState($uniqid, null);
                } else {
                    Yii::app()->user->setState($uniqid, $range);
                    $spieces1 = explode("/", $start_date);
                    if (checkdate($spieces1[0], $spieces1[1], $spieces1[2])) {
                        $date = DateTime::createFromFormat('m/d/Y', $start_date);
                        $start_date = $date->format('Y-m-d H:i:s');
                    }

                    $epieces2 = explode("/", $end_date);
                    if (checkdate($epieces2[0], $epieces2[1], $epieces2[2])) {
                        $date = DateTime::createFromFormat('m/d/Y', $end_date);
                        $end_date = $date->format('Y-m-d H:i:s');
                    }
                    if (($start_date != null) && ($end_date != null)) {
                        $criteria = new CDbCriteria;
                        $criteria->addBetweenCondition('payment_date', $start_date, $end_date, 'AND');
                        $_m_payments = Payment::model()->findAll($criteria);
                    }
                }
            }
            $data["total"] = $total;
            $data["start_date"] = $start_date;
            $data["end_date"] = $end_date;
            $data["model"] = $payment;

            //Yii::app()->clientScript->scriptMap['*.js'];
            $this->renderPartial('_payments', $data, false, true);
            Yii::app()->end();
        } 
        else {
            if (isset($payment->range_date)) {
                $ranges = explode(" - ", $payment->range_date);
                //var_dump($ranges);exit();
                $start_date = isset($ranges[0]) ? $ranges[0] : null;
                $end_date = isset($ranges[1]) ? $ranges[1] : null;

                $spieces1 = explode("/", $start_date);
                if (checkdate($spieces1[0], $spieces1[1], $spieces1[2])) {
                    $date = DateTime::createFromFormat('m/d/Y', $start_date);
                    $start_date = $date->format('Y-m-d H:i:s');
                }

                $epieces2 = explode("/", $end_date);
                if (checkdate($epieces2[0], $epieces2[1], $epieces2[2])) {
                    $date = DateTime::createFromFormat('m/d/Y', $end_date);
                    $end_date = $date->format('Y-m-d H:i:s');
                }

                if (($start_date != null) && ($end_date != null)) {
                    $criteria = new CDbCriteria;
                    $criteria->addBetweenCondition('payment_date', $start_date, $end_date, 'AND');
                    $criteria->order = 'payment_date DESC';
                    $_m_payments = Payment::model()->findAll($criteria);
                }
            }

            if (($start_date == null) || ($end_date == null)) {
                $_m_payments = Payment::model()->findAll(array('order' => 'payment_date ASC'));
            }

            foreach ($_m_payments as $_m_payment) {
                $start_date = ($start_date == null) ? $_m_payment->payment_date : $start_date;
                $end_date = $_m_payment->payment_date;
                $total = $total + $_m_payment->money_total;
            }
            // var_dump($start_date);var_dump($end_date);exit();
            if (!isset($payment->range_date)) {
                $payment->range_date = $start_date . ' - ' . $end_date;
            }
            $this->render('payments', array(
                'model' => $payment,
                'dataProvider' => $model,
                'pageSize' => $pageSize,
                'total' => $total,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));
        }
    }

    public function actionUpdateTotal() {
        $range = isset($_GET['range']) ? $_GET['range'] : null;
        $ranges = explode(" - ", $range);
        $total = 0;
        $start_date = isset($ranges[0]) ? $ranges[0] : null;
        $end_date = isset($ranges[1]) ? $ranges[1] : null;
        $spieces1 = explode("/", $start_date);
        if (checkdate($spieces1[0], $spieces1[1], $spieces1[2])) {
            $date = DateTime::createFromFormat('m/d/Y', $start_date);
            $start_date = $date->format('Y-m-d H:i:s');
        }

        $epieces2 = explode("/", $end_date);
        if (checkdate($epieces2[0], $epieces2[1], $epieces2[2])) {
            $date = DateTime::createFromFormat('m/d/Y', $end_date);
            $end_date = $date->format('Y-m-d H:i:s');
        }

        if (($start_date != null) && ($end_date != null)) {
            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('payment_date', $start_date, $end_date, 'AND');
            $_m_payments = Payment::model()->findAll($criteria);
        }
        else
            $_m_payments = Payment::model()->findAll();
        foreach ($_m_payments as $_m_payment) {
            $total = $total + $_m_payment->money_total;
        }
        $this->renderPartial('_total', array('total' => $total, 'start_date' => $start_date, 'end_date' => $end_date));
    }

    /**
     * Lists all models.
     */
    public function actionAjaxPayments() {
        $model = new Payment('searchpayment');
        $model->unsetAttributes();  // clear any default values

        $uni_id = ImageHelper::encrypt_text(Yii::app()->controller->id . '@' . Yii::app()->controller->action->id . '@' . get_class($model));
        $pageSize = Yii::app()->user->getState($uni_id . 'paymentPageSize', Yii::app()->params['defaultPageSize']);
        if (isset($_GET['pageSize'])) {
            $pageSize = (int) $_GET['pageSize'];
            Yii::app()->user->setState($uni_id . 'paymentPageSize', $pageSize);
            unset($_GET['pageSize']);
        }

        if (isset($_GET['Payment_page'])) {
            $paymentPage = (int) $_GET['Payment_page'] - 1;
            Yii::app()->user->setState('Payment_page', $paymentPage);
            unset($_GET['Payment_page']);
        } else if (isset($_GET['ajax'])) {
            Yii::app()->user->setState('Payment_page', 0);
        }
        $payment = new Payment('filter');
        if (Yii::app()->user->hasState('paymentDiv')) {
            $uniqid = Yii::app()->user->getState('paymentDiv');
            if (Yii::app()->user->hasState($uniqid)) {
                $payment->range_date = Yii::app()->user->getState($uniqid);
            }
        }
        if ((Yii::app()->request->isAjaxRequest)) {

            $data = array();
            $data["dataProvider"] = $model;
            $data["pageSize"] = $pageSize;

            if (isset($_GET['range'])) {
                $range = isset($_GET['range']) ? $_GET['range'] : isset($_POST['Payment']['range_date']) ? $_POST['Payment']['range_date'] : "";
                $ranges = explode(" - ", $range);
                $payment->range_date = $range;
                $start_date = isset($ranges[0]) ? $ranges[0] : null;
                $end_date = isset($ranges[1]) ? $ranges[1] : null;
                $uniqid = Yii::app()->user->getState('paymentDiv');
                if ((($start_date != null) && (!(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $start_date)))) || (($end_date != null) && (!(preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $end_date))))) {
                    $start_date = $end_date = null;
                    Yii::app()->user->setState($uniqid, null);
                } else {
                    Yii::app()->user->setState($uniqid, $range);
                }
            }
            $data["model"] = $payment;
            $this->renderPartial('_payments', $data, false, true);
            Yii::app()->end();
        }
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
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new OrderPayment('search');
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
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

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
     * Manages all models.
     */
    public function actionSuccess() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionFail() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionVerify() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('admin', array(
            'model' => $model,
        ));
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

}

