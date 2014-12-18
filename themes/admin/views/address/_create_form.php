<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'address-form',
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
                    event.returnValue = 'You have made changes on this page that you have not yet confirmed. If you navigate away from this page you will lose your unsaved changes';
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
                if(confirm('We have validated your input and we are ready to save your data. Please click Ok to save or Cancel to return to input.'))
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
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'address', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your number home and street", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($model, 'district', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your district or zone", 'class' => 'span2', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
        
    <?php echo $form->dropDownListRow($model, 'RegionVN', Lookup::items('RegionVN'), array(
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
            ); ?>    
        
        <?php echo $form->dropDownListRow($model, 'city_id', CHtml::listData(City::model()->findAll(array('order' => 'city ASC')), 'id', 'city'), array('empty' => 'Select City or Province')) ?>



    <?php echo $form->textFieldRow($model, 'phone', array('prepend' => '<i class="icon-phone"></i>', 'placeholder' => "Enter your PHONE", 'class' => 'span2', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php echo $form->textFieldRow($model, 'email', array('prepend' => '<i class="icon-envelope"></i>', 'placeholder' => "Enter your email in here email@qcdn.com", 'class' => 'span4', 'autocomplete' => 'off', 'maxlength' => 128)); ?>
    <?php echo $form->textFieldRow($model, 'postal_code', array('prepend' => '<i class="icon-certificate"></i>', 'placeholder' => "Enter your postal code", 'class' => 'span1', 'autocomplete' => 'off', 'maxlength' => 128)); ?>

    <?php echo $form->dropDownListRow($model, 'categories', Lookup::items('CategoryAddress'), array('hint' => 'Click to change! Address Category')); ?>    
    <?php echo $form->dropDownListRow($model, 'verified', Lookup::items('verified'), array('hint' => 'Click to change! verify Category')); ?>    
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
