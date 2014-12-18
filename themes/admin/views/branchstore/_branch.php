<div style="clear:both;height: 10px;"></div>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'branch-form',
    'enableClientValidation' => true,
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'inlineErrors' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<fieldset>
    <legend></legend>
    <p class="note">Các trường đánh dấu <span class="required">*</span> yêu cầu phải được nhập.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 128)); ?>

    <?php
    echo $form->dropDownListRow($model, 'RegionVN', Lookup::items('RegionVN'), array(
        'prompt' => 'Select Region in Viet Nam',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateCities'),
            'dataType' => 'json',
            'data' => array('RegionVN' => 'js:this.value'),
            'success' => 'function(data) {
                            $("#Branchstore_city_id").html(data.dropDownCities);
                        }',
        )
            )
    );
    ?>    

    <?php echo $form->dropDownListRow($model, 'city_id', CHtml::listData(City::model()->findAll(array('order' => 'city ASC')), 'id', 'city'), array('empty' => 'Select City or Province')) ?>
    <?php
    $criteria = new CDbCriteria;
    $criteria->with = array('userdetail');
    $criteria->addInCondition('level', array(RoleHelper::STAFF, RoleHelper::ADMIN, RoleHelper::MANAGER));
    ?>
    <?php echo $form->dropDownListRow($model, 'manager_id', CHtml::listData(User::model()->findAll($criteria), 'id', 'username'), array('empty' => 'Chọn Người Quản Lý Cho Chi Nhánh')) ?>

    <?php echo $form->ckEditorRow($model, 'info', array('options' => array('fullpage' => 'js:true', 'class' => 'span5', 'width' => '100%', 'resize_maxWidth' => '100%', 'resize_minWidth' => '320'))); ?>

    <?php echo $form->fileFieldRow($model, 'attachfile'); ?>

</fieldset>

<fieldset>
    <?php echo $form->textFieldRow($address, 'address', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your number home and street", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($address, 'district', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your district or zone", 'class' => 'span2', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php
    echo $form->dropDownListRow($address, 'RegionVN', Lookup::items('RegionVN'), array(
        'prompt' => 'Select Region in Viet Nam',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateCities'),
            'dataType' => 'json',
            'data' => array('RegionVN' => 'js:this.value'),
            'success' => 'function(data) {
                            $("#Address_city_id").html(data.dropDownCities);
                        }',
        )
            )
    );
    ?>    

    <?php echo $form->dropDownListRow($address, 'city_id', CHtml::listData(City::model()->findAll(array('order' => 'city ASC')), 'id', 'city'), array('empty' => 'Select City or Province')) ?>

    <?php echo $form->textFieldRow($address, 'phone', array('prepend' => '<i class="icon-phone"></i>', 'placeholder' => "Enter your PHONE", 'class' => 'span2', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php echo $form->textFieldRow($address, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your email in here email@qcdn.com", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($address, 'postal_code', array('prepend' => '<i class="icon-certificate"></i>', 'placeholder' => "Mã bưu điện", 'class' => 'span1', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php echo $form->dropDownListRow($address, 'categories', Lookup::items('CategoryAddress'), array('hint' => 'Đây là địa chỉ chính của Chi Nhánh', 'disabled' => true,)); ?>    
    <?php echo $form->dropDownListRow($address, 'verified', Lookup::items('verified'), array('hint' => 'Địa chỉ được tạo bởi admin', 'disabled' => true,)); ?>    
</fieldset>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Lưu dữ liệu')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Nhập lại dữ liệu')); ?>
</div>
<?php $this->endWidget(); ?>

