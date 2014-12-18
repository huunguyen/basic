<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'dist-form',
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
     <p class="help-block">Các trường có dấu <span class="required">*</span> phải được nhập.</p>

<?php echo $form->errorSummary($model); ?>
 </legend>
    

<?php 
$city = City::model()->findByPk($model->id_city);
    if(!isset($model->id_city) || ($city==null)) {
 $criteria = new CDbCriteria();
$criteria->select = 'style';
$criteria->group = 'style';
$criteria->order = 'style DESC';
    echo $form->dropDownListRow($model, 'style', CHtml::listData(City::model()->findAll($criteria), 'style', 'style_name'), 
            array(
        'prompt' => 'Chọn Vùng Hổ Trợ',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('updateCities'),
            'dataType' => 'json',
            'data' => array('style' => 'js:this.value'),
            'success' => 'function(data) {                            
                          console.log(data);
                          $("#District_id_city").html(data.dropDown);
                           if(flag){
                                $("#District_id_city").change();                            
                            }
                            else {
                            flag =true;
                            $("#District_id_city").val(' . $model->id_city . ');
                            }
                        }',
            'cache' => false
        )
            )
    );
  
    echo $form->dropDownListRow($model, 'id_city', CHtml::listData(
                    City::model()->findAll(
                            array('order' => 'style',
                                'condition' => 'active>=:active',
                                'params' => array(':active' => 1)
                            )
                    ), 'id_city', 'name'), 
            array('prompt' => 'Chọn thành phố | tỉnh thành')
    );
    }
    else
        {
        echo $form->textFieldRow($model, 'id_city', array('prepend' => '<i class="icon-task"></i>', 'placeholder' => "Vào địa chỉ email@qcdn.com", 'class' => 'span5', 'autocomplete' => 'off', 'maxlength' => 128, 'disabled' => true));
    }
    ?>
<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>
	    <?php echo $form->textFieldRow($model,'iso_code',array('class'=>'span5','maxlength'=>7)); ?>
   
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
<script type="text/javascript">var flag = false;</script>
<?php
if(!isset($model->id_city) || ($city==null)){
    Yii::app()->clientScript->registerScript(
        'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($model, 'style') . '").change();
    });'
);
}

?>