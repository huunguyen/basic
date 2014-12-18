<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'city-form',
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

<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>	
 <?php
 $criteria = new CDbCriteria();
$criteria->select = 'style';
$criteria->group = 'style';
$criteria->order = 'style DESC';
    echo $form->dropDownListRow($model, 'style', CHtml::listData(City::model()->findAll($criteria), 'style', 'style_name'), 
            array(
        'prompt' => 'Chọn Vùng Hổ Trợ'
            )
    );
    ?>    
<?php echo $form->textFieldRow($model,'iso_code',array('class'=>'span5','maxlength'=>7)); ?>

	    <?php
    echo $form->toggleButtonRow($model, 'active', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>
<?php echo $form->textFieldRow($model,'call_prefix',array('class'=>'span5','maxlength'=>10)); ?>
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