<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'message-form',
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
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'email DESC';
    echo $form->dropDownListRow($model, 'id_customer', CHtml::listData(Customer::model()->findAll($criteria), 'id_customer', 'email'), array(
        'prompt' => 'Chọn khách hàng',
        'ajax' => array(
            'type' => 'POST',
            'url' => CController::createUrl('getCartsOrders'),
            'dataType' => 'json',
            'data' => array('id_customer' => 'js:this.value'),
            'success' => 'function(data) {                            
                            console.log(data);
                            $("#Message_id_cart").html(data.dropDownCart);
                            $("#Message_id_order").html(data.dropDownOrder);
                            if(flag){
                                  $("#Message_id_cart").change();   
                                  $("#Message_id_order").change();   
                            }
                            else 
                            {
                                  flag =true;   
                                  $("#Message_id_cart").val(' . $model->id_cart . ');
                                  $("#Message_id_order").val(' . $model->id_order . ');
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
    echo $form->dropDownListRow($model, 'id_cart', CHtml::listData(Cart::model()->findAll($criteria2), 'id_cart', 'secure_key'), array('prompt' => 'Chọn giỏ hàng'));
    ?>

    <?php
    $criteria2 = new CDbCriteria();
    $criteria2->condition = "id_customer=:id_customer";
    $criteria2->params = array(":id_customer" => $model->id_customer);
    echo $form->dropDownListRow($model, 'id_order', CHtml::listData(Orders::model()->findAll($criteria2), 'id_order', 'secure_key'), array('prompt' => 'Chọn đơn hàng'));
    ?>

    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 255)); ?>

    <?php echo $form->markdownEditorRow($model, 'message', array('class' => 'span8', 'height' => '100px')); ?>

    <?php
    echo $form->toggleButtonRow($model, 'private', array(
        'enabledLabel' => 'Công khai',
        'disabledLabel' => 'Riêng tư'
            )
    );
    ?>

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
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'icon' => 'email white',
        'label' => $model->isNewRecord ? 'Tạo mới & Gửi thông tin đến khách hàng' : 'Lưu lại & Gửi thông tin đến khách hàng',
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