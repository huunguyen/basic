<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
        ));
?>
<?php
$groupGridColumns = array(
    array(
        'name' => 'name',
        'header' => 'Tên chi nhánh',
        'value' => '"<b>".$data->name."</b>"',
        'htmlOptions' => array('style' => 'width: 100px'),
        'type' => 'html',
    ),
    array('name' => 'address_id',
        'header' => 'Địa chỉ',
        'value' => '$data->address_store',
        'htmlOptions' => array('style' => 'width: auto'),
        'type' => 'html',
    ),
    array('name' => 'manager_id',
        'header' => 'Người Quản Lý',
        'value' => '$data->man_name',
        'htmlOptions' => array('style' => 'width: 100px'),
        'type' => 'html',
    ),
    array(
        'name' => 'last_update',
        'header' => 'TGĐK TLCN',
        'value' => '$data->last_update',
        'htmlOptions' => array('style' => 'width: 60px'),
    ),
    array('name' => 'city_id',
        'header' => 'Tỉnh thành',
        'value' => '$data->provinder->city',
        'htmlOptions' => array('style' => 'width: 80px'),
        'type' => 'html',
    ),
    array(
        'name' => 'total_revenue_balance',
        'header' => 'Tổng thu nhập',
        'value' => '$data->total_revenue_balance',
        'htmlOptions' => array('style' => 'width: 120px'),
        'type' => 'number'
    ),
    array(
        'name' => 'total_expected_revenue_balance',
        'header' => 'Tổng dự kiến',
        'value' => '$data->total_expected_revenue_balance',
        'htmlOptions' => array('style' => 'width: 120px'),
        'type' => 'number'
    ),
    array(
        'name' => '',
        'header' => 'KTGTK ĐVT&VBC',
        'value' => '$data->start_payment_date."<br/>".$data->end_payment_date',
        'htmlOptions' => array('style' => 'width: 60px'),
        'type' => 'html',
    ),
    array(
        'class' => 'bootstrap.widgets.TbButtonColumn',
        'header' => 'Cài Đặt',
        'template' => '{update}<div class="clear"></div> {ajax}<div class="clear"></div> {printer}',
        'buttons' => array
            (
            'update' => array
                (
                'label' => 'Cập nhật',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-cart4.png',
                'url' => 'Yii::app()->createUrl("branchstore/update", array("id"=>$data["id"]))',
                'options' => array(
                    'class' => 'iconb',
                ),
            ),
            'ajax' => array(
                'label' => 'Gửi Tin Đến Người Quản Lý',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-email.png',
                'url' => 'Yii::app()->createUrl("branchstore/sentEmail", array("id"=>$data->id) )',
                'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này đến người người Quản Trị Chi Nhánh Này?')) return false;
                        }",
            ),
            'printer' => array
                (
                'label' => 'In Thông tin',
                'imageUrl' => Yii::app()->request->baseUrl . '/images/icons/usual/icon-printer.png',
                'url' => 'Yii::app()->createUrl("branchstore/printer", array("user_id"=>$data["id"]))',
                'options' => array(
                    'class' => 'iconb',
                ),
            ),
        ),
        'htmlOptions' => array(
            'style' => 'width: auto; text-align: center; padding: 0px; margin: 0px',
        ),
    ),
);
$groupGridColumns[] = array(
    'name' => 'provinder.style',
    'value' => '$data->provinder->style',
    'headerHtmlOptions' => array('style' => 'display:none'),
    'htmlOptions' => array('style' => 'display:none')
);
$this->widget('bootstrap.widgets.TbGroupGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'books-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $dataProvider->searchadmin(),
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Thống kê Tài chánh - Chi Nhánh. Hiển thị {start}-{end} của {count} kết quả.',
    'extraRowColumns' => array('provinder.style'),
    'extraRowExpression' => '"<b style=\"font-size: 1.2em; color: #333;\">".$data->provinder->style."</b>"',
    'extraRowHtmlOptions' => array('style' => 'padding:4px'),
    'columns' => $groupGridColumns
));
?>
<?php $this->endWidget(); ?>
