<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'payment-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $dataProvider->search(),
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Displaying {start}-{end} of {count} results.',
    'columns' => array(
        array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50',   
        ),
        array('name' => 'transaction_info', 'header' => 'Thông tin', 'htmlOptions' => array('style' => 'width: auto'),),
      
        array('name' => 'amount', 'header' => 'Khoản tiền', 'htmlOptions' => array('style' => 'width: auto'),),
        array('name' => 'amount_string', 'header' => 'Khoản tiền', 'htmlOptions' => array('style' => 'width: auto'),),
        
        array('name' => 'Extraofpayments', 'header' => 'bổ sung', 'htmlOptions' => array('style' => 'width: auto'),),
        array('name' => 'Extraofpayments_string', 'header' => 'bổ sung', 'htmlOptions' => array('style' => 'width: auto'),),
        
        array('name' => 'methodsofpayment', 'header' => 'Phương thức thanh toán', 'htmlOptions' => array('style' => 'width: auto'),),
        array('name' => 'status', 'header' => 'Trạng thái', 'htmlOptions' => array('style' => 'width: 50px'),),
        
        array('name' => 'status', 'header' => 'Trạng thái', 'htmlOptions' => array('style' => 'width: 60px'),),        
        array(
            'name' => 'payment_date',
            'header' => 'Ngày thanh toán',
            'value' => '$data->create_time',
            'htmlOptions' => array('style' => 'width: 110px'),
        ),        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Chức năng',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("payment/view",array("id"=>$data["id"]))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("payment/update",array("id"=>$data["id"]))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("payment/delete",array("id"=>$data["id"]))',
            'htmlOptions' => array('style' => 'width: 80px'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Phần phụ',
            'template' => '{payment} {export} {ajax} {printer}',
            'buttons' => array
                (
                'payment' => array
                    (
                    'label' => 'Thanh toán',
                    'icon' => 'user',
                    'url' => 'Yii::app()->createUrl("payment/payment", array("id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'view',
                    ),
                ), 
                'export' => array
                    (
                    'label' => 'Xuất file',
                    'icon' => 'user',
                    'url' => 'Yii::app()->createUrl("payment/export", array("id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'view',
                    ),
                ),                               
                'ajax' => array(
                    'label' => 'Gửi Email',
                    'icon' => 'email',
                    'url' => 'Yii::app()->createUrl("payment/ajaxSentEmail", array("id"=>$data->id) )',
                    'click' => "function() {
                        if(!confirm('Bạn muốn gửi thông tin này đến người dùng?')) return false;
                        $.fn.yiiGridView.update('payment-grid', {
                            type:'POST',
                            url:$(this).attr('href'),
                            success:function(text,status) {
                            $.fn.yiiGridView.update('payment-grid');
                        }
                        });
                        return false;
                        }",
                ),
                'printer' => array
                    (
                    'label' => 'In Thông tin',
                    'icon' => 'printer',
                    'url' => 'Yii::app()->createUrl("payment/printer", array("user_id"=>$data["id"]))',
                    'options' => array(
                        'class' => 'view',
                    ),
                ), 
            ),
            'htmlOptions' => array(
                'style' => 'width: 80px',
            ),
        ),
    ),
        //'beforeAjaxUpdate' => 'js:function(id) {alert("before");}',
        //'afterAjaxUpdate' => 'js:function(id, data) {alert("after");}',
));
?>
<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('payment-grid');
}
</script>
<?php echo CHtml::ajaxSubmitButton('Filter',array('user/ajaxupdate'), array(),array("style"=>"display:none;")); ?>

<?php echo CHtml::ajaxSubmitButton('TT INACTIVE',array('user/ajaxupdate','act'=>'doINACTIVE'), array('success'=>'reloadGrid'),array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton('TT ACTIVE',array('user/ajaxupdate','act'=>'doACTIVE'), array('success'=>'reloadGrid'),array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton('TT REMOVED',array('user/ajaxupdate','act'=>'doREMOVED'), array('success'=>'reloadGrid'),array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton('TT BANNED',array('user/ajaxupdate','act'=>'doBANNED'), array('success'=>'reloadGrid'),array('class' => "buttonS bLightBlue")); ?>
<?php echo CHtml::ajaxSubmitButton('TT BYPASS',array('user/ajaxupdate','act'=>'doBYPASS'), array('success'=>'reloadGrid'),array('class' => "buttonS bLightBlue")); ?>

<?php echo CHtml::ajaxSubmitButton('Cập nhật data',array('user/ajaxupdate','act'=>'doSortOrder'), array('success'=>'reloadGrid'),array('class' => "buttonS bLightBlue")); ?>
    <?php $this->endWidget(); ?>
