<?php $this->pageTitle = Yii::app()->name; ?>
<?php
$this->breadcrumbs = CMap::mergeArray($this->breadcrumbs,array(
    array('name' => 'Quản lý thành viên', 'url' => array('user/grid')),
    array('name' => 'mạng lưới'),
  ));
?>
 
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'type' => 'striped bordered condensed',
    'id' => 'payment-grid',
    'ajaxUpdate' => true, // This is it.
    'dataProvider' => $model->search(),
    'template' => '{summary}{items}{pager}',
    'enablePagination' => true,
    'summaryText' => 'Displaying {start}-{end} of {count} results.',
    'columns' => array(
        array(
            'id'=>'autoId',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50',   
        ),
        array('name' => 'order_reference', 'header' => 'Thông tin', 'htmlOptions' => array('style' => 'width: auto'),),
      
        array('name' => 'amount', 'header' => 'Khoản tiền', 'htmlOptions' => array('style' => 'width: auto'),),
        array('name' => 'amount_string', 'header' => 'Khoản tiền', 'htmlOptions' => array('style' => 'width: auto'),),
        
        array('name' => 'payment_method', 'header' => 'Phương thức thanh toán', 'htmlOptions' => array('style' => 'width: auto'),),
        array('name' => 'transaction_id', 'header' => 'Ma Giao Dich', 'htmlOptions' => array('style' => 'width: 50px'),),
        
        array('name' => 'card_number', 'header' => 'card_number', 'htmlOptions' => array('style' => 'width: 60px'),),        
        array('name' => 'card_brand', 'header' => 'card_brand', 'htmlOptions' => array('style' => 'width: 60px'),),        
        array('name' => 'card_expiration', 'header' => 'card_brand', 'htmlOptions' => array('style' => 'width: 60px'),),        
        array('name' => 'card_holder', 'header' => 'card_holder', 'htmlOptions' => array('style' => 'width: 60px'),),        
        
        array(
            'name' => 'date_add',
            'header' => 'Ngày thanh toán',
            'value' => '$data->date_add',
            'htmlOptions' => array('style' => 'width: 110px'),
        ),        
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'header' => 'Chức năng',
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("payment/view",array("id"=>$data["id_order_payment"]))',
            'updateButtonUrl' => 'Yii::app()->controller->createUrl("payment/update",array("id"=>$data["id_order_payment"]))',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("payment/delete",array("id"=>$data["id_order_payment"]))',
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
                    'url' => 'Yii::app()->createUrl("payment/payment", array("id"=>$data["id_order_payment"]))',
                    'options' => array(
                        'class' => 'view',
                    ),
                ), 
                'export' => array
                    (
                    'label' => 'Xuất file',
                    'icon' => 'user',
                    'url' => 'Yii::app()->createUrl("payment/export", array("id"=>$data["id_order_payment"]))',
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
                    'url' => 'Yii::app()->createUrl("payment/printer", array("id"=>$data["id_order_payment"]))',
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

<?php 
$cc = new ECCValidator();
$cc->format = array(ECCValidator::MASTERCARD, ECCValidator::VISA);
$card = '5500 0000 0000 0004';
echo 'MASTERCARD VALIDATION [5500 0000 0000 0004]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$card = '4539 6422 3195 9702';
echo 'VISA VALIDATION 16 [4539 6422 3195 9702]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
Yii::import('ext.validators.ECCValidator');
 
$cc = new ECCValidator();
$cc->format = ECCValidator::MASTERCARD;
$card = '5500 0000 0000 0004';
echo 'MASTERCARD VALIDATION [5500 0000 0000 0004]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::AMERICAN_EXPRESS;
$card = '3782 8224 6310 005';
echo 'American Express VALIDATION [3782 8224 6310 005]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::DINERS_CLUB;
$card = '3852 0000 0232 37';
echo 'DINERS CLUB VALIDATION [3852 0000 0232 37]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::JCB;
$card = '3088 5749 0496 7422';
echo 'JCB VALIDATION 16 [3088 5749 0496 7422]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
$card = '1800 9030 7342 009';
echo 'JCB VALIDATION 15 [1800 9030 7342 009]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::VISA;
$card = '4539 6422 3195 9702';
echo 'VISA VALIDATION 16 [4539 6422 3195 9702]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$card = '4929 857 283 556';
echo 'VISA VALIDATION 13 [4929 857 283 556]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
 
$cc->format = ECCValidator::DISCOVER;
$card = '6011 3379 3190 5012';
echo 'DISCOVER VALIDATION [6011 3379 3190 5012]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::VOYAGER;
$card = '8699 4096 4429 408';
echo 'VOYAGER VALIDATION [8699 4096 4429 408]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::ELECTRON;
$card = '4917300800000000';
echo 'VISA ELECTRON VALIDATION [4917300800000000]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::LASER;
$card = '6304 9000 1774 0292 441';
echo 'LASER VALIDATION 19 [6304 9000 1774 0292 441]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 
$cc->format = ECCValidator::LASER;
$card = '6304 9506 0000 0000 00';
echo 'LASER VALIDATION 18 [6304 9506 0000 0000 00]: '. ($cc->validateNumber($card)?'ok':'nok').'<br/>';
 

echo 'TESTING NAME ANTONIO RAMIREZ: '. ($cc->validateName('ANTONIO RAMIREZ')?'ok':'nok').'<br/>';

echo 'TESTING NAME ANTONIO RAMIREZ 56: '. ($cc->validateName('ANTONIO RAMIREZ 56')?'ok':'nok').'<br/>';
 
echo 'TESTING DATE 08/2015: '. ($cc->validateDate('08', 2015)?'ok':'nok').'<br/>';
echo 'TESTING DATE 08/2062: '. ($cc->validateDate(8, 2062)?'ok':'nok').'<br/>';
 
echo 'VALIDATING ALL [LASER]: '.($cc->validateAll('ANTONIO RAMIREZ', '6304 9506 0000 0000 00', '08', 2012)?'ok':'nok').'<br/>';