<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customer-form',
    'enableClientValidation' => true,
    'enableAjaxValidation'=>true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data',),
        ));
?>
<div class="re_form">
    <div>
        <span class="field-validation-valid" data-valmsg-for="ErrorMessage" data-valmsg-replace="true"></span>
    </div>
    <div class="row">
        <span class="row_L">EMAIL<font class="other_color_star">*</font></span>
        <?php echo $form->textField($model, 'email', array("class" => "text", "id" => "RegisterEmail", 'placeholder' => "Vào địa chỉ email@qcdn.com", 'autocomplete' => 'off', 'maxlength' => 128)); ?><br class="clean">
        <?php echo $form->error($model, 'email'); ?>
    </div>
    <div class="err_re">
        <span class="field-validation-valid" data-valmsg-for="RegisterEmail" data-valmsg-replace="true" id="emailValidationMessage"></span>
    </div>
    <div class="row">
        <span class="row_L">MẬT KHẨU<font class="other_color_star">*</font></span>
        <?php echo $form->passwordField($model, 'passwordSave', array("class" => "text", 'placeholder' => "Mật khẩu", 'maxlength' => 128)); ?>
    </div>
    <div class="err_re">
        <span class="field-validation-valid" data-valmsg-for="RegisterPassword" data-valmsg-replace="true"></span>
    </div>
    <div class="row">
        <span class="row_L" style="padding-top: 0 !important;">MẬT KHẨU<font class="other_color_star">*</font><br>
            <font style="font-size: 12px; color: #a9a9a9;">Nhập lại lần 2</font></span>
        <?php echo $form->passwordField($model, 'repeatPassword', array("class" => "text", 'placeholder' => "Nhập lại mật khẩu", 'maxlength' => 128)); ?><br class="clean">
    </div>
    <div class="err_re">
        <span class="field-validation-valid" data-valmsg-for="RetypePassword" data-valmsg-replace="true"></span>
    </div>
</div>
<div class="re_form1">
    <div class="row">
        <span class="row_L1">GIỚI TÍNH<font class="other_color_star">*</font></span>

        <select data-val="true" data-val-required="Vui lòng chọn giới tính" id="Gender" name="Gender"><option selected="selected" value="">--</option>
            <option value="0">Anh</option>
            <option value="1">Chị</option>
        </select>
    </div>
    <div class="row">
        <span class="row_L1">HỌ TÊN<font class="other_color_star">*</font></span>
        <?php echo $form->textField($mmodel,'lastname',array( "class"=>"text",'maxlength'=>64,"placeholder"=>"Họ tên")); ?>
        <?php echo $form->error($mmodel, 'lastname'); ?>
        <br class="clean">
    </div>
    <div class="err_re1">
        <span class="field-validation-valid" data-valmsg-for="Mobile" data-valmsg-replace="true"></span>
    </div>
    <div class="row">
        <span class="row_L1">NGÀY SINH<font class="other_color_star">*</font></span>
        <span>
            <select data-val="true" data-val-number="The field BirthDate_Day must be a number." data-val-range="The field BirthDate_Day must be between 1 and 31." data-val-range-max="31" data-val-range-min="1" data-val-required="The BirthDate_Day field is required." data-val-requiredifferent="" data-val-requiredifferent-param="0" id="BirthDate_Day" name="BirthDate_Day"><option selected="selected" value="0">Ngày</option>
                <?php for ($i = 0; $i <= 31; $i++) { ?>
                    <option value="<?= $i ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </span>&nbsp;&nbsp;<span>

            <select data-val="true" data-val-number="The field BirthDate_Month must be a number." data-val-range="The field BirthDate_Month must be between 1 and 12." data-val-range-max="12" data-val-range-min="1" data-val-required="The BirthDate_Month field is required." data-val-requiredifferent="" data-val-requiredifferent-param="0" id="BirthDate_Month" name="BirthDate_Month">
                <option selected="selected" value="">Tháng</option>
                <?php for ($i = 0; $i <= 12; $i++) { ?>
                    <option value="<?= $i ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </span>&nbsp;&nbsp;<span>
            <select data-val="true" data-val-number="The field BirthDate_Year must be a number." data-val-required="The BirthDate_Year field is required." data-val-requiredifferent="" data-val-requiredifferent-param="0" id="BirthDate_Year" name="BirthDate_Year"><option selected="selected" value="0">Năm</option>
                <?php echo $date = date("Y") - 12;
                for ($i = $date - 70; $i <= $date; $i++) { ?>
                    <option value="<?= $i ?>"><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </span>
        <br class="clean">
        <?php echo $form->error($mmodel, 'birthday'); ?>
    </div>
    <div class="err_re">
        <span class="field-validation-valid" data-valmsg-for="Birthday" data-valmsg-replace="true"></span>
    </div>
</div>
<div class="re_form_B">
    <p>
        <input checked="checked" data-val="true" data-val-requireacceptterms=" " data-val-requireacceptterms-param="title_item_note" data-val-required="The AcceptTerms field is required." id="AcceptTerms" name="AcceptTerms" value="true" type="checkbox">
        <span class="title_item_note2">&nbsp;&nbsp;Tôi đã xem và đồng ý với<a target="_blank" href=""> quy chế của sàn giao dịch</a> </span><span class="field-validation-valid" data-valmsg-for="AcceptTerms" data-valmsg-replace="true"></span>                </p>
</div>
<div>
    <p style="padding-top: 15px; text-align: left;">
        <input class="btn_register" value="" type="submit">
    </p>
</div>
<?php
$this->endWidget();
?>