<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'attribute-group-form',
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
    $criteria->select = 'id_attribute_group, name';
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_attribute_group', CHtml::listData(AttributeGroup::model()->findAll($criteria), 'id_attribute_group', 'name'), array(
        'prompt' => 'Chọn Nhóm Thuộc Tính',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('isColorGroup'),
            'dataType' => 'json',
            'data' => array('id_attribute_group' => 'js:this.value'),
            'success' => 'function(data) {                            
                          console.log(data);
                           if(data.rs){                                
                            $( "#Attribute_color" ).prop( "disabled", false );
                            $( ".colorPicker-picker" ).show();                            
                           }
                           else
                           {
                            $( "#Attribute_color" ).prop( "disabled", true );
                            $( ".colorPicker-picker" ).hide();      
                            }
                        }',
            'cache' => false
        )
            )
    );
    ?> 
<?php
//    echo $form->colorpickerRow($model, 'color');
    ?>
    <div class="control-group ">
        <label class="control-label" for="Attribute_color">Color</label>
        <div class="controls">
            <?php
            $this->widget('common.extensions.colorpicker.ColorPicker', array(
                'model' => $model,
                'attribute' => 'color',
                'options' => array(// Optional
                    'pickerDefault' => "ccc", // Configuration Object for JS
                ),
            ));
            ?>
        </div>
    </div>

    <?php //  echo $form->textFieldRow($model, 'color', array('class' => 'span5', 'maxlength' => 32));  ?>   
    
<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 45)); ?>
    
    <?php echo $form->textFieldRow($model, 'position', array('class' => 'span5', 'maxlength' => 10)); ?>

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
<?php
//Yii::app()->clientScript->registerScript(
//        'update-javascript', '$(document).ready(function() {   
//        $("#' . CHtml::activeId($model, 'id_attribute_group') . '").change();
//    });'
//);
?>