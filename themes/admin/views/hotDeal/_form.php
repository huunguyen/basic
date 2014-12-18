<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'product-form',
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

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->markdownEditorRow($model, 'description', array('class' => 'span8', 'height' => '100px')); ?>
<?php //if ($model->isNewRecord): ?>
    <?php
    echo $form->select2Row(
            $model, 'pp_giao_sp', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => array('Giao SP Tại Văn Phòng', 'Giao SP Tại Nhà Bạn', 'Giao Thẻ Tại Văn Phòng', 'Giao Thẻ Tại Nhà Bạn', 'Chuyển phát nhanh EMS'),
            'placeholder' => 'Chọn phương thức Giao Sản Phẩm',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>
      <?php
    echo $form->select2Row(
            $model, 'dc_giao_sp', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => array('Toàn Quốc', 'Hồ Chí Minh', 'Hà Nội', 'Đà Nẵng', 'Đồng Nai', 'Bình Dương'),
            'placeholder' => 'Chọn Vùng Hổ Trợ Giao Sản Phẩm',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>
    <?php
    echo $form->select2Row(
            $model, 'pp_thanhtoan', array(
        'asDropDownList' => false,
        'options' => array(
            'tags' => array('Thanh toán Tại Văn Phòng', 'Thanh toán Qua Chuyển Khoản', 'Thanh Toán Trực Tiếp Khi Nhận Hàng'),
            'placeholder' => 'Chọn Phương Thức Hổ Trợ Thanh Toán',
            'width' => '100%',
            'tokenSeparators' => array(';')
        )
            )
    );
    ?>
    <?php //endif; ?>
    
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