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
<p class="help-block">Các trường có dấu <span class="required">*</span> phải được nhập.</p>

<?php echo $form->errorSummary($model); ?>

 <?php
 $criteria = new CDbCriteria();
$criteria->select = 'style';
$criteria->group = 'style';
$criteria->order = 'style DESC';
    echo $form->dropDownListRow($model, 'style', CHtml::listData(City::model()->findAll($criteria), 'style', 'style_name'), 
            array(
        'prompt' => 'Chọn Vùng Hổ Trợ',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('address/updateCities'),
            'dataType' => 'json',
            'data' => array('style' => 'js:this.value'),
            'success' => 'function(data) {                            
                          console.log(data);
                          $("#Address_id_city").html(data.dropDown);
                           if(flag){
                                $("#Address_id_city").change();                            
                            }
                            else {
                            flag =true;
                            $("#Address_id_city").val(' . $model->id_city . ');
                            }
                        }',
            'cache' => false
        )
            )
    );
    ?>     

<?php
$criteria2 = new CDbCriteria();
$criteria2->condition = "id_country=:id_country";
$criteria2->params = array(":id_country" => Config::ID_COUNTRY);
echo $form->dropDownListRow($model, 'id_city', CHtml::listData(City::model()->findAll($criteria2), 'id_city', 'name'), array('prompt' => 'Chọn Tỉnh | Thành phố',
    'ajax' => array(
        'type' => 'POST',
        'url' => CController::createUrl('address/getDistricts'),
        'dataType' => 'json',
        'data' => array('id_city' => 'js:this.value'),
        'success' => 'function(data) {                            
                            console.log(data);
                            $("#Address_id_district").html(data.dropDownDistrict);
                            if(flag){
                                  $("#Address_id_district").change();   
                            }
                            else 
                            {
                                  flag =true;   
                                  $("#Address_id_district").val(' . $model->id_district . ');
                            }                            
                        }',
        'cache' => false
    )
        )
);
?>

<?php
$criteria3 = new CDbCriteria();
$criteria3->condition = "id_city=:id_city";
$criteria3->params = array(":id_city" => $model->id_city);
echo $form->dropDownListRow($model, 'id_district', CHtml::listData(District::model()->findAll($criteria3), 'id_district', 'name'), array('prompt' => 'Chọn Quận | Huyện',
    'ajax' => array(
        'type' => 'POST',
        'url' => CController::createUrl('address/getWards'),
        'dataType' => 'json',
        'data' => array('id_district' => 'js:this.value'),
        'success' => 'function(data) {                            
                            console.log(data);
                            $("#Address_id_ward").html(data.dropDownWard);
                            if(flag){
                                  $("#Address_id_ward").change();   
                            }
                            else 
                            {
                                  flag =true;   
                                  $("#Address_id_ward").val(' . $model->id_ward . ');
                            }                            
                        }',
        'cache' => false
    )
        )
);
?>

<?php
$criteria4 = new CDbCriteria();
$criteria4->condition = "id_district=:id_district";
$criteria4->params = array(":id_district" => $model->id_district);
echo $form->dropDownListRow($model, 'id_ward', CHtml::listData(Ward::model()->findAll($criteria4), 'id_ward', 'name'), array('prompt' => 'Chọn Phường | Xã'));
?>

<?php echo $form->textFieldRow($model, 'fullname', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'address1', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'address2', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'company', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5', 'maxlength' => 16)); ?>

<?php echo $form->textFieldRow($model, 'mobile', array('class' => 'span5', 'maxlength' => 16)); ?>

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
Yii::app()->clientScript->registerScript(
  'update-javascript',
  '$(document).ready(function() {   
        $("#'.CHtml::activeId($model, 'id_city').'").change();
    });'
);
?>

