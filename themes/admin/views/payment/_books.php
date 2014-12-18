<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
        ));
?>
<?php

$groupGridColumns = array(
    array('name' => 'paymentkey',
        'header' => 'Giỏ Hàng',
        'value' => '"<b>".$data->paymentkey."</b>"',
        'htmlOptions' => array('style' => 'width: 60px'),
        'type' => 'html',
    ),
    array(
        'name' => 'categories',
        'header' => 'Loại',
        'value' => 'Lookup::item("BooksCategories",$data->categories)',
        'htmlOptions' => array('style' => 'width: 100px'),
    ),
    array('name' => 'description',
        'header' => 'Mô tả',
        'value' => '$data->description.$data->info',
        'htmlOptions' => array('style' => 'width: auto'),
        'type' => 'html',
    ),
    array('name' => 'totalofmoney',
        'header' => 'Tổng tiền',
        'value' => '$data->totalofmoney." VND ~ ".round($data->totalofmoney / FinanceHelper::USDvsVND,2)." USD"',
        'htmlOptions' => array('style' => 'width: 150px'),
        'type' => 'html',
    ),
    array(
        'name' => 'status',
        'header' => 'Trạng thái',
        'value' => 'Lookup::item("BooksStatus",$data->status)',
        'htmlOptions' => array('style' => 'width: 100px'),
    ),
    array(
        'name' => 'create_date',
        'header' => 'Thanh toán',
        'value' => '$data->payment_date',
        'htmlOptions' => array('style' => 'width: 80px'),
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Chức năng',
        'template' => '{shoppingcart} {export} {ajax} {printer}',
        'buttons' => array
            (
            'shoppingcart' => array
                (
                'label' => 'Xem shopping cart',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-cart4.png',
                'url' => 'Yii::app()->createUrl("payment/viewbooks", array("id"=>$data["id"]))',
                'options' => array(
                    'class' => 'iconb',
                ),
            ),
            'export' => array
                (
                'label' => 'Xuất file',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-files.png',
                'url' => 'Yii::app()->createUrl("payment/exportBook", array("id"=>$data["id"]))',
                'options' => array(
                    'class' => 'iconb',
                ),
            ),
            'ajax' => array(
                    'label' => 'Gửi Email',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-email.png',
                    'url' => 'Yii::app()->createUrl("payment/sentEmail", array("id"=>$data->id,"m"=>"b") )',
                    'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này đến người dùng?')) return false;
                        }",
                ),
            'printer' => array
                (
                'label' => 'In Thông tin',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-printer.png',
                'url' => 'Yii::app()->createUrl("payment/printer", array("user_id"=>$data["id"]))',
                'options' => array(
                    'class' => 'iconb',
                ),
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: 70px',
        ),
    ),
);
$groupGridColumns[] = array(
    'name' => 'categories',
    'value' => 'Lookup::item("BooksCategories",$data->categories)',
    'headerHtmlOptions' => array('style' => 'display:none'),
    'htmlOptions' => array('style' => 'display:none')
);
$this->widget('bootstrap.widgets.TbGroupGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'books-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $dataProvider->searchpayment('COMPLETED'),
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Thống kê tài chánh đơn hàng [ĐÃ THANH TOÁN]. Hiển thị {start}-{end} của {count} kết quả.',
    'extraRowColumns' => array('categories'),
    'extraRowExpression' => '"<b style=\"font-size: 1.2em; color: #333;\">".Lookup::item("BooksCategories",$data->categories)."</b>"',
    'extraRowHtmlOptions' => array('style' => 'padding:4px'),
    'columns' => $groupGridColumns
));
?>




<?php

$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'allbooks-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $dataProvider->searchOtherPayment(),
    'template' => '{summary}{items}{pager}{extendedSummary}',
    'enablePagination' => true,
    'summaryText' => 'Thống kê TÀI CHÁNH Đơn Hàng [*]. Hiển thị {start}-{end} của {count} kết quả.',
    'columns' => array(
        array(
            'id' => 'autoId',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array('name' => 'paymentkey',
            'header' => 'Giỏ Hàng',
            'value' => '"<b>".$data->paymentkey."</b>"',
            'htmlOptions' => array('style' => 'width: 60px'),
            'type' => 'html',
        ),
        array(
            'name' => 'categories',
            'header' => 'Loại',
            'value' => 'Lookup::item("BooksCategories",$data->categories)',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array('name' => 'description',
            'header' => 'Mô tả',
            'value' => '$data->description.$data->info',
            'htmlOptions' => array('style' => 'width: auto'),
            'type' => 'html',
        ),
        array('name' => 'totalofmoney',
            'header' => 'Tổng tiền',
            'value' => '$data->totalofmoney." VND ~ ".round($data->totalofmoney / FinanceHelper::USDvsVND,2)." USD"',
            'htmlOptions' => array('style' => 'width: 150px'),
        ),
        array(
            'name' => 'status',
            'header' => 'Trạng thái',
            'value' => 'Lookup::item("BooksStatus",$data->status)',
            'htmlOptions' => array('style' => 'width: 60px'),
        ),
        array(
            'name' => 'create_date',
            'header' => 'Ngày Đặt',
            'value' => '$data->create_date',
            'htmlOptions' => array('style' => 'width: 110px'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Chức năng',
            'template' => '{shoppingcart} {payment} {paypal} {export} {ajax} {printer}',
            'buttons' => array
                (
                'shoppingcart' => array
                    (
                    'label' => 'Xem shopping cart',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/color/order.png',
                    'url' => 'Yii::app()->createUrl("payment/viewbooks", array("id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'iconb',
                    ),
                ),
                'payment' => array
                    (
                    'label' => 'Thanh toán',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/color/bank.png',
                    'url' => '($data["status"]=="NEW")?Yii::app()->createUrl("payment/payment", array("books_id"=>$data["id"])):Yii::app()->createUrl("payment/payment", array("books_id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'iconb',
                    ),
                    'encodeLabel' => false,
                ),
                'paypal' => array
                    (
                    'label' => 'Thanh toán trực tuyến',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/color/paypal.png',
                    'url' => 'Yii::app()->createUrl("paypal/view", array("books_id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'iconb',
                    ),
                    'encodeLabel' => false,
                ),
                'export' => array
                    (
                    'label' => 'Xuất file',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/color/billing.png',
                    'url' => 'Yii::app()->createUrl("payment/export", array("id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'iconb',
                    ),
                ),
                'ajax' => array(
                    'label' => 'Gửi Email',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/color/email.png',
                    'url' => 'Yii::app()->createUrl("payment/sentEmail", array("id"=>$data->id,"m"=>"b") )',
                    'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này đến người dùng?')) return false;
                        }",
                ),
                'printer' => array
                    (
                    'label' => 'In Thông tin',
                    'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/color/print.png',
                    'url' => 'Yii::app()->createUrl("payment/printer", array("user_id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'iconb',
                    ),
                ),
            ),
            'htmlOptions' => array(
                'style' => 'width: 215px',
            ),
        ),
    ),
    'extendedSummary' => array(
        'title' => 'Tổng số tiền (VND)',
        'columns' => array(
            'totalofmoney' => array('label' => 'Thành tiền (Việt nam đồng)', 'class' => 'TbSumOperation'),
        )
    ),
    'extendedSummaryOptions' => array(
        'class' => 'well pull-right',
        'style' => 'width:300px'
    ),
));
?>
<?php $this->endWidget(); ?>
