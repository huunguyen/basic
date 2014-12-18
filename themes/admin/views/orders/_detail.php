<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'detail-form',
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
    echo $form->dropDownListRow($model, 'id_warehouse', CHtml::listData(
                    Warehouse::model()->findAll(
                            array('order' => 'id_warehouse',
                                'condition' => 'active>=:active',
                                'params' => array(':active' => 1)
                            )
                    ), 'id_warehouse', 'name'), array('prompt' => 'Chọn Kho Hàng'));
    ?>   
	<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'reduction_percent',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'reduction_amount',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'supplier_reference',array('class'=>'span5','maxlength'=>32)); ?>

	<?php echo $form->textFieldRow($model,'total_price_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'unit_price_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'total_shipping_price_tax_incl',array('class'=>'span5','maxlength'=>20)); ?>

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
