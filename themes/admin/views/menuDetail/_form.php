<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'menu-detail-form',
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
    if(!isset($parent)){
            $criteria = new CDbCriteria();
            $criteria->condition = "active>=:active and type=:type";
            $criteria->params = array(":active" => 1, ":type" => 'category');
            $criteria->order = 'title DESC';
            echo $form->dropDownListRow($model, 'id_parent', CHtml::listData(MenuDetail::model()->findAll($criteria), 'id_menu_detail', 'title'), array(
                'prompt' => 'Chọn Liên kết cha',
                    )
            );
    }
    ?>   
    
    <?php
    echo $form->dropDownListRow($model, 'type', Lookup::items('SubMenuType'), array('prompt' => 'Chọn loại liên kết'));
    ?>   
    
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span5', 'maxlength' => 45)); ?>
    
    <?php echo $form->textFieldRow($model, 'link', array('class' => 'span5', 'maxlength' => 45)); ?>
    
    <?php echo $form->textFieldRow($model, 'position', array('class' => 'span5', 'maxlength' => 45)); ?>

    <?php
    echo $form->toggleButtonRow($model, 'active', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>


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