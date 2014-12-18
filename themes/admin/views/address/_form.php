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
$criteria5 = new CDbCriteria();
$criteria5->condition = "active>=:active";
$criteria5->params = array(":active" => 1);
$criteria5->order = 'date_add DESC';
echo $form->dropDownListRow($model, 'id_customer', CHtml::listData(Customer::model()->findAll($criteria5), 'id_customer', 'email'), array('prompt' => 'Chọn khách hàng')
);
?> 


<?php
$criteria6 = new CDbCriteria();
$criteria6->condition = "active>=:active";
$criteria6->params = array(":active" => 1);
$criteria6->order = 'name DESC';
echo $form->dropDownListRow($model, 'id_manufacturer', CHtml::listData(Manufacturer::model()->findAll($criteria6), 'id_manufacturer', 'name'), array(
    'prompt' => 'Chọn Nhà sản xuất',
        )
);
?>  

<?php
$criteria7 = new CDbCriteria();
$criteria7->condition = "active>=:active";
$criteria7->params = array(":active" => 1);
$criteria7->order = 'name DESC';
echo $form->dropDownListRow($model, 'id_supplier', CHtml::listData(Supplier::model()->findAll($criteria7), 'id_supplier', 'name'), array(
    'prompt' => 'Chọn Nhà cung cấp',
        )
);
?>  

<?php
$criteria8 = new CDbCriteria();
$criteria8->condition = "active>=:active";
$criteria8->params = array(":active" => 1);
$criteria8->order = 'name DESC';
echo $form->dropDownListRow($model, 'id_warehouse', CHtml::listData(Warehouse::model()->findAll($criteria8), 'id_warehouse', 'name'), array(
    'prompt' => 'Chọn Kho hàng',
        )
);
?> 

<?php
$criteria = new CDbCriteria();
$criteria->condition = "active>=:active";
$criteria->params = array(":active" => 1);
$criteria->order = 'email DESC';
echo $form->dropDownListRow($model, 'id_customer', CHtml::listData(Customer::model()->findAll($criteria), 'id_customer', 'email'), array('prompt' => 'Chọn khách hàng'));
?>  

<?php
$criteria2 = new CDbCriteria();
$criteria2->condition = "id_country=:id_country";
$criteria2->params = array(":id_country" => Config::ID_COUNTRY);
echo $form->dropDownListRow($model, 'id_city', CHtml::listData(City::model()->findAll($criteria2), 'id_city', 'name'), array('prompt' => 'Chọn Tỉnh | Thành phố',
    'ajax' => array(
        'type' => 'POST',
        'url' => CController::createUrl('getDistricts'),
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
        'url' => CController::createUrl('getWards'),
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

<?php echo $form->textFieldRow($model, 'lastname', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'firstname', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textFieldRow($model, 'address1', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'address2', array('class' => 'span5', 'maxlength' => 128)); ?>

<?php echo $form->textFieldRow($model, 'company', array('class' => 'span5', 'maxlength' => 32)); ?>

<?php echo $form->textAreaRow($model, 'other', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5', 'maxlength' => 16)); ?>

<?php echo $form->textFieldRow($model, 'phone_mobile', array('class' => 'span5', 'maxlength' => 16)); ?>

<?php echo $form->textFieldRow($model, 'active', array('class' => 'span5')); ?>

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
