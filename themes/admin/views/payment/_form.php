<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'payment-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'beforeValidate' => "js:function(form) {
            return true;
        }",
        'afterValidate' => "js:function(form, data, hasError) {
            if(hasError) {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = 'Bạn đã nhập thông tin nhưng chưa lưu lại trên server. Nếu bạn rời khỏi trang này lúc này dữ liệu bạn mới nhập sẽ mất và không được lưu lại';
                    return event.returnValue;
                });
                return false;
            }
            else {
                jQuery(window).bind('beforeunload', function(event) {
                    event.stopPropagation();
                    event.returnValue = null;
                    return event.returnValue;
                });
                if(confirm('Dữ liệu bạn nhập đã chính xác. Bạn có muốn lưu thông tin này nhấn okie nếu không hãy nhân cancel.'))
                    return true;
                else
                    return false;
            }
        }"
    ),
        ));
?>

<fieldset>
    <legend></legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model, 'methodsofpayment', Lookup::items('MethodsOfPayment'), array('empty' => 'Phương thức thanh toán'), array('hint' => 'Chọn phương thức thanh toán')); ?>    
 <?php
 
 ?>
        <?php echo $form->textFieldRow($books, 'paymentkey', array('disabled' => isset($books->paymentkey)?true:false, 'class' => 'span5', 'maxlength' => 500)); ?>
     <?php echo $form->textFieldRow($books, 'shoppingcartkey', array('disabled' => true, 'class' => 'span5', 'maxlength' => 500)); ?>
    <?php echo $form->dropDownListRow($books, 'status', Lookup::items('BooksStatus'), array('disabled' => true)); ?>    
    
         <?php echo $form->textFieldRow($model, 'amount', array('disabled' => true, 'class' => 'span5')); ?>

    <?php echo $form->textFieldRow($model, 'amount_string', array('disabled' => true, 'class' => 'span5', 'maxlength' => 500)); ?>

    <?php 
    echo $form->datepickerRow($model, 'payment_date', array('prepend' => '<i class="icon-calendar"></i>', 'options' => array('format' => 'dd/mm/yyyy', 'viewMode' => 2, 'minViewMode' => 2)));
    ?>

    <?php echo $form->textFieldRow($model, 'extraofpayments', array('class' => 'span5')); ?>

    <?php echo $form->textFieldRow($model, 'extraofpayments_string', array('class' => 'span5', 'maxlength' => 500)); ?>

    <?php    
    echo $form->datepickerRow($model, 'extrapayment_date', array('prepend' => '<i class="icon-calendar"></i>', 'options' => array('format' => 'dd/mm/yyyy', 'viewMode' => 2, 'minViewMode' => 2)));
   ?>

    <?php echo $form->dropDownListRow($model, 'status', Lookup::items('PaymentStatus'), array('empty' => 'Trạng thái thanh toán'), array('hint' => 'Chọn trạng thái để xử lý')); ?>    
    <?php echo $form->ckEditorRow($model, 'transaction_info', array('disabled' => true, 'options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>
    <?php echo $form->ckEditorRow($model, 'log_update', array('options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>
<?php if( ($model->methodsofpayment != "FORCEPAYMENT") && ( ($books->status != "COMPLETED")||($books->status != "COMPLETED") ) ){ ?>
    <div class="form-actions">
        <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
    </div>
<?php } ?>
    <?php $this->endWidget(); ?>
