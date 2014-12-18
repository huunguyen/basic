<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'thread-form',
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

    <?php echo $form->errorSummary($model); ?>

    <?php
    $criteria = new CDbCriteria();
    $criteria->order = 'position DESC';
    echo $form->dropDownListRow($model, 'id_contact', CHtml::listData(Contact::model()->findAll($criteria), 'id_contact', 'name'), 
            array('prompt' => 'Chọn phòng ban')
            );
    ?>   

    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'email DESC';
    echo $form->dropDownListRow($model, 'id_customer', CHtml::listData(Customer::model()->findAll($criteria), 'id_customer', 'email'), 
            array('prompt' => 'Chọn khách hàng',
                'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('getOrders'),
            'dataType' => 'json',
            'data' => array('id_customer' => 'js:this.value'),
            'success' => 'function(data) {                            
                            console.log(data);
                            $("#CustomerThread_id_order").html(data.dropDownOrder);
                            if(flag){
                                  $("#CustomerThread_id_order").change();   
                            }
                            else 
                            {
                                  flag =true;   
                                  $("#CustomerThread_id_order").val(' . $model->id_order . ');
                            }                            
                        }',
            'cache' => false
        )
                )
            );
    ?>  
    
    <?php 
    $criteria2 = new CDbCriteria();
    $criteria2->condition = "id_customer=:id_customer";
    $criteria2->params = array(":id_customer" => $model->id_customer);
    echo $form->dropDownListRow($model, 'id_order', CHtml::listData(Orders::model()->findAll($criteria2), 'id_order', 'secure_key'), 
            array('prompt' => 'Chọn đơn hàng',
                'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('getProducts'),
            'dataType' => 'json',
            'data' => array('id_order' => 'js:this.value'),
            'success' => 'function(data) {                            
                            console.log(data);
                            $("#CustomerThread_id_product").html(data.dropDownProduct);
                            if(flag){
                                  $("#CustomerThread_id_product").change();   
                            }
                            else 
                            {
                                  flag =true;   
                                  $("#CustomerThread_id_product").val(' . $model->id_product . ');
                            }                            
                        }',
            'cache' => false
        )
                )
            );?>
    
<?php 
$criteria3 = new CDbCriteria();
$criteria3->condition = "id_order=:id_order";
$criteria3->params = array(":id_order" => $model->id_order);
echo $form->dropDownListRow($model, 'id_product', CHtml::listData(OrderDetail::model()->findAll($criteria3), 'id_product', 'idProduct.name'), 
            array('prompt' => 'Chọn sản phẩm')
            );?>
    	
<?php
    echo $form->dropDownListRow($model, 'status', Lookup::items('ThreadStatus'), array('prompt' => 'Chọn trạng thái cho luồng thảo luận'));
    ?>  
	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>
    

</fieldset>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'icon' => 'ok white',
        'label' => $model->isNewRecord ? 'Tạo mới' : 'Lưu lại',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">var flag = false;</script>
<?php
Yii::app()->clientScript->registerScript(
        'update-javascript', '$(document).ready(function() {   
        $("#' . CHtml::activeId($model, 'id_customer') . '").change();
    });'
);
?>