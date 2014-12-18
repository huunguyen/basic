<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'slider-form',
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
if(!$model->foradv):
?>
     <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_category', CHtml::listData(Category::model()->findAll($criteria), 'id_category', 'name'), array(
        'prompt' => 'Chọn Danh Mục',
        'onchange' => 'if(this.value!=""){
            $("#Slider_zoneadv").prop("disabled", true);
            $("#Slider_id_supplier").prop("disabled", true);
            $("#Slider_id_manufacturer").prop("disabled", true);
          }
          else {
            idsup = $("#Slider_id_supplier").val();
            idman = $("#Slider_id_manufacturer").val();
            if((idsup=="") & (idman=="")) $("#Slider_zoneadv").prop("disabled", false);
            $("#Slider_id_supplier").prop("disabled", false);
            $("#Slider_id_manufacturer").prop("disabled", false);
          }'
            )
    );
    ?>    

    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_supplier', CHtml::listData(Supplier::model()->findAll($criteria), 'id_supplier', 'name'), array(
        'prompt' => 'Chọn Nhà cung cấp',
        'onchange' => 'if(this.value!=""){
            $("#Slider_zoneadv").prop("disabled", true);
            $("#Slider_id_manufacturer").prop("disabled", true);
            $("#Slider_id_category").prop("disabled", true);
          }
          else {
            idcat = $("#Slider_id_category").val();
            idman = $("#Slider_id_manufacturer").val();
            if((idcat=="") & (idman=="")) $("#Slider_zoneadv").prop("disabled", false);
            $("#Slider_id_manufacturer").prop("disabled", false);
            $("#Slider_id_category").prop("disabled", false);
          }'
            )
    );
    ?>    
    <?php
    $criteria = new CDbCriteria();
    $criteria->condition = "active>=:active";
    $criteria->params = array(":active" => 1);
    $criteria->order = 'name DESC';
    echo $form->dropDownListRow($model, 'id_manufacturer', CHtml::listData(Manufacturer::model()->findAll($criteria), 'id_manufacturer', 'name'), array(
        'prompt' => 'Chọn Nhà sản xuất',
        'onchange' => 'if(this.value!=""){
            $("#Slider_zoneadv").prop("disabled", true);
            $("#Slider_id_supplier").prop("disabled", true);
            $("#Slider_id_category").prop("disabled", true);
          }
          else {
            idcat = $("#Slider_id_category").val();
            idsup = $("#Slider_id_supplier").val();
            if((idcat=="") & (idsup=="")) $("#Slider_zoneadv").prop("disabled", false);
            $("#Slider_id_supplier").prop("disabled", false);
            $("#Slider_id_category").prop("disabled", false);
          }'
            )
    );
    ?>   
    <?php
endif;
?>
   
    <?php
    echo $form->dropDownListRow($model, 'zoneadv', Lookup::items('ZoneAdv'), 
            array('prompt' => 'Chọn Một Loại Trình diễn',
                'onchange' => 'if(this.value==""){
          $("#Slider_id_category").prop("disabled", false);
          $("#Slider_id_supplier").prop("disabled", false);
          $("#Slider_id_manufacturer").prop("disabled", false);
          }
          else {
          $("#Slider_id_category").prop("disabled", true);
          $("#Slider_id_supplier").prop("disabled", true);
          $("#Slider_id_manufacturer").prop("disabled", true);
          }'
                ));
    ?>  
   	<?php echo $form->textFieldRow($model,'height',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'width',array('class'=>'span5','maxlength'=>10)); ?>
    
 <?php
    echo $form->dropDownListRow($model, 'fill', Lookup::items('FillType'), array('prompt' => 'Chọn loại liên kết'));
    ?>   
	<?php echo $form->textFieldRow($model,'duration',array('class'=>'span5','maxlength'=>10)); ?>

<?php
    echo $form->toggleButtonRow($model, 'auto', array(
        'enabledLabel' => 'Cho phép xuất bản',
        'disabledLabel' => 'Không cho phép xuất bản'
            )
    );
    ?>
	<?php echo $form->textFieldRow($model,'continuous',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'controls',array('class'=>'span5')); ?>

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