<?php
$uniqid = Yii::app()->user->getState('paymentDiv');
if (isset($model->range_date) && (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})(\s+)-(\s+)([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $model->range_date))) {
    $ranges = explode(" - ", $model->range_date);
    $start_date = isset($ranges[0]) ? $ranges[0] : null;
    $end_date = isset($ranges[1]) ? $ranges[1] : null;
    if (!preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $start_date) || !preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $end_date)) {
        $start_date = $end_date = null;
    }
}
?>
<div class="fluid">
    <div class="grid12">
        <?php
        $this->widget('bootstrap.widgets.TbExtendedGridView', array(
            'type' => 'striped bordered condensed',
            'id' => 'payment-grid',
            'ajaxUpdate' => true, // This is it.
            'dataProvider' => ( ($start_date == null) || ($end_date == null)) ? $dataProvider->searchpayment() : $dataProvider->searchpayment($start_date, $end_date),
            'template' => '{summary}{items}{pager}{extendedSummary}',
            'enablePagination' => true,
            'summaryText' => 'Thống kê Tài chánh. Hổ Trợ Bộ Lọc Theo Ngày Tháng. Hiển thị từ {start}-{end} của {count} kết quả.',
            'columns' => array(
                array(
                    'id' => 'autoId',
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '50',
                ),
                array('name' => 'amount', 'header' => 'Tiền TT Giỏ hàng',
                    'htmlOptions' => array('style' => 'width: auto'),
                    'type' => 'number',
                ),
                array('name' => 'amount_string',
                    'header' => 'Bằng chữ',
                    'htmlOptions' => array('style' => 'width: auto'),
                    'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
                ),
                array('name' => 'extraofpayments', 'header' => 'Tiền Bổ Sung',
                    'htmlOptions' => array('style' => 'width: auto'),
                    'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
                    'type' => 'number',
                ),
                array('name' => 'money_total', 'header' => 'Tổng tiền thanh toán',
                    'htmlOptions' => array('style' => 'width: auto'),
                    'type' => 'number',
                ),
                array(
                    'name' => 'last_update',
                    'header' => 'Ngày TT BS CN',
                    'value' => '"<b>pd:</b>".$data->payment_date."<br/><b>epd:</b>".$data->extrapayment_date."<br/><b>lu:</b>".$data->last_update',
                    'htmlOptions' => array('style' => 'width: 80px'),
                    'type' => 'raw',
                    'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
                ),
                array(
                    'name' => 'methodsofpayment',
                    'header' => 'Hình thức Thanh toán',
                    'value' => 'Lookup::item("MethodsOfPayment",$data->methodsofpayment)',
                    'htmlOptions' => array('style' => 'width: 80px'),
                    'visible' => in_array($this->browser['platform'], array('iphone', 'ipod', 'ipad')) ? false : true,
                ),
                array(
                    'name' => 'status',
                    'header' => 'Trạng thái',
                    'value' => 'Lookup::item("PaymentStatus",$data->status)',
                    'htmlOptions' => array('style' => 'width: 80px'),
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'header' => 'Quản trị',
                    'template' => '{view} {modify} {export} {ajax} {print_act}',
                    'buttons' => array
                        (
                        'view' => array
                            (
                            'label' => 'Thanh toán chi tiết',
                            'icon' => 'icon-eye-close',
                            'url' => 'Yii::app()->createUrl("payment/viewbooks", array("id"=>$data["books_id"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                        'modify' => array
                            (
                            'label' => 'Bổ sung Thanh toán',
                            'icon' => 'tasks',
                            'url' => 'Yii::app()->createUrl("payment/payment", array("books_id"=>$data["books_id"],"id"=>$data["id"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                            'encodeLabel' => false,
                        ),
                        'export' => array
                            (
                            'label' => 'Xuất file',
                            'icon' => 'list',
                            'url' => 'Yii::app()->createUrl("payment/exportPayment", array("id"=>$data["id"]))',
                            'options' => array(
                                'class' => 'iconb',
                            ),
                        ),
                        'ajax' => array(
                            'label' => 'Gửi Email',
                            'icon' => 'email',
                            'url' => 'Yii::app()->createUrl("payment/sentEmail", array("id"=>$data["id"],"m"=>"p") )',
                            'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này đến người dùng?')) return false;
                        }",
                        ),
                        'print_act' => array
                            (
                            'label' => 'In thông tin',
                            'icon' => 'print',
                            'url' => 'Yii::app()->createUrl("post/printAct", array("id"=>$data["id"]))',
                            'options' => array(
                                'class' => 'view',
                            ),
                        ),
                    ),
                    'htmlOptions' => array(
                        'style' => 'width: 140px',
                    ),
                )
            ),
            'extendedSummary' => array(
                'title' => 'Tổng số tiền',
                'columns' => array(
                    'money_total' => array('label' => 'Thành tiền', 'class' => 'TbSumOperation'),
                    'methodsofpayment' => array(
                        'label' => 'Các hình thức thanh toán',
                        'types' => array(
                            'CreditCards' => array('label' => 'CreditCards'),
                            'BankTransfer' => array('label' => 'BankTransfer'),
                            'CashPayment' => array('label' => 'CashPayment'),
                            'OnlinePayment' => array('label' => 'OnlinePayment')
                        ),
                        'class' => 'TbCountOfTypeOperation'
                    ),
                )
            ),
            'extendedSummaryOptions' => array(
                'class' => 'well pull-right',
                'style' => 'width:300px'
            ),
                //'beforeAjaxUpdate' => 'js:function(id) {alert("before");}',
                //'afterAjaxUpdate' => 'js:function(id, data) {alert("after");}',
        ));
        ?>
    </div>
</div>
<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('payment-grid');
    }
</script>   
<div style="clear:both;height: 10px;"></div>
<div class="fluid">    
    <div class="widget grid12"  id="total">
        <?php
        // trường hợp search all
        if (!preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", $start_date) || !preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/", $end_date)) {
            if (preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $start_date) && preg_match("/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/", $end_date)) {
                $date = DateTime::createFromFormat('m/d/Y', $start_date);
                $start_date = $date->format("d/m/Y");
                $date = DateTime::createFromFormat('m/d/Y', $end_date);
                $end_date = $date->format("d/m/Y");
            }
            else
                $start_date = $end_date = null;
        }
        echo $this->renderPartial('_total', array('total' => $total, 'start_date' => $start_date, 'end_date' => $end_date));
        ?> 
    </div>
</div>
