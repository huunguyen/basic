<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'order-form',
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
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>
<fieldset>
    <legend>
        <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>
        <?php echo $form->errorSummary($model); ?>
    </legend>    

    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_carrier', CHtml::listData(Carrier::model()->findAll($criteria), 'id_carrier', 'name'), array(
        'prompt' => 'Chọn Nhà Phân Phối',
            )
    );
    ?>  
    <?php echo $form->textFieldRow($model, 'reference', array('class' => 'span5', 'maxlength' => 9)); ?>

    <?php echo $form->textFieldRow($model, 'payment', array('class' => 'span5', 'maxlength' => 255)); ?>

    <?php
    echo $form->toggleButtonRow($model, 'gift', array(
        'enabledLabel' => 'Cho phép Quà tặng',
        'disabledLabel' => 'Không cho phép Quà tặng'
            )
    );
    ?>

    <?php echo $form->textAreaRow($model, 'gift_message', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

    <?php echo $form->textFieldRow($model, 'shipping_number', array('class' => 'span5', 'maxlength' => 32)); ?>

    <?php echo $form->textFieldRow($model, 'total_paid', array('class' => 'span5', 'maxlength' => 17, 'disabled' => true)); ?>

    <?php echo $form->textFieldRow($model, 'total_paid_real', array('class' => 'span5', 'maxlength' => 17, 'disabled' => true)); ?>

    <?php echo $form->textFieldRow($model, 'total_shipping', array('class' => 'span5', 'maxlength' => 17)); ?>

    <?php echo $form->textFieldRow($model, 'total_wrapping', array('class' => 'span5', 'maxlength' => 17)); ?>

    <?php echo $form->textFieldRow($model, 'invoice_number', array('class' => 'span5', 'maxlength' => 10)); ?>
    <?php
    echo $form->datepickerRow($model, 'invoice_date', array('hint' => 'Chọn ngày xuất hóa đơn.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value' => date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>

    <?php echo $form->textFieldRow($model, 'delivery_number', array('class' => 'span5', 'maxlength' => 10)); ?>
    <?php
    echo $form->datepickerRow($model, 'delivery_date', array('hint' => 'Chọn ngày Giao hàng.',
        'prepend' => '<i class="icon-calendar"></i>', 'options' => array('dateFormat' => 'dd/mm/yy', 'value' => date('dd/mm/yy'), 'viewMode' => 2, 'minViewMode' => 2, 'language' => 'vi',)));
    ?>
</fieldset>
<div class="form-actions">
   <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
