<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'feature-form',
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
    foreach ($list as $count=>$featurevalue) {
        echo $form->dropDownListRow($featurevalue, "[$count]id_feature_value", CHtml::listData(FeatureValue::model()->searchByFeatureId($featurevalue->id_feature)->getData(), 'id_feature_value', 'value'), array(
            'prompt' => 'Chọn Gía Trị',
            'id' => 'FeatureValue_id_feature_value_' . $count,
            'onchange' => '$(function(){'
            . 'var conceptName = $("#FeatureValue_id_feature_value_' . $count . '").find(":selected").text();'
            . 'var conceptValue = $("#FeatureValue_id_feature_value_' . $count . '").val();'
            . 'if((conceptValue!="")||(conceptName!="Chọn Gía Trị")){'
            . '$("#FeatureValue_newvalue_' . $count . '").val("");'
            . '}'
            . '});'
                )
        );
        echo $form->textFieldRow($featurevalue, "[$count]newvalue", array('prepend' => '<i class="icon-edit"></i>',
            'placeholder' => "Vào Giá Trị Chưa Được Định Nghĩa",
            'class' => 'span4',
            'autocomplete' => 'off',
            'maxlength' => 128,
            'id' => 'FeatureValue_newvalue_' . $count,
            'onchange' => '$(function(){'
            . 'var conceptName = $("#FeatureValue_newvalue_' . $count . '").val();'
            . 'if(conceptName!=""){ '
            . '$("#FeatureValue_id_feature_value_' . $count . '").val("");'
            . '$("#FeatureValue_id_feature_value_' . $count . '").change();'
            . '}'
            . '});'
                )
        );
    }
    ?>

</fieldset>
<div class="form-actions">
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'primary',
    'label' => $model->isNewRecord ? 'Create' : 'Save',
));
?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    var pattern = /\d+/;
</script>